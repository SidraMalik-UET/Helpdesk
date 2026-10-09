<?php

namespace App\Console\Commands;

use App\Jobs\EscalateTicket;
use App\Models\Ticket;
use Illuminate\Console\Command;

class CheckTicketSla extends Command
{
    protected $signature = 'tickets:check-sla';

    protected $description = 'Find tickets that have exceeded their first-response SLA';

    public function handle(): int
    {
        $slaMinutes = [
            'urgent' => 15,
            'high' => 60,
            'medium' => 240,
            'low' => 480,
        ];

        foreach ($slaMinutes as $priority => $minutes) {
            Ticket::query()
                ->whereIn('status', ['open', 'in_progress'])
                ->where('priority', $priority)
                ->whereNull('escalated_at')
                ->where('created_at', '<=', now()->subMinutes($minutes))
                ->whereDoesntHave('replies', function ($query) {
                    $query->whereHas('user', function ($userQuery) {
                        $userQuery->whereIn('role', ['agent', 'admin']);
                    });
                })
                ->select('id')
                ->chunkById(100, function ($tickets) {
                    foreach ($tickets as $ticket) {
                        EscalateTicket::dispatch($ticket->id);
                    }
                });
        }

        $this->info('SLA monitoring completed.');

        return self::SUCCESS;
    }
}
