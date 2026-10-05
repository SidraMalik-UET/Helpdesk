<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketCategory;
use App\Models\User;
use App\Notifications\TicketCreated;
use App\Notifications\TicketReplied;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function create()
    {
        $categories = TicketCategory::orderBy('name')->get();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:ticket_categories,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'attachment' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:5120',
            ],
        ]);

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'open',
        ]);

        // Save original ticket attachment if uploaded
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('ticket-attachments', 'public');

            TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'reply_id' => null,
                'user_id' => auth()->id(),
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType() ?: $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        // Notify all administrators about the new ticket.
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new TicketCreated($ticket));
        }

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket created successfully!');
    }

    public function index()
    {
        $user = auth()->user();

        // Agents can see tickets assigned to them or created by them; customers see their own
        if ($user->role === 'agent') {
            $tickets = Ticket::where(function ($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('user_id', $user->id);
            })->latest()->get();
        } else {
            $tickets = Ticket::where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $user = auth()->user();

        // Check who is allowed to view the ticket.
        $isOwner = (int) $ticket->user_id === (int) $user->id;
        $isAssignedAgent = (int) $ticket->assigned_to === (int) $user->id;
        $isAdmin = $user->role === 'admin';

        if (!$isOwner && !$isAssignedAgent && !$isAdmin) {
            abort(403, 'Unauthorized access to this ticket.');
        }

        // Load related data needed by the ticket detail page.
        $ticket->load([
            'category',
            'assignedAgent',
            'replies.user',
            'replies.attachments',
            'attachments',
        ]);

        return view('tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $user = auth()->user();

        // Only the owner, assigned agent or admin can reply.
        $isOwner = (int) $ticket->user_id === (int) $user->id;
        $isAssignedAgent = (int) $ticket->assigned_to === (int) $user->id;
        $isAdmin = $user->role === 'admin';

        if (!$isOwner && !$isAssignedAgent && !$isAdmin) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',

            'attachment' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:5120',
            ],
        ]);

        // Save the reply.
        $reply = $ticket->replies()->create([
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        // Save the uploaded attachment, if provided.
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $path = $file->store('ticket-attachments', 'public');

            TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'reply_id' => $reply->id,
                'user_id' => $user->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType() ?: $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        // Send notification to relevant party
        if ((int) $user->id !== (int) $ticket->user_id) {
            // Staff replied: notify customer
            if ($ticket->user) {
                $ticket->user->notify(new TicketReplied($ticket));
            }
        } elseif ($ticket->assigned_to && $ticket->assignedAgent) {
            // Customer replied: notify assigned agent
            $ticket->assignedAgent->notify(new TicketReplied($ticket));
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Reply added successfully!');
    }

    public function showAttachment(
        Ticket $ticket,
        TicketAttachment $attachment
    ) {
        // Ensure the attachment belongs to the requested ticket.
        abort_unless(
            (int) $attachment->ticket_id === (int) $ticket->id,
            404,
            'Attachment does not belong to this ticket.'
        );

        $user = auth()->user();

        // Verify user permission: owner, assigned agent, admin, or uploader
        $isOwner = (int) $ticket->user_id === (int) $user->id;
        $isAssignedAgent = (int) $ticket->assigned_to === (int) $user->id;
        $isAdmin = $user->role === 'admin';
        $isUploader = (int) $attachment->user_id === (int) $user->id;

        abort_unless(
            $isOwner || $isAssignedAgent || $isAdmin || $isUploader,
            403,
            'You are not authorized to view this attachment.'
        );

        $disk = Storage::disk('public');
        $path = $attachment->file_path;

        // Check public disk first, fallback to local disk
        if (!$disk->exists($path) && Storage::disk('local')->exists($path)) {
            $disk = Storage::disk('local');
        }

        // Confirm that the physical file exists.
        abort_unless(
            $disk->exists($path),
            404,
            'The requested attachment file could not be found on storage.'
        );

        $filePath = $disk->path($path);

        // Determine accurate MIME type
        $mimeType = $attachment->file_type;
        if (empty($mimeType) || $mimeType === 'application/octet-stream') {
            $extension = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
            $mimeTypes = [
                'jpg'  => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png'  => 'image/png',
                'gif'  => 'image/gif',
                'webp' => 'image/webp',
                'svg'  => 'image/svg+xml',
                'pdf'  => 'application/pdf',
                'doc'  => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'txt'  => 'text/plain',
            ];
            $mimeType = $mimeTypes[$extension] ?? (mime_content_type($filePath) ?: 'application/octet-stream');
        }

        // If download requested explicitly
        if (request()->has('download')) {
            return response()->download($filePath, $attachment->file_name, [
                'Content-Type' => $mimeType,
            ]);
        }

        // Display images and supported documents inline in the browser.
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' .
                addcslashes(basename($attachment->file_name), '"\\') . '"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function conversations()
    {
        $user = auth()->user();

        if ($user->role === 'agent') {
            $tickets = Ticket::where(function ($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('user_id', $user->id);
            })->with(['category', 'replies.user'])->latest()->get();
        } else {
            $tickets = Ticket::where('user_id', $user->id)
                ->with(['category', 'replies.user'])
                ->latest()
                ->get();
        }

        return view('tickets.conversations', compact('tickets'));
    }
}