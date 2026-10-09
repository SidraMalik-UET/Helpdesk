<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketAssigned;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessNewTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public $backoff = 10;

    public function __construct(public int $ticketId)
    {
    }

    public function handle(): void
    {
        $assignment = DB::transaction(function () {
            $ticket = Ticket::whereKey($this->ticketId)
                ->lockForUpdate()
                ->first();

            if (!$ticket || $ticket->assigned_to) {
                return null;
            }

            $agent = User::where('role', 'agent')
                ->where('status', 'active')
                ->withCount([
                    'assignedTickets as active_tickets_count' => function ($query) {
                        $query->whereIn('status', ['open', 'in_progress']);
                    }
                ])
                ->orderBy('active_tickets_count')
                ->orderBy('id')
                ->first();

            if (!$agent) {
                return null;
            }

            $ticket->assigned_to = $agent->id;
            $ticket->save();

            return [
                'ticket_id' => $ticket->id,
                'agent_id' => $agent->id,
            ];
        });

        if (!$assignment) {
            return;
        }

        $ticket = Ticket::findOrFail($assignment['ticket_id']);
        $agent = User::findOrFail($assignment['agent_id']);

        $agent->notify(new TicketAssigned($ticket));
    }
}