@extends('layouts.app')

@section('title', 'Ticket Conversations - HelpDesk')

@section('content')

<style>
    .conversations-page {
        background: #f5f7fb;
        min-height: calc(100vh - 80px);
        padding: 45px 20px 70px;
    }

    .conversations-container {
        max-width: 1050px;
        margin: auto;
    }

    .conversations-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 28px;
    }

    .conversations-header h1 {
        color: #111827;
        font-size: 32px;
        margin: 0 0 6px;
        font-weight: 700;
    }

    .conversations-header p {
        color: #6b7280;
        margin: 0;
        font-size: 15px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .btn-create {
        display: inline-block;
        background: #2563eb;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .btn-create:hover {
        background: #1d4ed8;
    }

    .btn-back {
        display: inline-block;
        background: white;
        color: #374151;
        border: 1px solid #d1d5db;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .btn-back:hover {
        background: #f3f4f6;
    }

    .conversation-card {
        display: block;
        background: white;
        padding: 24px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        margin-bottom: 16px;
        color: #111827;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .conversation-card:hover {
        border-color: #93b4ff;
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(17, 24, 39, 0.06);
    }

    .conversation-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        flex-wrap: wrap;
    }

    .conversation-card h2 {
        font-size: 19px;
        margin: 0 0 10px;
        color: #111827;
    }

    .conversation-meta {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.8;
    }

    .conversation-status {
        background: #eff6ff;
        color: #1d4ed8;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-open {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .status-in_progress {
        background: #fef3c7;
        color: #92400e;
    }

    .status-resolved {
        background: #ecfdf5;
        color: #065f46;
    }

    .status-closed {
        background: #f3f4f6;
        color: #4b5563;
    }

    .latest-reply {
        background: #f9fafb;
        padding: 14px 16px;
        border-radius: 8px;
        margin-top: 16px;
        color: #4b5563;
        overflow-wrap: anywhere;
        border-left: 3px solid #2563eb;
    }

    .conversation-action {
        display: inline-block;
        margin-top: 15px;
        color: #2563eb;
        font-weight: 600;
        font-size: 14px;
    }

    .empty-conversations {
        background: white;
        padding: 60px 20px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    }

    .empty-icon {
        font-size: 44px;
        margin-bottom: 12px;
    }

    .empty-conversations h2 {
        margin: 0 0 8px;
        color: #111827;
        font-size: 22px;
    }

    .empty-conversations p {
        color: #6b7280;
        margin: 0 0 20px;
        font-size: 15px;
    }
</style>

<section class="conversations-page">
    <div class="conversations-container">

        <div class="conversations-header">
            <div>
                <h1>Ticket Conversations 💬</h1>
                <p>Read support replies and continue your ticket discussions.</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn-back">
                    ← Dashboard
                </a>
                <a href="{{ route('tickets.create') }}" class="btn-create">
                    + New Ticket
                </a>
            </div>
        </div>

        @forelse($tickets as $ticket)
            @php
                $latestReply = $ticket->replies
                    ->sortByDesc('created_at')
                    ->first();

                $statusClass = 'status-' . strtolower($ticket->status);
            @endphp

            <a href="{{ route('tickets.show', $ticket) }}"
               class="conversation-card">

                <div class="conversation-top">
                    <div>
                        <h2>
                            #{{ $ticket->id }} — {{ $ticket->subject }}
                        </h2>

                        <div class="conversation-meta">
                            <strong>Category:</strong> {{ $ticket->category?->name ?? 'Uncategorized' }}
                            &nbsp; | &nbsp;
                            <strong>Priority:</strong> {{ ucfirst($ticket->priority) }}
                            &nbsp; | &nbsp;
                            <strong>Last Activity:</strong> {{ ($latestReply?->created_at ?? $ticket->created_at)->format('d M Y, h:i A') }}
                        </div>
                    </div>

                    <span class="conversation-status {{ $statusClass }}">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                </div>

                <div class="latest-reply">
                    @if($latestReply)
                        <strong>
                            Latest reply from {{ $latestReply->user?->name ?? 'Support' }} ({{ $latestReply->created_at->diffForHumans() }}):
                        </strong>

                        <p style="margin: 6px 0 0; line-height: 1.6;">
                            {{ \Illuminate\Support\Str::limit($latestReply->message, 200) }}
                        </p>
                    @else
                        <strong>No replies yet</strong>

                        <p style="margin: 6px 0 0; color: #6b7280;">
                            Your support ticket is open. When a team member responds, their message will appear here.
                        </p>
                    @endif
                </div>

                <span class="conversation-action">
                    Open Conversation →
                </span>

            </a>
        @empty
            <div class="empty-conversations">
                <div class="empty-icon">💬</div>
                <h2>No conversations yet</h2>

                <p>
                    You have not started any support conversations yet. Submit a ticket to get help.
                </p>

                <a href="{{ route('tickets.create') }}" class="btn-create">
                    Create a Support Ticket →
                </a>
            </div>
        @endforelse

    </div>
</section>

@endsection
