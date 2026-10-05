@extends('layouts.app')

@section('title', 'Ticket Conversations - HelpDesk')

@section('content')

<style>
    .conversations-page {
        background: #f5f7fb;
        min-height: calc(100vh - 80px);
        padding: 45px 20px;
    }

    .conversations-container {
        max-width: 1050px;
        margin: auto;
    }

    .conversations-header {
        margin-bottom: 28px;
    }

    .conversations-header h1 {
        color: #111827;
        font-size: 32px;
        margin: 0 0 8px;
    }

    .conversations-header p {
        color: #6b7280;
        margin: 0;
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
        transition: .2s ease;
    }

    .conversation-card:hover {
        border-color: #93b4ff;
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(17, 24, 39, .06);
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
        text-transform: capitalize;
    }

    .latest-reply {
        background: #f9fafb;
        padding: 13px;
        border-radius: 8px;
        margin-top: 16px;
        color: #4b5563;
        overflow-wrap: anywhere;
    }

    .conversation-action {
        display: inline-block;
        margin-top: 15px;
        color: #2563eb;
        font-weight: 600;
    }

    .empty-conversations {
        background: white;
        padding: 40px 20px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        text-align: center;
    }

    .empty-conversations a {
        display: inline-block;
        margin-top: 12px;
        color: #2563eb;
        font-weight: 600;
    }
</style>

<section class="conversations-page">
    <div class="conversations-container">

        <div class="conversations-header">
            <h1>Ticket Conversations 💬</h1>
            <p>Read support replies and continue your conversations.</p>
        </div>

        @forelse($tickets as $ticket)
            @php
                $latestReply = $ticket->replies
                    ->sortByDesc('created_at')
                    ->first();
            @endphp

            <a href="{{ route('tickets.show', $ticket) }}"
               class="conversation-card">

                <div class="conversation-top">
                    <div>
                        <h2>
                            #{{ $ticket->id }} — {{ $ticket->subject }}
                        </h2>

                        <div class="conversation-meta">
                            Category:
                            {{ $ticket->category?->name ?? 'Uncategorized' }}
                            <br>

                            Last activity:
                            {{ ($latestReply?->created_at ?? $ticket->created_at)
                                ->format('d M Y, h:i A') }}
                        </div>
                    </div>

                    <span class="conversation-status">
                        {{ str_replace('_', ' ', $ticket->status) }}
                    </span>
                </div>

                <div class="latest-reply">
                    @if($latestReply)
                        <strong>
                            Latest reply from
                            {{ $latestReply->user?->name ?? 'Support' }}
                        </strong>

                        <p style="margin:8px 0 0;">
                            {{ \Illuminate\Support\Str::limit(
                                $latestReply->message, 160
                            ) }}
                        </p>
                    @else
                        <strong>No replies yet</strong>

                        <p style="margin:8px 0 0;">
                            Your support conversation will appear here
                            when a reply is added.
                        </p>
                    @endif
                </div>

                <span class="conversation-action">
                    Open Conversation →
                </span>

            </a>
        @empty
            <div class="empty-conversations">
                <h2>No conversations yet</h2>

                <p>
                    Create a support ticket to start a conversation
                    with our team.
                </p>

                <a href="{{ route('tickets.create') }}">
                    Create a Ticket →
                </a>
            </div>
        @endforelse

    </div>
</section>

@endsection

