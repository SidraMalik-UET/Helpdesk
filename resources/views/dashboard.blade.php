@extends('layouts.app')

@section('title', 'Dashboard - HelpDesk')

@section('content')

<style>
    .dashboard-page {
        padding: 45px 0 70px;
        background: #f5f7fb;
        min-height: calc(100vh - 80px);
    }

    .dashboard-container {
        width: 90%;
        max-width: 1100px;
        margin: 0 auto;
    }

    .dashboard-header {
        margin-bottom: 28px;
    }

    .dashboard-header h1 {
        font-size: 34px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
    }

    .dashboard-header p {
        color: #6b7280;
        font-size: 15px;
        margin: 0;
    }

    .welcome-box {
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        color: white;
        padding: 30px 35px;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .welcome-box h2 {
        font-size: 26px;
        font-weight: 700;
        margin: 0 0 6px;
    }

    .welcome-box p {
        margin: 0;
        opacity: 0.92;
        font-size: 15px;
    }

    .welcome-action {
        display: inline-block;
        background: white;
        color: #1e3a8a;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .welcome-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: white;
        padding: 22px 24px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(17, 24, 39, 0.06);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .stat-icon-blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-icon-amber {
        background: #fffbeb;
        color: #d97706;
    }

    .stat-icon-green {
        background: #ecfdf5;
        color: #059669;
    }

    .stat-icon-red {
        background: #fef2f2;
        color: #dc2626;
    }

    .stat-info {
        flex: 1;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        line-height: 1.1;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 600;
        margin-top: 4px;
    }

    /* Actions Grid */
    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }

    .action-card {
        background: white;
        padding: 26px 24px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(17, 24, 39, 0.08);
        border-color: #93b4ff;
    }

    .action-card:focus-visible {
        outline: 3px solid #2563eb;
        outline-offset: 3px;
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .card-icon {
        width: 48px;
        height: 48px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .badge-count {
        background: #dc2626;
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .action-card h3 {
        font-size: 18px;
        color: #111827;
        margin: 0 0 8px;
    }

    .action-card p {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.5;
        margin: 0 0 16px;
    }

    .card-link {
        color: #2563eb;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Recent Tickets Section */
    .recent-tickets-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .recent-header {
        padding: 22px 28px;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .recent-header h2 {
        font-size: 18px;
        margin: 0;
        color: #111827;
    }

    .view-all-link {
        color: #2563eb;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
    }

    .view-all-link:hover {
        text-decoration: underline;
    }

    .ticket-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .ticket-table th {
        background: #fafbfc;
        padding: 14px 24px;
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #eef2f7;
    }

    .ticket-table td {
        padding: 16px 24px;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .ticket-table tr:last-child td {
        border-bottom: none;
    }

    .ticket-table tr:hover {
        background: #f8fafc;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .badge-open {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .badge-in_progress {
        background: #fffbeb;
        color: #b45309;
    }

    .badge-resolved {
        background: #ecfdf5;
        color: #047857;
    }

    .badge-closed {
        background: #f3f4f6;
        color: #4b5563;
    }

    .priority-indicator {
        font-weight: 600;
    }

    .priority-urgent {
        color: #dc2626;
    }

    .priority-high {
        color: #ea580c;
    }

    .priority-medium {
        color: #ca8a04;
    }

    .priority-low {
        color: #16a34a;
    }

    .empty-state {
        padding: 55px 25px;
        text-align: center;
    }

    .empty-icon {
        font-size: 42px;
        margin-bottom: 12px;
    }

    .empty-state h3 {
        font-size: 20px;
        color: #111827;
        margin: 0 0 6px;
    }

    .empty-state p {
        color: #6b7280;
        font-size: 14px;
        margin: 0 0 18px;
    }

    .btn-create-empty {
        display: inline-block;
        background: #111827;
        color: white;
        padding: 11px 22px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .btn-create-empty:hover {
        background: #2563eb;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 650px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .actions-grid {
            grid-template-columns: 1fr;
        }

        .welcome-box {
            padding: 22px;
        }

        .welcome-box h2 {
            font-size: 22px;
        }

        .ticket-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<section class="dashboard-page">
    <div class="dashboard-container">

        <div class="dashboard-header">
            <h1>Dashboard</h1>
            <p>Welcome to your personal support portal. Track and manage all your tickets and conversations.</p>
        </div>

        {{-- Welcome Banner --}}
        <div class="welcome-box">
            <div>
                <h2>Welcome back, {{ auth()->user()->name }} 👋</h2>
                <p>
                    @if(auth()->user()->role === 'admin')
                        You have Administrator privileges. You can manage tickets, categories, and users.
                    @elseif(auth()->user()->role === 'agent')
                        You are logged in as an Agent. View tickets assigned to you or respond to customer inquiries.
                    @else
                        You are successfully logged in. Need help with an issue? Submit a ticket below.
                    @endif
                </p>
            </div>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="welcome-action">
                    Admin Panel →
                </a>
            @else
                <a href="{{ route('tickets.create') }}" class="welcome-action">
                    + New Support Ticket
                </a>
            @endif
        </div>

        {{-- Dynamic Statistics --}}
        <div class="stats-grid">
            {{-- Total Tickets --}}
            <div class="stat-card">
                <div class="stat-icon stat-icon-blue">
                    🎫
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $totalTickets }}</div>
                    <div class="stat-label">Total Tickets</div>
                </div>
            </div>

            {{-- Open Tickets --}}
            <div class="stat-card">
                <div class="stat-icon stat-icon-amber">
                    ⏳
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $openTickets }}</div>
                    <div class="stat-label">Open / In Progress</div>
                </div>
            </div>

            {{-- Resolved Tickets --}}
            <div class="stat-card">
                <div class="stat-icon stat-icon-green">
                    ✅
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $resolvedTickets }}</div>
                    <div class="stat-label">Resolved / Closed</div>
                </div>
            </div>

            {{-- Unread Notifications --}}
            <div class="stat-card">
                <div class="stat-icon stat-icon-red">
                    🔔
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $unreadNotifications }}</div>
                    <div class="stat-label">Unread Notifications</div>
                </div>
            </div>
        </div>

        {{-- Quick Actions / Connected Features --}}
        <h2 class="section-title">Quick Actions & Features</h2>

        <div class="actions-grid">

            {{-- 1. Create Ticket --}}
            <a href="{{ route('tickets.create') }}" class="action-card">
                <div>
                    <div class="card-top">
                        <div class="card-icon">➕</div>
                    </div>
                    <h3>Create Ticket</h3>
                    <p>Submit a new support ticket and get help from our dedicated support team.</p>
                </div>
                <span class="card-link">
                    Create Ticket →
                </span>
            </a>

            {{-- 2. My Tickets --}}
            <a href="{{ route('tickets.index') }}" class="action-card">
                <div>
                    <div class="card-top">
                        <div class="card-icon">📋</div>
                        <span style="font-size:13px;color:#6b7280;font-weight:600;">{{ $totalTickets }} Total</span>
                    </div>
                    <h3>My Tickets</h3>
                    <p>View all your submitted tickets, monitor status changes, and track progress.</p>
                </div>
                <span class="card-link">
                    View My Tickets →
                </span>
            </a>

            {{-- 3. View Conversations --}}
            <a href="{{ route('tickets.conversations') }}" class="action-card">
                <div>
                    <div class="card-top">
                        <div class="card-icon">💬</div>
                    </div>
                    <h3>View Conversations</h3>
                    <p>Read ongoing replies and communicate directly with assigned support agents.</p>
                </div>
                <span class="card-link">
                    View Conversations →
                </span>
            </a>

            {{-- 4. Notifications --}}
            <a href="{{ route('notifications.index') }}" class="action-card">
                <div>
                    <div class="card-top">
                        <div class="card-icon">🔔</div>
                        @if($unreadNotifications > 0)
                            <span class="badge-count">{{ $unreadNotifications }} New</span>
                        @endif
                    </div>
                    <h3>Notifications</h3>
                    <p>Review system alerts, ticket updates, and replies to stay informed on your inquiries.</p>
                </div>
                <span class="card-link">
                    View Notifications →
                </span>
            </a>

            {{-- 5. My Account --}}
            <a href="{{ route('profile.edit') }}" class="action-card">
                <div>
                    <div class="card-top">
                        <div class="card-icon">👤</div>
                    </div>
                    <h3>My Account</h3>
                    <p>Manage your account settings, update contact information, or change your password.</p>
                </div>
                <span class="card-link">
                    Manage Account →
                </span>
            </a>

            {{-- 6. Help & Documentation / Support Home --}}
            <a href="{{ route('helpdesk') }}" class="action-card">
                <div>
                    <div class="card-top">
                        <div class="card-icon">🌐</div>
                    </div>
                    <h3>HelpDesk Home</h3>
                    <p>Return to the main HelpDesk landing page and explore available support resources.</p>
                </div>
                <span class="card-link">
                    Visit HelpDesk →
                </span>
            </a>

        </div>

        {{-- Recent Tickets Overview --}}
        <div class="recent-tickets-card">
            <div class="recent-header">
                <h2>Recent Tickets</h2>
                @if($recentTickets->isNotEmpty())
                    <a href="{{ route('tickets.index') }}" class="view-all-link">
                        View All Tickets ({{ $totalTickets }}) →
                    </a>
                @endif
            </div>

            @if($recentTickets->isNotEmpty())
                <table class="ticket-table">
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTickets as $ticket)
                            <tr>
                                <td>
                                    <strong>#{{ $ticket->id }}</strong> — {{ \Illuminate\Support\Str::limit($ticket->subject, 40) }}
                                </td>
                                <td>{{ $ticket->category?->name ?? 'General' }}</td>
                                <td>
                                    <span class="priority-indicator priority-{{ strtolower($ticket->priority) }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge badge-{{ strtolower($ticket->status) }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td>{{ $ticket->created_at->format('d M Y') }}</td>
                                <td style="text-align: right;">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="card-link">
                                        View →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3>No support tickets found</h3>
                    <p>You haven't submitted any support requests yet. Have a question or facing an issue?</p>
                    <a href="{{ route('tickets.create') }}" class="btn-create-empty">
                        Create Your First Ticket
                    </a>
                </div>
            @endif
        </div>

    </div>
</section>

@endsection
