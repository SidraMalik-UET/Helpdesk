<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelpDeskController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Root redirect
Route::get('/', function () {
    return redirect()->route('helpdesk');
});

// HelpDesk Home
Route::get('/helpdesk', [HelpDeskController::class, 'index'])
    ->name('helpdesk');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register.form');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dynamic Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // Ticket Conversations
    Route::get('/ticket-conversations', [TicketController::class, 'conversations'])
        ->name('tickets.conversations');


    // My Account / Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])
        ->name('notifications.read');

    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.markAllAsRead');

    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])
        ->name('notifications.unreadCount');


    /*
    |--------------------------------------------------------------------------
    | Customer Tickets
    |--------------------------------------------------------------------------
    */

    // Create a ticket
    Route::get('/tickets/create', [TicketController::class, 'create'])
        ->name('tickets.create');

    // Store a new ticket
    Route::post('/tickets', [TicketController::class, 'store'])
        ->name('tickets.store');

    // List customer tickets
    Route::get('/tickets', [TicketController::class, 'index'])
        ->name('tickets.index');

    // Show a ticket and its conversation
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])
        ->name('tickets.show');

    // Reply to a ticket
    Route::post('/tickets/{ticket}/reply', [TicketController::class, 'reply'])
        ->name('tickets.reply');

    // View or download ticket attachments
    Route::get(
        '/tickets/{ticket}/attachments/{attachment}',
        [TicketController::class, 'showAttachment']
    )->name('tickets.attachments.show');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');


        // Admin Users
        Route::resource('/users', UserController::class);


        // Admin Categories
        Route::resource('/categories', CategoryController::class);


        /*
        |--------------------------------------------------------------------------
        | Admin Tickets
        |--------------------------------------------------------------------------
        */

        // Show all admin tickets
        Route::get(
            '/tickets',
            [AdminTicketController::class, 'index']
        )->name('tickets.index');

        // Show one admin ticket
        Route::get(
            '/tickets/{ticket}',
            [AdminTicketController::class, 'show']
        )->name('tickets.show');

        // Assign ticket to an active agent
        Route::post(
            '/tickets/{ticket}/assign',
            [AdminTicketController::class, 'assign']
        )->name('tickets.assign');
    });

