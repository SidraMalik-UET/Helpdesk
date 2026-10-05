@extends('layouts.app')

@section('title', 'Ticket Details - HelpDesk')

@section('content')

<style>
    .ticket-page {
        background: #f5f7fb;
        min-height: 100vh;
        padding: 40px 20px;
        color: #1f2937;
    }

    .ticket-container {
        max-width: 1050px;
        margin: auto;
    }

    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .ticket-header h1 {
        margin: 0 0 8px;
        font-size: 30px;
    }

    .ticket-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 25px;
        margin-bottom: 22px;
        box-shadow: 0 3px 12px rgba(0,0,0,.03);
    }

    .ticket-card h2 {
        margin-top: 0;
        font-size: 20px;
    }

    .ticket-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 18px;
        margin-top: 20px;
    }

    .meta-label {
        display: block;
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .meta-value {
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .ticket-description {
        white-space: pre-wrap;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .ticket-badge {
        display: inline-block;
        background: #eff6ff;
        color: #1d4ed8;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 13px;
        text-transform: capitalize;
    }

    .ticket-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .ticket-select {
        flex: 1;
        min-width: 200px;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
    }

    .ticket-button {
        display: inline-block;
        border: none;
        border-radius: 8px;
        padding: 11px 17px;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
    }

    .ticket-button-primary {
        background: #2563eb;
        color: white;
    }

    .ticket-button-secondary {
        background: #e5e7eb;
        color: #1f2937;
    }

    .ticket-alert {
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 18px;
        background: #ecfdf5;
        color: #065f46;
    }

    .ticket-error {
        color: #b91c1c;
        font-size: 13px;
        margin-top: 6px;
    }

    .reply-item {
        border-left: 3px solid #2563eb;
        padding: 5px 0 5px 17px;
        margin-top: 22px;
    }

    .reply-message {
        white-space: pre-wrap;
        overflow-wrap: anywhere;
        line-height: 1.7;
        margin-top: 10px;
    }

    .ticket-attachment {
        display: inline-block;
        margin: 8px 10px 0 0;
        color: #2563eb;
        overflow-wrap: anywhere;
    }

    .attachment-preview {
        display: block;
        max-width: 250px;
        max-height: 250px;
        width: auto;
        height: auto;
        object-fit: contain;
        margin: 10px 0;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    @media (max-width: 600px) {
        .ticket-page {
            padding: 25px 12px;
        }

        .ticket-card {
            padding: 18px;
        }

        .ticket-header h1 {
            font-size: 25px;
        }
    }
</style>

<div class="ticket-page">
    <div class="ticket-container">

        <div class="ticket-header">
            <div>
                <h1>Ticket #{{ $ticket->id }}</h1>
                <p style="color:#6b7280;margin:0;">
                    Review the customer issue and manage assignment.
                </p>
            </div>

            <a href="{{ route('admin.tickets.index') }}"
               class="ticket-button ticket-button-secondary">
                &larr; Back to Manage Tickets
            </a>
        </div>

        @if(session('success'))
            <div class="ticket-alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="ticket-card">
                <strong>Please correct the following:</strong>

                @foreach($errors->all() as $error)
                    <div class="ticket-error">{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Ticket information --}}
        <div class="ticket-card">
            <span class="ticket-badge">
                {{ $ticket->status }}
            </span>

            <h2 style="margin-top:15px;">
                {{ $ticket->subject }}
            </h2>

            <div class="ticket-meta">
                <div>
                    <span class="meta-label">Customer</span>
                    <span class="meta-value">
                        {{ $ticket->user?->name ?? 'Unknown customer' }}
                    </span>
                </div>

                <div>
                    <span class="meta-label">Email</span>
                    <span class="meta-value">
                        {{ $ticket->user?->email ?? 'Not available' }}
                    </span>
                </div>

                <div>
                    <span class="meta-label">Category</span>
                    <span class="meta-value">
                        {{ $ticket->category?->name ?? 'Uncategorized' }}
                    </span>
                </div>

                <div>
                    <span class="meta-label">Priority</span>
                    <span class="meta-value">
                        {{ ucfirst($ticket->priority) }}
                    </span>
                </div>

                <div>
                    <span class="meta-label">Assigned Agent</span>
                    <span class="meta-value">
                        {{ $ticket->assignedAgent?->name ?? 'Not assigned' }}
                    </span>
                </div>

                <div>
                    <span class="meta-label">Created</span>
                    <span class="meta-value">
                        {{ $ticket->created_at?->format('d M Y, h:i A') }}
                    </span>
                </div>
            </div>

            <hr style="border:0;border-top:1px solid #e5e7eb;margin:25px 0;">

            <h2>Problem Description</h2>
            <div class="ticket-description">{{ $ticket->description }}</div>
        </div>

        {{-- Assign agent --}}
        <div class="ticket-card">
            <h2>Assign Agent</h2>

            <p style="color:#6b7280;">
                Select an active agent to handle this ticket.
            </p>

            <form
                action="{{ route('admin.tickets.assign', $ticket) }}"
                method="POST"
                class="ticket-form"
            >
                @csrf

                <select name="assigned_to"
                        class="ticket-select"
                        required>
                    <option value="">Select Agent</option>

                    @foreach($agents as $agent)
                        <option
                            value="{{ $agent->id }}"
                            @selected((string) $ticket->assigned_to === (string) $agent->id)
                        >
                            {{ $agent->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                        class="ticket-button ticket-button-primary">
                    Assign Agent
                </button>
            </form>
        </div>

        {{-- Existing replies --}}
        <div class="ticket-card">
            <h2>Conversation & Replies</h2>

            @forelse($ticket->replies as $reply)
                <div class="reply-item">
                    <strong>
                        {{ $reply->user?->name ?? 'User' }}
                    </strong>

                    <div style="color:#6b7280;font-size:13px;margin-top:5px;">
                        {{ $reply->created_at?->format('d M Y, h:i A') }}
                    </div>

                    <div class="reply-message">{{ $reply->message }}</div>

                    {{-- Reply attachments --}}
                    @foreach($reply->attachments as $attachment)
                        <div>
                            <a
                                class="ticket-attachment"
                                href="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                                target="_blank"
                            >
                                📎 {{ $attachment->file_name }}
                            </a>

                            {{-- Image preview --}}
                            @if($attachment->isImage())
                                <a
                                    href="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                                    target="_blank"
                                >
                                    <img
                                        class="attachment-preview"
                                        src="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                                        alt="{{ $attachment->file_name }}"
                                        loading="lazy"
                                    >
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @empty
                <p style="color:#6b7280;">
                    No replies have been added to this ticket yet.
                </p>
            @endforelse
        </div>

        {{-- Original ticket attachments --}}
        @if($ticket->attachments->whereNull('reply_id')->isNotEmpty())
            <div class="ticket-card">
                <h2>Original Ticket Attachments</h2>

                @foreach($ticket->attachments->whereNull('reply_id') as $attachment)
                    <div>
                        <a
                            class="ticket-attachment"
                            href="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                            target="_blank"
                        >
                            📎 {{ $attachment->file_name }}
                        </a>

                        {{-- Original attachment image preview --}}
                        @if($attachment->isImage())
                            <a
                                href="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                                target="_blank"
                            >
                                <img
                                    class="attachment-preview"
                                    src="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                                    alt="{{ $attachment->file_name }}"
                                    loading="lazy"
                                >
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

@endsection

