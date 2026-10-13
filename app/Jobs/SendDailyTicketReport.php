<?php

namespace App\Jobs;

use App\Mail\DailyTicketReportMail;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendDailyTicketReport implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $today = now()->startOfDay();
        $now = now();

        // Tickets created today
        $opened = Ticket::where('created_at', '>=', $today)
            ->where('created_at', '<=', $now)
            ->count();

        // Tickets resolved today
        $resolved = Ticket::where('status', 'resolved')
            ->whereBetween('updated_at', [$today, $now])
            ->count();

        // Tickets overdue for a response
        $overdue = Ticket::whereIn('status', ['open', 'in_progress'])
            ->whereNull('escalated_at')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('priority', 'urgent')
                        ->where('created_at', '<=', now()->subMinutes(15));
                })->orWhere(function ($q) {
                    $q->where('priority', 'high')
                        ->where('created_at', '<=', now()->subHour());
                })->orWhere(function ($q) {
                    $q->where('priority', 'medium')
                        ->where('created_at', '<=', now()->subHours(4));
                })->orWhere(function ($q) {
                    $q->where('priority', 'low')
                        ->where('created_at', '<=', now()->subHours(8));
                });
            })
            ->count();

        // Average time until first agent/admin response, in minutes
        $responseTimes = Ticket::query()
            ->whereHas('replies', function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->whereIn('role', ['agent', 'admin']);
                });
            })
            ->with(['replies' => function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->whereIn('role', ['agent', 'admin']);
                })->orderBy('created_at');
            }])
            ->get()
            ->map(function ($ticket) {
                $firstReply = $ticket->replies->first();

                return $firstReply
                    ? $ticket->created_at->diffInMinutes($firstReply->created_at)
                    : null;
            })
            ->filter(fn ($minutes) => $minutes !== null);

        $averageResponseTime = $responseTimes->isNotEmpty()
            ? round($responseTimes->avg(), 2)
            : 0;

        // Prepare report data
        $report = [
            'date' => now()->toDateString(),
            'opened' => $opened,
            'resolved' => $resolved,
            'overdue' => $overdue,
            'average_response_minutes' => $averageResponseTime,
        ];

        // Get all active admins
        $admins = User::where('role', 'admin')
            ->where('status', 'active')
            ->get();

        // Send the daily report to each active admin
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(
                new DailyTicketReportMail($report)
            );
        }

        // Log report sending information
        logger()->info('Daily Ticket Report sent', [
            'date' => $report['date'],
            'admin_count' => $admins->count(),
        ]);
    }
}
