<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HelpDesk Admin</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #172033;
        }


        /* =========================
           SIDEBAR
        ========================== */

        .admin-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;

            background: #111827;
            color: white;

            display: flex;
            flex-direction: column;

            z-index: 1000;
        }


        .admin-logo {
            height: 80px;

            display: flex;
            align-items: center;

            padding: 0 28px;

            border-bottom: 1px solid #263244;
        }


        .admin-logo h2 {
            font-size: 21px;
            letter-spacing: 1px;
        }


        .admin-logo span {
            color: #9ca3af;
            font-size: 12px;
            display: block;
            margin-top: 3px;
            letter-spacing: 2px;
        }


        .admin-nav {
            padding: 25px 15px;
            flex: 1;
        }


        .nav-title {
            color: #6b7280;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;

            padding: 0 14px;
            margin-bottom: 10px;
        }


        .admin-nav a {
            display: flex;
            align-items: center;

            gap: 12px;

            color: #cbd5e1;
            text-decoration: none;

            padding: 12px 14px;

            margin-bottom: 5px;

            border-radius: 8px;

            font-size: 14px;

            transition: 0.2s ease;
        }


        .admin-nav a:hover {
            background: #1f2937;
            color: white;
        }


        .admin-nav a.active {
            background: #2563eb;
            color: white;
        }


        .nav-icon {
            width: 22px;
            text-align: center;
            font-size: 16px;
        }


        .sidebar-bottom {
            padding: 15px;

            border-top: 1px solid #263244;
        }


        .sidebar-bottom a {
            display: block;

            color: #cbd5e1;
            text-decoration: none;

            padding: 11px 14px;

            border-radius: 8px;

            font-size: 14px;

            margin-bottom: 5px;
        }


        .sidebar-bottom a:hover {
            background: #1f2937;
            color: white;
        }


        /* =========================
           MAIN AREA
        ========================== */

        .admin-main {
            margin-left: 250px;
            min-height: 100vh;
        }


        /* =========================
           TOPBAR
        ========================== */

        .admin-topbar {
            height: 80px;

            background: white;

            border-bottom: 1px solid #e5e7eb;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 35px;
        }


        .topbar-title {
            font-size: 14px;
            color: #6b7280;
        }


        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }


        .user-avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: #2563eb;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: bold;
        }


        .user-info strong {
            display: block;
            font-size: 14px;
        }


        .user-info span {
            font-size: 12px;
            color: #6b7280;
        }


        /* =========================
           CONTENT
        ========================== */

        .admin-content {
            padding: 35px;
        }


        /* =========================
           ALERTS
        ========================== */

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #047857;

            padding: 13px 16px;

            border-radius: 8px;

            margin-bottom: 25px;
        }


        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;

            padding: 13px 16px;

            border-radius: 8px;

            margin-bottom: 25px;
        }


        /* =========================
           RESPONSIVE
        ========================== */

        @media (max-width: 900px) {

            .admin-sidebar {
                width: 210px;
            }

            .admin-main {
                margin-left: 210px;
            }

            .admin-content {
                padding: 25px;
            }

        }


        @media (max-width: 700px) {

            .admin-sidebar {
                position: relative;

                width: 100%;
                height: auto;
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-topbar {
                padding: 0 20px;
            }

            .admin-content {
                padding: 20px;
            }

        }

    </style>

</head>


<body>


    <!-- SIDEBAR -->

    <aside class="admin-sidebar">

        <div class="admin-logo">

            <div>

                <h2>HELPDESK</h2>

                <span>ADMIN PANEL</span>

            </div>

        </div>


        <nav class="admin-nav">

            <div class="nav-title">
                Main Menu
            </div>


            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                <span class="nav-icon">⌂</span>

                Dashboard

            </a>


            <a href="{{ route('admin.users.index') }}"
               class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">

                <span class="nav-icon">♙</span>

                Users

            </a>


            @if(Route::has('admin.categories.index'))

                <a href="{{ route('admin.categories.index') }}"
                   class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">

                    <span class="nav-icon">▦</span>

                    Categories

                </a>

            @endif


            @if(Route::has('admin.tickets.index'))

                <a href="{{ route('admin.tickets.index') }}"
                   class="{{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">

                    <span class="nav-icon">▤</span>

                    Tickets

                </a>

            @endif


            @if(Route::has('admin.reports.index'))

                <a href="{{ route('admin.reports.index') }}"
                   class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">

                    <span class="nav-icon">▥</span>

                    Reports

                </a>

            @endif

        </nav>


        <div class="sidebar-bottom">

            <a href="{{ route('helpdesk') }}">
                🌐 &nbsp; View Website
            </a>


            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">

                ⇥ &nbsp; Logout

            </a>


            <form id="admin-logout-form"
                  action="{{ route('logout') }}"
                  method="POST"
                  style="display:none;">

                @csrf

            </form>

        </div>

    </aside>



    <!-- MAIN -->

    <main class="admin-main">


        <!-- TOPBAR -->

        <header class="admin-topbar">

            <div class="topbar-title">
                HelpDesk Management System
            </div>


            @auth

                <div class="admin-user">

                    <div class="user-avatar">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>


                    <div class="user-info">

                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <span>
                            Administrator
                        </span>

                    </div>

                </div>

            @endauth

        </header>



        <!-- PAGE CONTENT -->

        <section class="admin-content">

            @if(session('success'))

                <div class="alert-success">
                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="alert-error">
                    {{ session('error') }}
                </div>

            @endif


            @yield('content')

        </section>


    </main>


</body>

</html>