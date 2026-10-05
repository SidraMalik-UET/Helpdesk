<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dynamic customer/user dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Keep customer data private; agents see assigned or created tickets; admins see all
        if ($user->role === 'agent') {
            $ticketsQuery = Ticket::where(function ($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('user_id', $user->id);
            });
        } elseif ($user->role === 'admin') {
            $ticketsQuery = Ticket::query();
        } else {
            $ticketsQuery = Ticket::where('user_id', $user->id);
        }

        $totalTickets = (clone $ticketsQuery)->count();
        $openTickets = (clone $ticketsQuery)->whereIn('status', ['open', 'in_progress'])->count();
        $resolvedTickets = (clone $ticketsQuery)->whereIn('status', ['resolved', 'closed'])->count();
        $unreadNotifications = $user->unreadNotifications()->count();

        // Latest tickets for the dashboard overview
        $recentTickets = (clone $ticketsQuery)
            ->with(['category', 'assignedAgent'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalTickets',
            'openTickets',
            'resolvedTickets',
            'unreadNotifications',
            'recentTickets'
        ));
    }
}
