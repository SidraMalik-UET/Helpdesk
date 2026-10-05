@extends('admin.layout')

@section('content')

<style>
    /* =========================
       ADMIN DASHBOARD
    ========================= */

    .admin-dashboard {
        padding: 35px 0 60px;
    }

    .admin-dashboard-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }


    /* =========================
       DASHBOARD HEADER
    ========================= */

    .dashboard-header {
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        margin: 0 0 8px;
        font-size: 34px;
        font-weight: 700;
        color: #111827;
    }

    .dashboard-header p {
        margin: 0;
        color: #6b7280;
        font-size: 15px;
    }


    /* =========================
       WELCOME BOX
    ========================= */

    .admin-welcome-box {
        background: linear-gradient(
            135deg,
            #243f91,
            #347ce8
        );

        color: white;

        border-radius: 18px;

        padding: 35px 40px;

        margin-bottom: 30px;

        box-shadow:
            0 12px 30px rgba(37, 99, 235, 0.16);
    }

    .admin-welcome-box h2 {
        margin: 0 0 10px;

        font-size: 28px;
        font-weight: 700;
    }

    .admin-welcome-box p {
        margin: 0;

        font-size: 15px;

        opacity: 0.95;
    }


    /* =========================
       STATISTICS CARDS
    ========================= */

    .stats-grid {
        display: grid;

        grid-template-columns:
            repeat(4, 1fr);

        gap: 20px;

        margin-bottom: 35px;
    }

    .stat-card {
        background: white;

        border: 1px solid #e5e7eb;

        border-radius: 16px;

        padding: 22px;

        display: flex;

        align-items: center;

        gap: 16px;

        box-shadow:
            0 5px 18px rgba(15, 23, 42, 0.05);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);

        box-shadow:
            0 10px 25px rgba(15, 23, 42, 0.08);
    }

    .stat-icon {
        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 12px;

        font-size: 22px;
    }

    .stat-icon.blue {
        background: #eaf2ff;
    }

    .stat-icon.purple {
        background: #f3efff;
    }

    .stat-icon.green {
        background: #eafaf2;
    }

    .stat-icon.orange {
        background: #fff4e8;
    }

    .stat-label {
        display: block;

        margin-bottom: 4px;

        font-size: 13px;

        color: #6b7280;
    }

    .stat-card h2 {
        margin: 0 0 3px;

        font-size: 27px;

        color: #111827;
    }

    .stat-description {
        font-size: 11px;

        color: #9ca3af;
    }


    /* =========================
       SECTION HEADING
    ========================= */

    .section-heading {
        margin-bottom: 18px;
    }

    .section-heading h2 {
        margin: 0 0 5px;

        font-size: 22px;

        color: #111827;
    }

    .section-heading p {
        margin: 0;

        font-size: 13px;

        color: #6b7280;
    }


    /* =========================
       MANAGEMENT / QUICK ACTIONS
    ========================= */

    .dashboard-grid {
        display: grid;

        grid-template-columns:
            1fr 1fr;

        gap: 20px;

        margin-bottom: 35px;
    }

    .dashboard-panel {
        background: white;

        border: 1px solid #e5e7eb;

        border-radius: 16px;

        overflow: hidden;

        box-shadow:
            0 5px 18px rgba(15, 23, 42, 0.04);
    }

    .panel-header {
        padding: 22px;

        border-bottom:
            1px solid #e5e7eb;
    }

    .panel-header h2 {
        margin: 0 0 5px;

        font-size: 18px;

        color: #111827;
    }

    .panel-header p {
        margin: 0;

        color: #6b7280;

        font-size: 13px;
    }

    .quick-actions {
        padding: 8px 15px;
    }

    .quick-action {
        display: flex;

        align-items: center;

        gap: 13px;

        padding: 15px 8px;

        text-decoration: none;

        color: #172033;

        border-bottom:
            1px solid #f1f5f9;

        transition:
            background 0.2s ease,
            padding-left 0.2s ease;
    }

    .quick-action:last-child {
        border-bottom: none;
    }

    .quick-action:hover {
        background: #f8fafc;

        padding-left: 12px;
    }

    .quick-icon {
        width: 42px;
        height: 42px;

        flex-shrink: 0;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: #eff6ff;

        font-size: 19px;
    }

    .quick-action strong {
        display: block;

        margin-bottom: 3px;

        font-size: 14px;

        color: #111827;
    }

    .quick-action span {
        display: block;

        font-size: 12px;

        color: #6b7280;
    }

    .quick-action b {
        margin-left: auto;

        color: #9ca3af;

        font-size: 18px;
    }


    /* =========================
       SYSTEM OVERVIEW
    ========================= */

    .overview-list {
        padding: 8px 22px;
    }

    .overview-item {
        display: flex;

        align-items: center;

        justify-content: space-between;

        padding: 17px 0;

        border-bottom:
            1px solid #f1f5f9;
    }

    .overview-item:last-child {
        border-bottom: none;
    }

    .overview-item strong {
        display: block;

        margin-bottom: 4px;

        font-size: 14px;

        color: #111827;
    }

    .overview-item span {
        display: block;

        font-size: 12px;

        color: #9ca3af;
    }

    .overview-item b {
        font-size: 20px;

        color: #2563eb;
    }


    /* =========================
       ADMIN NOTE
    ========================= */

    .admin-info-box {
        background: #f8fafc;

        border: 1px solid #e5e7eb;

        border-radius: 16px;

        padding: 20px 22px;

        margin-top: 25px;
    }

    .admin-info-box strong {
        display: block;

        margin-bottom: 5px;

        color: #111827;

        font-size: 14px;
    }

    .admin-info-box p {
        margin: 0;

        color: #6b7280;

        font-size: 13px;

        line-height: 1.6;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 1100px) {

        .stats-grid {
            grid-template-columns:
                repeat(2, 1fr);
        }
    }


    @media (max-width: 800px) {

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .admin-dashboard-container {
            padding: 0 20px;
        }
    }


    @media (max-width: 550px) {

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-header h1 {
            font-size: 27px;
        }

        .admin-welcome-box {
            padding: 28px;
        }

        .admin-welcome-box h2 {
            font-size: 23px;
        }
    }
</style>


<section class="admin-dashboard">

    <div class="admin-dashboard-container">


        {{-- =========================
             DASHBOARD HEADER
        ========================== --}}

        <div class="dashboard-header">

            <h1>
                Admin Dashboard
            </h1>

            <p>
                Welcome back, {{ auth()->user()->name }}.
                Here's an overview of your HelpDesk system.
            </p>

        </div>


        {{-- =========================
             WELCOME BOX
        ========================== --}}

        <div class="admin-welcome-box">

            <h2>
                Welcome back, {{ auth()->user()->name }} 👋
            </h2>

            <p>
                Manage users, categories and support requests
                from your HelpDesk administration panel.
            </p>

        </div>


        {{-- =========================
             STATISTICS
        ========================== --}}

        <div class="stats-grid">


            {{-- USERS --}}

            <div class="stat-card">

                <div class="stat-icon blue">
                    👥
                </div>

                <div>

                    <span class="stat-label">
                        Total Users
                    </span>

                    <h2>
                        {{ $usersCount }}
                    </h2>

                    <span class="stat-description">
                        Registered accounts
                    </span>

                </div>

            </div>


            {{-- TICKETS --}}

            <div class="stat-card">

                <div class="stat-icon purple">
                    🎫
                </div>

                <div>

                    <span class="stat-label">
                        Total Tickets
                    </span>

                    <h2>
                        {{ $ticketsCount }}
                    </h2>

                    <span class="stat-description">
                        Support requests
                    </span>

                </div>

            </div>


            {{-- CATEGORIES --}}

            <div class="stat-card">

                <div class="stat-icon green">
                    ▦
                </div>

                <div>

                    <span class="stat-label">
                        Categories
                    </span>

                    <h2>
                        {{ $categoriesCount }}
                    </h2>

                    <span class="stat-description">
                        Ticket categories
                    </span>

                </div>

            </div>


            {{-- ACTIVE USERS --}}

            <div class="stat-card">

                <div class="stat-icon orange">
                    ◷
                </div>

                <div>

                    <span class="stat-label">
                        Active Users
                    </span>

                    <h2>
                        {{ $activeUsersCount }}
                    </h2>

                    <span class="stat-description">
                        Currently active
                    </span>

                </div>

            </div>


        </div>


        {{-- =========================
             MANAGEMENT
        ========================== --}}

        <div class="section-heading">

            <h2>
                Management
            </h2>

            <p>
                Manage the main resources of your HelpDesk system.
            </p>

        </div>


        <div class="dashboard-grid">


            {{-- QUICK ACTIONS --}}

            <div class="dashboard-panel">

                <div class="panel-header">

                    <h2>
                        Quick Actions
                    </h2>

                    <p>
                        Manage your HelpDesk system
                    </p>

                </div>


                <div class="quick-actions">


                    {{-- USERS --}}

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="quick-action"
                    >

                        <div class="quick-icon">
                            👥
                        </div>

                        <div>

                            <strong>
                                Manage Users
                            </strong>

                            <span>
                                View and manage user accounts
                            </span>

                        </div>

                        <b>
                            →
                        </b>

                    </a>


                    {{-- CATEGORIES --}}

                    @if(Route::has('admin.categories.index'))

                        <a
                            href="{{ route('admin.categories.index') }}"
                            class="quick-action"
                        >

                            <div class="quick-icon">
                                ▦
                            </div>

                            <div>

                                <strong>
                                    Manage Categories
                                </strong>

                                <span>
                                    Organize ticket categories
                                </span>

                            </div>

                            <b>
                                →
                            </b>

                        </a>

                    @endif


                    {{-- TICKETS --}}

                    @if(Route::has('admin.tickets.index'))

                        <a
                            href="{{ route('admin.tickets.index') }}"
                            class="quick-action"
                        >

                            <div class="quick-icon">
                                🎫
                            </div>

                            <div>

                                <strong>
                                    Manage Tickets
                                </strong>

                                <span>
                                    Review customer requests
                                </span>

                            </div>

                            <b>
                                →
                            </b>

                        </a>

                    @endif


                </div>

            </div>


            {{-- SYSTEM OVERVIEW --}}

            <div class="dashboard-panel">

                <div class="panel-header">

                    <h2>
                        System Overview
                    </h2>

                    <p>
                        Current HelpDesk information
                    </p>

                </div>


                <div class="overview-list">


                    {{-- USERS --}}

                    <div class="overview-item">

                        <div>

                            <strong>
                                Users
                            </strong>

                            <span>
                                Registered accounts
                            </span>

                        </div>

                        <b>
                            {{ $usersCount }}
                        </b>

                    </div>


                    {{-- CATEGORIES --}}

                    <div class="overview-item">

                        <div>

                            <strong>
                                Categories
                            </strong>

                            <span>
                                Available ticket categories
                            </span>

                        </div>

                        <b>
                            {{ $categoriesCount }}
                        </b>

                    </div>


                    {{-- TICKETS --}}

                    <div class="overview-item">

                        <div>

                            <strong>
                                Tickets
                            </strong>

                            <span>
                                Total support requests
                            </span>

                        </div>

                        <b>
                            {{ $ticketsCount }}
                        </b>

                    </div>


                    {{-- ACTIVE USERS --}}

                    <div class="overview-item">

                        <div>

                            <strong>
                                Active Users
                            </strong>

                            <span>
                                Currently active accounts
                            </span>

                        </div>

                        <b>
                            {{ $activeUsersCount }}
                        </b>

                    </div>


                </div>

            </div>


        </div>


        {{-- =========================
             ADMIN INFORMATION
        ========================== --}}

        <div class="admin-info-box">

            <strong>
                Admin Control Panel
            </strong>

            <p>
                Use the management options above to manage users,
                organize ticket categories and review support requests.
                Detailed notifications and statistics will be added
                as separate HelpDesk modules.
            </p>

        </div>


    </div>

</section>

@endsection

