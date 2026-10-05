
@extends('layouts.app')

@section('title', 'My Account - HelpDesk')

@section('content')

<style>
    .profile-page {
        background: #f5f7fb;
        min-height: calc(100vh - 80px);
        padding: 45px 20px;
    }

    .profile-container {
        max-width: 760px;
        margin: auto;
    }

    .profile-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(17, 24, 39, .04);
    }

    .profile-header {
        margin-bottom: 25px;
    }

    .profile-header h1 {
        margin: 0 0 8px;
        color: #111827;
        font-size: 30px;
    }

    .profile-header p {
        color: #6b7280;
        margin: 0;
    }

    .profile-avatar {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: #dbeafe;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: bold;
        margin-bottom: 22px;
    }

    .profile-field {
        margin-bottom: 20px;
    }

    .profile-field label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
    }

    .profile-field input {
        box-sizing: border-box;
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 15px;
    }

    .profile-field input:focus {
        outline: 2px solid #bfdbfe;
        border-color: #2563eb;
    }

    .profile-help {
        color: #6b7280;
        font-size: 13px;
        margin-top: 7px;
    }

    .profile-error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 6px;
    }

    .profile-success {
        background: #ecfdf5;
        color: #065f46;
        border-radius: 8px;
        padding: 13px 15px;
        margin-bottom: 22px;
    }

    .profile-button {
        display: inline-block;
        background: #2563eb;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
    }

    .profile-button:hover {
        background: #1d4ed8;
    }

    .profile-section-title {
        margin: 30px 0 18px;
        padding-top: 25px;
        border-top: 1px solid #e5e7eb;
        color: #111827;
        font-size: 19px;
    }

    @media (max-width: 600px) {
        .profile-card {
            padding: 20px;
        }
    }
</style>

<section class="profile-page">
    <div class="profile-container">

        <div class="profile-header">
            <h1>My Account 👤</h1>
            <p>Manage your personal information and password.</p>
        </div>

        <div class="profile-card">

            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            @if(session('success'))
                <div class="profile-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="profile-success"
                     style="background:#fef2f2;color:#991b1b;">
                    Please correct the errors below.
                </div>
            @endif

            <form action="{{ route('profile.update') }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="profile-field">
                    <label for="name">Full Name</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        maxlength="255"
                    >

                    @error('name')
                        <div class="profile-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="profile-field">
                    <label for="email">Email Address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        maxlength="255"
                    >

                    @error('email')
                        <div class="profile-error">{{ $message }}</div>
                    @enderror
                </div>

                <h2 class="profile-section-title">
                    Change Password
                </h2>

                <p class="profile-help" style="margin-bottom:20px;">
                    Leave these fields empty if you do not want to
                    change your current password.
                </p>

                <div class="profile-field">
                    <label for="password">New Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                    >

                    @error('password')
                        <div class="profile-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="profile-field">
                    <label for="password_confirmation">
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                    >
                </div>

                <button type="submit" class="profile-button">
                    Save Changes
                </button>

            </form>

        </div>
    </div>
</section>

@endsection