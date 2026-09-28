<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

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
            'priority' => 'required|in:low,medium,high',
        ]);

        Ticket::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'open',
        ]);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket created successfully!');
    }

    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        // Only the ticket owner can view the ticket
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        // Load category, replies, users and attachments
        $ticket->load([
            'category',
            'replies.user',
            'replies.attachments',
        ]);

        return view('tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',

            'attachment' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:5120',
            ],
        ]);

        // Create the reply first
        $reply = $ticket->replies()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        // If a file was selected, upload it
        if ($request->hasFile('attachment')) {

            $file = $request->file('attachment');

            // Store the file in storage/app/public/ticket-attachments
            $path = $file->store('ticket-attachments', 'public');

            // Save attachment information in database
            TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'reply_id' => $reply->id,
                'user_id' => auth()->id(),
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Reply added successfully!');
    }

    public function showAttachment(Ticket $ticket, TicketAttachment $attachment)
    {
        // Make sure the attachment belongs to this ticket
        if ($attachment->ticket_id !== $ticket->id) {
            abort(404);
        }

        // Only the ticket owner can access its attachments
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        // Get the actual file path
        $path = storage_path('app/public/' . $attachment->file_path);

        // Make sure the file actually exists
        if (!file_exists($path)) {
            abort(404, 'Attachment file not found.');
        }

        // Display the file in the browser
        return response()->file($path);
    }
}