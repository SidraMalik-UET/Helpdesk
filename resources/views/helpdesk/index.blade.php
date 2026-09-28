@extends('layouts.app')

@section('title', 'HelpDesk - Support Made Simple')

@section('content')

<section class="hero">

    <div class="container hero-content">

        <h1>
            Support made <span>simple.</span>
        </h1>

        <p>
            Create support tickets, communicate with our team,
            and keep track of every issue from one simple dashboard.
        </p>

        <div class="hero-buttons">

            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register.form') }}" class="btn btn-primary">
                    Create Account
                </a>

                <a href="{{ route('login') }}" class="btn btn-secondary">
                    Login
                </a>
            @endauth

        </div>

    </div>

</section>


<section class="section">

    <div class="container">

        <div class="section-title">
            <h2>How HelpDesk Works</h2>
            <p>Everything you need to manage support requests.</p>
        </div>


        <div class="cards">

            <div class="card">

                <div class="card-icon">🎫</div>

                <h3>Create Tickets</h3>

                <p>
                    Submit your issue and provide the details
                    our support team needs.
                </p>

            </div>


            <div class="card">

                <div class="card-icon">💬</div>

                <h3>Communicate</h3>

                <p>
                    Reply to support agents and keep the entire
                    conversation connected to your ticket.
                </p>

            </div>


            <div class="card">

                <div class="card-icon">📊</div>

                <h3>Track Progress</h3>

                <p>
                    Monitor ticket status and stay informed
                    about your support requests.
                </p>

            </div>

        </div>

    </div>

</section>

@endsection