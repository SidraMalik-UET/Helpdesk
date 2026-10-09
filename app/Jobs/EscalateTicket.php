<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketEscalated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class EscalateTicket implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    public $backoff = 10;

    public function __construct(public int $ticketId)
    {
    }

    public function handle(): void
    {
        $ticket = Ticket::with('assignedAgent')->find($this->ticketId);

        if (!$ticket || $ticket->escalated_at) {
            return;
        }

        if (!in_array($ticket->status, ['open', 'in_progress'])) {
            return;
        }

        $hasAgentResponse = $ticket->replies()
            ->whereHas('user', function ($query) {
                $query->whereIn('role', ['agent', 'admin']);
            })
            ->exists();

        if ($hasAgentResponse) {
            return;
        }

        if ($ticket->assignedAgent) {
            $ticket->assignedAgent->notify(
                new TicketEscalated($ticket)
            );
        }

        User::where('role', 'admin')
            ->where('status', 'active')
            ->get()
            ->each(function ($admin) use ($ticket) {
                $admin->notify(new TicketEscalated($ticket));
            });

        $ticket->escalated_at = now();
        $ticket->save();
    }
}
