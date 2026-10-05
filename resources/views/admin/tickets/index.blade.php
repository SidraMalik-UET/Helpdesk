@extends('admin.layout')

@section('title', 'Manage Tickets')

@section('content')

<div class="tickets-page">

    <div class="page-header">
        <div>
            <h1>Manage Tickets</h1>
            <p>View customer tickets and assign active agents.</p>
        </div>

        <div class="ticket-count">
            {{ $tickets->count() }} Tickets
        </div>
    </div>


    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if($tickets->count())

        <div class="tickets-card">

            @foreach($tickets as $ticket)

                <div class="ticket-item">

                    <div class="ticket-info">

                        <div class="ticket-top">

                            <span class="ticket-number">
                                #{{ $ticket->id }}
                            </span>

                            <span class="status {{ $ticket->status }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>

                        </div>


                        <h2>
                            {{ $ticket->subject }}
                        </h2>


                        <div class="ticket-details">

                            <span>
                                <strong>Customer:</strong>
                                {{ $ticket->user->name ?? 'Unknown' }}
                            </span>

                            <span>
                                <strong>Category:</strong>
                                {{ $ticket->category->name ?? 'N/A' }}
                            </span>

                            <span>
                                <strong>Priority:</strong>
                                {{ ucfirst($ticket->priority) }}
                            </span>

                        </div>


                        <div class="assigned-info">

                            <strong>Assigned Agent:</strong>

                            @if($ticket->assignedAgent)

                                <span class="assigned-agent">
                                    {{ $ticket->assignedAgent->name }}
                                </span>

                            @else

                                <span class="not-assigned">
                                    Not assigned
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="ticket-actions">

                        <form
                            action="{{ route('admin.tickets.assign', $ticket) }}"
                            method="POST"
                        >

                            @csrf

                            <select name="assigned_to" required>

                                <option value="">
                                    Select Agent
                                </option>

                                @foreach($agents as $agent)

                                    <option
                                        value="{{ $agent->id }}"
                                        {{ $ticket->assigned_to == $agent->id ? 'selected' : '' }}
                                    >
                                        {{ $agent->name }}
                                    </option>

                                @endforeach

                            </select>


                            <button type="submit">
                                Assign Agent
                            </button>

                        </form>


                        @if(Route::has('admin.tickets.show'))

                            <a
                                href="{{ route('admin.tickets.show', $ticket) }}"
                                class="view-button"
                            >
                                View Ticket
                            </a>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                🎫
            </div>

            <h2>No Tickets Yet</h2>

            <p>
                Customer tickets will appear here.
            </p>

        </div>

    @endif

</div>


<style>

.tickets-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 20px 60px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.page-header h1 {
    margin: 0 0 6px;
    color: #111827;
    font-size: 30px;
}

.page-header p {
    margin: 0;
    color: #6b7280;
    font-size: 14px;
}

.ticket-count {
    background: #eff6ff;
    color: #2563eb;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
}

.alert-success {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
    padding: 13px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.tickets-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
}

.ticket-item {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    padding: 24px;
    border-bottom: 1px solid #e5e7eb;
}

.ticket-item:last-child {
    border-bottom: none;
}

.ticket-info {
    flex: 1;
}

.ticket-top {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.ticket-number {
    color: #6b7280;
    font-size: 13px;
    font-weight: 600;
}

.status {
    padding: 5px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    text-transform: capitalize;
}

.status.open {
    background: #eff6ff;
    color: #2563eb;
}

.status.in_progress {
    background: #fff7ed;
    color: #c2410c;
}

.status.resolved {
    background: #ecfdf5;
    color: #047857;
}

.status.closed {
    background: #f3f4f6;
    color: #4b5563;
}

.ticket-info h2 {
    margin: 0 0 14px;
    color: #111827;
    font-size: 18px;
}

.ticket-details {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    color: #6b7280;
    font-size: 13px;
}

.ticket-details strong {
    color: #374151;
}

.assigned-info {
    margin-top: 15px;
    font-size: 13px;
    color: #374151;
}

.assigned-agent {
    margin-left: 6px;
    color: #2563eb;
    font-weight: 600;
}

.not-assigned {
    margin-left: 6px;
    color: #9ca3af;
}

.ticket-actions {
    width: 230px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: center;
}

.ticket-actions form {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.ticket-actions select {
    width: 100%;
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    background: white;
    font-size: 13px;
}

.ticket-actions button {
    border: none;
    background: #2563eb;
    color: white;
    padding: 10px;
    border-radius: 7px;
    cursor: pointer;
    font-weight: 600;
}

.ticket-actions button:hover {
    background: #1d4ed8;
}

.view-button {
    display: block;
    text-align: center;
    text-decoration: none;
    background: #f8fafc;
    color: #374151;
    border: 1px solid #d1d5db;
    padding: 9px;
    border-radius: 7px;
    font-size: 13px;
}

.empty-state {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    text-align: center;
    padding: 70px 20px;
}

.empty-icon {
    font-size: 40px;
    margin-bottom: 15px;
}

.empty-state h2 {
    margin-bottom: 8px;
    color: #111827;
}

.empty-state p {
    color: #6b7280;
}

@media (max-width: 800px) {

    .ticket-item {
        flex-direction: column;
    }

    .ticket-actions {
        width: 100%;
    }

    .page-header {
        align-items: flex-start;
        gap: 15px;
        flex-direction: column;
    }

}

</style>

@endsection