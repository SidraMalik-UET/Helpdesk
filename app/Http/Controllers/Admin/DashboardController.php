<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Total users in the system
        $usersCount = User::count();

        // Total ticket categories
        $categoriesCount = TicketCategory::count();

        // Total tickets
        $ticketsCount = Ticket::count();

        // Users whose account is currently active
        $activeUsersCount = User::where('status', 'active')->count();

        // Ticket status counts
        $openTicketsCount = Ticket::where('status', 'open')->count();

        $inProgressTicketsCount = Ticket::where(
            'status',
            'in_progress'
        )->count();

        $resolvedTicketsCount = Ticket::where(
            'status',
            'resolved'
        )->count();

        $closedTicketsCount = Ticket::where(
            'status',
            'closed'
        )->count();

        return view('admin.dashboard', compact(
            'usersCount',
            'categoriesCount',
            'ticketsCount',
            'activeUsersCount',
            'openTicketsCount',
            'inProgressTicketsCount',
            'resolvedTicketsCount',
            'closedTicketsCount'
        ));
    }
}
