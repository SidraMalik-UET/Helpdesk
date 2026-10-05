@extends('layouts.app')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: #f5f7fa;
        font-family: Arial, sans-serif;
        color: #111827;
    }

    /* NAVBAR */

    .ticket-navbar {
        height: 70px;
        background: #111827;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 6%;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .ticket-brand {
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .ticket-nav {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .ticket-nav a {
        color: #e5e7eb;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
    }

    .ticket-nav a:hover {
        color: white;
    }

    .logout-button {
        background: #374151;
        color: white;
        border: none;
        padding: 9px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
    }

    .logout-button:hover {
        background: #4b5563;
    }


    /* PAGE */

    .helpdesk-page {
        min-height: calc(100vh - 70px);
        padding: 45px 20px 70px;
    }

    .helpdesk-container {
        max-width: 1050px;
        margin: 0 auto;
    }


    /* HEADING */

    .page-heading {
        margin-bottom: 30px;
    }

    .page-heading h1 {
        margin: 0 0 8px;
        font-size: 34px;
        color: #111827;
        font-weight: 700;
    }

    .page-heading p {
        margin: 0;
        color: #6b7280;
        font-size: 15px;
    }


    /* CARD */

    .ticket-card {
        background: white;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 35px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .card-heading {
        padding: 28px 32px;
        border-bottom: 1px solid #e5e7eb;
    }

    .card-heading h2 {
        margin: 0 0 6px;
        font-size: 20px;
        color: #111827;
    }

    .card-heading p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .ticket-form {
        padding: 32px;
    }


    /* ALERTS */

    .alert {
        padding: 14px 17px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .alert-error strong {
        display: block;
        margin-bottom: 7px;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 20px;
    }


    /* FORM */

    .section-title {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.6px;
        text-transform: uppercase;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-size: 14px;
        font-weight: 600;
    }

    .required {
        color: #dc2626;
    }

    .form-control {
        width: 100%;
        padding: 13px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
        color: #111827;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    .form-control:hover {
        border-color: #9ca3af;
    }

    .form-control:focus {
        border-color: #111827;
        box-shadow: 0 0 0 3px rgba(17,24,39,0.08);
    }

    textarea.form-control {
        min-height: 170px;
        resize: vertical;
        line-height: 1.6;
    }

    .help-text {
        margin-top: 7px;
        color: #9ca3af;
        font-size: 12px;
        line-height: 1.5;
    }


    /* BUTTONS */

    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 22px;
        border-top: 1px solid #e5e7eb;
    }

    .required-note {
        color: #9ca3af;
        font-size: 12px;
    }

    .button-group {
        display: flex;
        gap: 12px;
    }

    .btn {
        padding: 12px 22px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
    }

    .btn-submit {
        background: #111827;
        color: white;
    }

    .btn-submit:hover {
        background: #374151;
    }


    /* MOBILE */

    @media (max-width: 700px) {

        .ticket-navbar {
            padding: 0 20px;
        }

        .ticket-nav {
            gap: 12px;
        }

        .ticket-nav a {
            display: none;
        }

        .helpdesk-page {
            padding: 30px 15px 50px;
        }

        .page-heading h1 {
            font-size: 27px;
        }

        .ticket-form {
            padding: 22px;
        }

        .card-heading {
            padding: 22px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-footer {
            flex-direction: column;
            align-items: stretch;
            gap: 18px;
        }

        .button-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .required-note {
            text-align: center;
        }
    }
</style>


<!-- CLEAN NAVBAR -->

<nav class="ticket-navbar">

    <div class="ticket-brand">
        HelpDesk
    </div>

    <div class="ticket-nav">

        <a href="/dashboard">
            Dashboard
        </a>

        <a href="/tickets/create">
            Create Ticket
        </a>

        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf

            <button type="submit" class="logout-button">
                Logout
            </button>
        </form>

    </div>

</nav>


<!-- PAGE -->

<div class="helpdesk-page">

    <div class="helpdesk-container">

        <div class="page-heading">

            <h1>Create Support Ticket</h1>

            <p>
                Submit a support request and our team will review it as soon as possible.
            </p>

        </div>


        <div class="ticket-card">

            <div class="card-heading">

                <h2>Ticket Information</h2>

                <p>
                    Please provide clear information about the issue you are experiencing.
                </p>

            </div>


            <div class="ticket-form">

                @if(session('success'))

                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>

                @endif


                @if($errors->any())

                    <div class="alert alert-error">

                        <strong>
                            Please correct the following:
                        </strong>

                        <ul>

                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf


                    <div class="section-title">
                        Basic Information
                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label for="category_id">
                                Category <span class="required">*</span>
                            </label>

                            <select
                                id="category_id"
                                name="category_id"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    Select a category
                                </option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="form-group">

                            <label for="priority">
                                Priority <span class="required">*</span>
                            </label>

                            <select
                                id="priority"
                                name="priority"
                                class="form-control"
                                required
                            >

                                <option value="low"
                                    {{ old('priority') == 'low' ? 'selected' : '' }}>
                                    Low
                                </option>

                                <option value="medium"
                                    {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>
                                    Medium
                                </option>

                                <option value="high"
                                    {{ old('priority') == 'high' ? 'selected' : '' }}>
                                    High
                                </option>

                                <option value="urgent"
                                    {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                                    Urgent
                                </option>

                            </select>

                        </div>

                    </div>


                    <div class="section-title">
                        Ticket Details
                    </div>


                    <div class="form-group">

                        <label for="subject">
                            Subject <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            class="form-control"
                            value="{{ old('subject') }}"
                            placeholder="Example: Unable to login to my account"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="description">
                            Description <span class="required">*</span>
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            class="form-control"
                            placeholder="Describe the issue in detail..."
                            required
                        >{{ old('description') }}</textarea>

                        <div class="help-text">
                            Include error messages, steps you have tried, or any other useful information.
                        </div>

                    </div>


                    <div class="form-group">

                        <label for="attachment">
                            Attachment (Optional)
                        </label>

                        <input
                            type="file"
                            id="attachment"
                            name="attachment"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                        >

                        <div class="help-text">
                            Allowed: JPG, JPEG, PNG, PDF, DOC, DOCX — Maximum 5MB
                        </div>

                        @error('attachment')
                            <div style="color: #dc2626; font-size: 13px; margin-top: 6px;">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="form-footer">

                        <div class="required-note">
                            * Required fields
                        </div>

                        <div class="button-group">

                            <a href="{{ route('dashboard') }}" class="btn btn-cancel">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-submit">
                                Submit Ticket
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection 