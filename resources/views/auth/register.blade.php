@extends('layouts.app')

@section('title', 'Create Account - HelpDesk')

@section('content')

<div class="auth-page">

    <div class="auth-card">

        <div class="auth-header">

            <div class="brand-mark">
                HD
            </div>

            <h1>Create your account</h1>

            <p>Join HelpDesk and get support faster.</p>

        </div>


        <form method="POST" action="{{ route('register') }}">

            @csrf


            {{-- Name Row --}}

            <div class="form-row">

                <div class="form-group">

                    <label for="name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter your name"
                        required
                    >

                </div>

            </div>


            {{-- Email --}}

            <div class="form-group">

                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    required
                >

            </div>


            {{-- Password Row --}}

            <div class="form-row">

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimum 8 characters"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="password_confirmation">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Repeat password"
                        required
                    >

                </div>

            </div>


            {{-- Terms --}}

            <div class="form-check">

                <input
                    type="checkbox"
                    id="terms"
                    required
                >

                <label for="terms">
                    I agree to the HelpDesk terms and conditions.
                </label>

            </div>


            <button type="submit" class="create-account-btn">
                Create Account
            </button>

        </form>


        <div class="auth-footer">

            <span>Already have an account?</span>

            <a href="{{ route('login') }}">
                Sign in
            </a>

        </div>

    </div>

</div>

@endsection