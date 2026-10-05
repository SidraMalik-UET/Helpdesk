@extends('layouts.app')

@section('title', 'Notifications - HelpDesk')

@section('content')

<style>
    .notifications-page {
        background: #f5f7fb;
        min-height: calc(100vh - 80px);
        padding: 45px 0 70px;
    }

    .notifications-container {
        width: 90%;
        max-width: 900px;
        margin: 0 auto;
    }

    .notifications-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .notifications-header h1 {
        margin: 0 0 6px;
        font-size: 32px;
        color: #111827;
        font-weight: 700;
    }

    .notifications-header p {
        margin: 0;
        color: #6b7280;
        font-size: 15px;
    }

    .mark-all-btn {
        background: #ffffff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .mark-all-btn:hover {
        background: #eff6ff;
        border-color: #93b4ff;
    }

    .notifications-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .notification-item {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f7;
        text-decoration: none;
        color: inherit;
        transition: background 0.15s ease;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item:hover {
        background: #f8fafc;
    }

    .notification-icon {
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eaf2ff;
        border-radius: 12px;
        font-size: 20px;
    }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-content strong {
        display: block;
        margin-bottom: 4px;
        color: #111827;
        font-size: 15px;
        font-weight: 600;
    }

    .notification-content p {
        margin: 0 0 5px;
        color: #4b5563;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .notification-time {
        font-size: 12px;
        color: #9ca3af;
    }

    .notification-item.unread {
        background: #f0f7ff;
    }

    .notification-item.unread:hover {
        background: #e5f1ff;
    }

    .unread-indicator {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .unread-dot {
        width: 10px;
        height: 10px;
        background: #2563eb;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .inline-mark-read {
        background: none;
        border: none;
        color: #6b7280;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: underline;
    }

    .inline-mark-read:hover {
        color: #111827;
        background: #e5e7eb;
    }

    .empty-notifications {
        padding: 60px 25px;
        text-align: center;
    }

    .empty-notifications .empty-icon {
        font-size: 44px;
        margin-bottom: 12px;
    }

    .empty-notifications h3 {
        margin: 0 0 8px;
        color: #111827;
        font-size: 20px;
    }

    .empty-notifications p {
        margin: 0 0 20px;
        color: #6b7280;
        font-size: 14px;
    }

    .pagination-wrapper {
        padding: 18px 24px;
        border-top: 1px solid #eef2f7;
    }

    @media (max-width: 600px) {
        .notifications-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .notification-item {
            padding: 16px;
            gap: 12px;
        }
    }
</style>

<section class="notifications-page">
    <div class="notifications-container">

        <div class="notifications-header">
            <div>
                <h1>Notifications 🔔</h1>
                <p>Stay updated with activity and replies in your HelpDesk account.</p>
            </div>

            @if($unreadCount > 0)
                <form id="mark-all-form" action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="mark-all-btn" id="mark-all-btn">
                        ✓ Mark All as Read ({{ $unreadCount }})
                    </button>
                </form>
            @endif
        </div>

        <div class="notifications-card" id="notifications-card">

            @forelse($notifications as $notification)
                @php
                    $isUnread = is_null($notification->read_at);
                    $ticketId = $notification->data['ticket_id'] ?? null;
                    $subject = $notification->data['subject'] ?? null;
                    $message = $notification->data['message'] ?? 'New notification';
                @endphp

                <a
                    href="{{ route('notifications.read', $notification->id) }}"
                    class="notification-item {{ $isUnread ? 'unread' : '' }}"
                    data-notification-id="{{ $notification->id }}"
                    data-is-unread="{{ $isUnread ? '1' : '0' }}"
                >
                    <div class="notification-icon">
                        @if(str_contains(strtolower($notification->type), 'assigned'))
                            👤
                        @elseif(str_contains(strtolower($notification->type), 'replied'))
                            💬
                        @else
                            🔔
                        @endif
                    </div>

                    <div class="notification-content">
                        <strong>{{ $message }}</strong>

                        @if($subject)
                            <p>Ticket: <strong>#{{ $ticketId ?? '' }} — {{ $subject }}</strong></p>
                        @endif

                        <span class="notification-time">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="unread-indicator">
                        @if($isUnread)
                            <button
                                type="button"
                                class="inline-mark-read"
                                title="Mark this notification as read"
                                data-read-url="{{ route('notifications.read', $notification->id) }}"
                            >
                                Mark Read
                            </button>
                            <div class="unread-dot"></div>
                        @endif
                    </div>
                </a>
            @empty
                <div class="empty-notifications">
                    <div class="empty-icon">🔔</div>
                    <h3>No notifications yet</h3>
                    <p>You will see important updates about your support tickets here.</p>
                    <a href="{{ route('dashboard') }}" class="mark-all-btn" style="text-decoration:none;">
                        ← Back to Dashboard
                    </a>
                </div>
            @endforelse

        </div>

        @if(method_exists($notifications, 'hasPages') && $notifications->hasPages())
            <div class="pagination-wrapper">
                {{ $notifications->links() }}
            </div>
        @endif

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = '{{ csrf_token() }}';

        // Function to update navbar badge safely
        function setNavBadge(count) {
            const badge = document.getElementById('nav-notification-badge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'inline-block' : 'none';
            }
        }

        // Handle "Mark All as Read" with AJAX and immediate UI update
        const markAllForm = document.getElementById('mark-all-form');
        if (markAllForm) {
            markAllForm.addEventListener('submit', function (e) {
                e.preventDefault();

                fetch('{{ route("notifications.markAllAsRead") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        setNavBadge(0);

                        // Remove unread dots and styling from all items
                        document.querySelectorAll('.notification-item.unread').forEach(item => {
                            item.classList.remove('unread');
                            item.setAttribute('data-is-unread', '0');
                            const indicator = item.querySelector('.unread-indicator');
                            if (indicator) indicator.innerHTML = '';
                        });

                        // Hide mark all button
                        markAllForm.style.display = 'none';
                    }
                })
                .catch(() => {
                    // Fallback to standard form submit if fetch fails
                    markAllForm.submit();
                });
            });
        }

        // Handle inline "Mark Read" buttons
        document.querySelectorAll('.inline-mark-read').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const item = this.closest('.notification-item');
                const readUrl = this.getAttribute('data-read-url');

                fetch(readUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        setNavBadge(data.unread_count);

                        // Mark this item as read visually
                        item.classList.remove('unread');
                        item.setAttribute('data-is-unread', '0');
                        const indicator = item.querySelector('.unread-indicator');
                        if (indicator) indicator.innerHTML = '';

                        // If no more unread, hide mark all button
                        if (data.unread_count === 0 && markAllForm) {
                            markAllForm.style.display = 'none';
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                });
            });
        });
    });
</script>

@endsection