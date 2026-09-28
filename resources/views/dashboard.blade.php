@extends('layouts.app')

@section('title', 'Dashboard - HelpDesk')

@section('content')

<section class="dashboard">

    <div class="container">

        <div class="dashboard-header">

            <h1>Dashboard</h1>

            <p>
                Manage your HelpDesk account and support requests.
            </p>

        </div>


        <div class="welcome-box">

            <h2>
                Welcome, {{ auth()->user()->name }} 👋
            </h2>

            <p>
                You are successfully logged in to your HelpDesk account.
            </p>

        </div>


        <div class="cards">

            <div class="dashboard-card">

                <div class="card-icon">🎫</div>

                <h3>My Tickets</h3>

                <p>
                    Your support tickets will appear here.
                </p>

            </div>


            <div class="dashboard-card">

                <div class="card-icon">💬</div>

                <h3>Messages</h3>

                <p>
                    Your ticket conversations will appear here.
                </p>

            </div>


            <div class="dashboard-card">

                <div class="card-icon">👤</div>

                <h3>My Account</h3>

                <p>
                    Manage your HelpDesk account information.
                </p>

            </div>

        </div>

    </div>

</section>

@endsection