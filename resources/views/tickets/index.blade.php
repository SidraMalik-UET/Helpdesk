<!DOCTYPE html>
<html>
<head>
    <title>My Tickets - HelpDesk</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            margin: 0;
        }

        .container {
            width: 900px;
            max-width: 92%;
            margin: 50px auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .create-btn {
            background: #111;
            color: white;
            padding: 12px 18px;
            border-radius: 7px;
            text-decoration: none;
        }

        .ticket {
            background: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.06);
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
        }

        .subject {
            font-size: 19px;
            font-weight: bold;
        }

        .status,
        .priority {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            background: #eee;
        }

        .details {
            color: #666;
            margin: 10px 0;
        }

        .view-btn {
            color: #111;
            text-decoration: none;
            font-weight: bold;
        }

        .success {
            background: #e4f7e9;
            color: #237a3b;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .empty {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <div>
            <h1>My Tickets</h1>
            <p>View and track your support requests.</p>
        </div>

        <a href="{{ route('tickets.create') }}" class="create-btn">
            + Create Ticket
        </a>

    </div>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif


    @forelse ($tickets as $ticket)

        <div class="ticket">

            <div class="ticket-header">

                <div class="subject">
                    {{ $ticket->subject }}
                </div>

                <span class="status">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>

            </div>

            <div class="details">

                Priority:
                <strong>
                    {{ ucfirst($ticket->priority) }}
                </strong>

                &nbsp; | &nbsp;

                Created:
                {{ $ticket->created_at->format('d M Y') }}

            </div>

            <a
                href="{{ route('tickets.show', $ticket) }}"
                class="view-btn"
            >
                View Ticket →
            </a>

        </div>

    @empty

        <div class="empty">

            <h2>No tickets yet</h2>

            <p>You haven't created any support tickets.</p>

            <a href="{{ route('tickets.create') }}">
                Create your first ticket
            </a>

        </div>

    @endforelse

</div>

</body>
</html>