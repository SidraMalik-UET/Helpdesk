@extends('layouts.app')

@section('title', 'Login - HelpDesk')

@section('content')

<section class="auth-section">

    <div class="auth-card">

        <h1>Welcome back</h1>

        <p class="auth-subtitle">
            Login to access your HelpDesk account.
        </p>


        <form method="POST" action="{{ route('login.submit') }}">

            @csrf

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                >

            </div>


            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                >

            </div>


            <button type="submit" class="btn btn-primary form-button">
                Login
            </button>

        </form>


        <p style="margin-top: 20px; text-align: center; color: #6b7280;">

            Don't have an account?

            <a href="{{ route('register.form') }}" style="color: #2563eb;">
                Create one
            </a>

        </p>

    </div>

</section>

@endsection