@extends('admin.layout')


@section('content')


<div class="dashboard-header">

    <div>

        <h1>Dashboard</h1>

        <p>
            Welcome back, {{ auth()->user()->name }}.
            Here's an overview of your HelpDesk system.
        </p>

    </div>

</div>



<!-- STATISTICS -->

<div class="stats-grid">


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



    <div class="stat-card">

        <div class="stat-icon purple">
            🎫
        </div>

        <div>

            <span class="stat-label">
                Total Tickets
            </span>

            <h2>
                {{ \App\Models\Ticket::count() }}
            </h2>

            <span class="stat-description">
                Support requests
            </span>

        </div>

    </div>



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



    <div class="stat-card">

        <div class="stat-icon orange">
            ◷
        </div>

        <div>

            <span class="stat-label">
                Active Users
            </span>

            <h2>
                {{ \App\Models\User::where('status', 'active')->count() }}
            </h2>

            <span class="stat-description">
                Currently active
            </span>

        </div>

    </div>


</div>



<!-- DASHBOARD GRID -->

<div class="dashboard-grid">


    <!-- QUICK ACTIONS -->

    <div class="dashboard-panel">

        <div class="panel-header">

            <div>

                <h2>Quick Actions</h2>

                <p>
                    Manage your HelpDesk system
                </p>

            </div>

        </div>


        <div class="quick-actions">


            <a href="{{ route('admin.users.index') }}"
               class="quick-action">

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

                <b>→</b>

            </a>



            @if(Route::has('admin.categories.index'))

                <a href="{{ route('admin.categories.index') }}"
                   class="quick-action">

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

                    <b>→</b>

                </a>

            @endif


            @if(Route::has('admin.tickets.index'))

                <a href="{{ route('admin.tickets.index') }}"
                   class="quick-action">

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

                    <b>→</b>

                </a>

            @endif


        </div>

    </div>



    <!-- SYSTEM SUMMARY -->

    <div class="dashboard-panel">

        <div class="panel-header">

            <div>

                <h2>System Overview</h2>

                <p>
                    Current HelpDesk status
                </p>

            </div>

        </div>


        <div class="overview-list">


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

                    
                <b>
                    {{ $productsCount }}
                </b>

            </div>


        </div>

    </div>


</div>



<style>


/* =========================
   DASHBOARD HEADER
========================= */

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-bottom: 30px;
}


.dashboard-header h1 {
    font-size: 30px;
    margin-bottom: 7px;
    color: #111827;
}


.dashboard-header p {
    color: #6b7280;
    font-size: 14px;
}



/* =========================
   STATISTICS
========================= */

.stats-grid {
    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 20px;

    margin-bottom: 25px;
}


.stat-card {
    background: white;

    border: 1px solid #e5e7eb;

    border-radius: 12px;

    padding: 22px;

    display: flex;

    align-items: center;

    gap: 16px;

    box-shadow:
        0 2px 6px rgba(15, 23, 42, 0.04);

    transition: 0.2s ease;
}


.stat-card:hover {
    transform: translateY(-2px);

    box-shadow:
        0 8px 20px rgba(15, 23, 42, 0.07);
}


.stat-icon {
    width: 48px;
    height: 48px;

    border-radius: 10px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 21px;
}


.stat-icon.blue {
    background: #eff6ff;
}


.stat-icon.purple {
    background: #f5f3ff;
}


.stat-icon.green {
    background: #ecfdf5;
}


.stat-icon.orange {
    background: #fff7ed;
}


.stat-label {
    display: block;

    font-size: 13px;

    color: #6b7280;

    margin-bottom: 4px;
}


.stat-card h2 {
    font-size: 26px;

    color: #111827;

    margin-bottom: 3px;
}


.stat-description {
    font-size: 11px;

    color: #9ca3af;
}



/* =========================
   LOWER GRID
========================= */

.dashboard-grid {
    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 20px;
}


.dashboard-panel {
    background: white;

    border: 1px solid #e5e7eb;

    border-radius: 12px;

    overflow: hidden;
}


.panel-header {
    padding: 22px;

    border-bottom: 1px solid #e5e7eb;
}


.panel-header h2 {
    font-size: 17px;

    margin-bottom: 5px;
}


.panel-header p {
    color: #6b7280;

    font-size: 13px;
}



/* =========================
   QUICK ACTIONS
========================= */

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

    border-bottom: 1px solid #f1f5f9;

    transition: 0.2s ease;
}


.quick-action:last-child {
    border-bottom: none;
}


.quick-action:hover {
    background: #f8fafc;

    padding-left: 12px;
}


.quick-icon {
    width: 40px;
    height: 40px;

    border-radius: 8px;

    background: #eff6ff;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;
}


.quick-action strong {
    display: block;

    font-size: 14px;

    margin-bottom: 3px;
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
   OVERVIEW
========================= */

.overview-list {
    padding: 8px 22px;
}


.overview-item {
    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 18px 0;

    border-bottom: 1px solid #f1f5f9;
}


.overview-item:last-child {
    border-bottom: none;
}


.overview-item strong {
    display: block;

    font-size: 14px;

    margin-bottom: 4px;
}


.overview-item span {
    color: #9ca3af;

    font-size: 12px;
}


.overview-item b {
    font-size: 20px;

    color: #2563eb;
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

}


@media (max-width: 550px) {

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .dashboard-header h1 {
        font-size: 25px;
    }

}

</style>


@endsection