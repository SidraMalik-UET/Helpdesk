<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketAssigned;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display all tickets.
     */
    public function index()
    {
        $tickets = Ticket::with([
            'user',
            'category',
            'assignedAgent'
        ])
            ->latest()
            ->get();

        $agents = User::where('role', 'agent')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'admin.tickets.index',
            compact('tickets', 'agents')
        );
    }

    /**
     * Display a single ticket for the admin.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load([
            'user',
            'category',
            'replies.user',
            'replies.attachments',
            'attachments',
            'assignedAgent',
        ]);

        $agents = User::where('role', 'agent')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'admin.tickets.show',
            compact('ticket', 'agents')
        );
    }

    /**
     * Assign a ticket to an active agent.
     */
    public function assign(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        // Make sure the selected user is actually
        // an active agent.
        $agent = User::where('id', $validated['assigned_to'])
            ->where('role', 'agent')
            ->where('status', 'active')
            ->firstOrFail();

        // Assign the ticket to the agent.
        $ticket->assigned_to = $agent->id;
        $ticket->save();

        // Notify the assigned agent.
        $agent->notify(new TicketAssigned($ticket));

        return back()->with(
            'success',
            'Ticket assigned to ' . $agent->name . ' successfully.'
        );
    }
}

