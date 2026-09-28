```php
<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HelpDeskController;
use App\Http\Controllers\TicketController;
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
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Tickets
    |--------------------------------------------------------------------------
    */

    // My Tickets
    Route::get('/tickets', [TicketController::class, 'index'])
        ->name('tickets.index');


    // Create Ticket Form
    Route::get('/tickets/create', [TicketController::class, 'create'])
        ->name('tickets.create');


    // Save New Ticket
    Route::post('/tickets', [TicketController::class, 'store'])
        ->name('tickets.store');


    // View Single Ticket
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])
        ->name('tickets.show');


    // Add Reply
    Route::post('/tickets/{ticket}/reply', [TicketController::class, 'reply'])
        ->name('tickets.reply');


    // View / Open Attachment
    Route::get(
        '/tickets/{ticket}/attachments/{attachment}',
        [TicketController::class, 'showAttachment']
    )->name('tickets.attachments.show');

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
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        // Users CRUD
        Route::resource('users', UserController::class);


        // Categories CRUD
        Route::resource('categories', CategoryController::class);

    });

