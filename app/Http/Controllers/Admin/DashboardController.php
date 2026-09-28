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
        $usersCount = User::count();

        $categoriesCount = TicketCategory::count();

        $ticketsCount = Ticket::count();

        $activeUsersCount = User::where('status', 'active')->count();

        return view('admin.dashboard', compact(
            'usersCount',
            'categoriesCount',
            'ticketsCount',
            'activeUsersCount'
        ));
    }
}