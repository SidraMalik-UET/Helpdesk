<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ticket #{{ $ticket->id }} - HelpDesk</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            margin: 0;
            color: #333;
        }

        .container {
            width: 750px;
            max-width: 90%;
            margin: 50px auto;
        }

        .back {
            color: #555;
            text-decoration: none;
        }

        .back:hover {
            text-decoration: underline;
        }

        .card {
            background: white;
            padding: 30px;
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top h1 {
            margin: 0;
        }

        .badge {
            background: #eee;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        .description {
            margin-top: 30px;
            line-height: 1.7;
            color: #444;
        }

        .info {
            margin-top: 25px;
            color: #666;
        }

        .replies-section {
            margin-top: 30px;
        }

        .replies-section h2 {
            margin-bottom: 15px;
        }

        .reply-card {
            background: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        }

        .reply-card strong {
            display: block;
            margin-bottom: 10px;
        }

        .reply-card p {
            margin: 0 0 10px;
            line-height: 1.6;
            color: #444;
        }

        .reply-card small {
            color: #888;
        }

        /* Attachments */

        .attachment-list {
            margin-top: 15px;
            padding-top: 12px;
            border-top: 1px solid #eee;
        }

        .attachment-list strong {
            display: block;
            margin-bottom: 10px;
        }

        .attachment-item {
            margin-top: 8px;
        }

        .attachment-item a {
            color: #222;
            text-decoration: none;
        }

        .attachment-item a:hover {
            text-decoration: underline;
        }

        .attachment-image {
            display: block;
            max-width: 300px;
            max-height: 250px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        /* Reply Form */

        .reply-form {
            background: white;
            padding: 25px;
            margin-top: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .reply-form h2 {
            margin-top: 0;
            margin-bottom: 15px;
        }

        .reply-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            resize: vertical;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .attachment-field {
            margin-top: 15px;
        }

        .attachment-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .attachment-field input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            background: #fafafa;
        }

        .attachment-field small {
            display: block;
            margin-top: 6px;
            color: #888;
        }

        .reply-form button {
            margin-top: 15px;
            padding: 11px 20px;
            border: none;
            border-radius: 7px;
            background: #222;
            color: white;
            cursor: pointer;
        }

        .reply-form button:hover {
            background: #444;
        }

        .error {
            color: #d33;
            font-size: 14px;
            margin-top: 8px;
        }

        .success {
            background: #e8f7e8;
            color: #276327;
            padding: 12px 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    {{-- Back to My Tickets --}}
    <a href="{{ route('tickets.index') }}" class="back">
        ← Back to My Tickets
    </a>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif


    {{-- Ticket Details --}}
    <div class="card">

        <div class="top">

            <h1>
                Ticket #{{ $ticket->id }}
            </h1>

            <span class="badge">
                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
            </span>

        </div>


        <h2>
            {{ $ticket->subject }}
        </h2>


        <div class="description">
            {{ $ticket->description }}
        </div>


        <div class="info">

            <p>
                <strong>Priority:</strong>
                {{ ucfirst($ticket->priority) }}
            </p>

            <p>
                <strong>Created:</strong>
                {{ $ticket->created_at->format('d M Y, h:i A') }}
            </p>

        </div>

        {{-- Original Ticket Attachments --}}
        @php
            $ticketAttachments = $ticket->attachments->whereNull('reply_id');
        @endphp

        @if($ticketAttachments->isNotEmpty())
            <div class="attachment-list" style="margin-top: 25px; padding-top: 18px; border-top: 1px solid #eee;">
                <strong>Original Attachments:</strong>

                @foreach($ticketAttachments as $attachment)
                    <div class="attachment-item">
                        <a
                            href="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                            target="_blank"
                            style="font-weight: 600; color: #2563eb;"
                        >
                            📎 {{ $attachment->file_name }}
                            @if($attachment->formattedSize())
                                <small style="color: #6b7280; font-weight: normal;">({{ $attachment->formattedSize() }})</small>
                            @endif
                        </a>

                        @if($attachment->isImage())
                            <a
                                href="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                                target="_blank"
                            >
                                <img
                                    src="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                                    alt="{{ $attachment->file_name }}"
                                    class="attachment-image"
                                    loading="lazy"
                                >
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </div>


    {{-- Replies --}}
    <div class="replies-section">

        <h2>Replies</h2>

        @forelse($ticket->replies as $reply)

            <div class="reply-card">

                <strong>
                    {{ $reply->user->name }}
                </strong>

                <p>
                    {{ $reply->message }}
                </p>


                {{-- Reply Attachments --}}
                @if($reply->attachments->count() > 0)

                    <div class="attachment-list">

                        <strong>
                            Attachments:
                        </strong>

                        @foreach($reply->attachments as $attachment)

                            <div class="attachment-item">

                                <a
                                    href="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                                    target="_blank"
                                    style="font-weight: 600; color: #2563eb;"
                                >
                                    📎 {{ $attachment->file_name }}
                                    @if($attachment->formattedSize())
                                        <small style="color: #6b7280; font-weight: normal;">({{ $attachment->formattedSize() }})</small>
                                    @endif
                                </a>

                                {{-- Show image preview directly --}}
                                @if($attachment->isImage())

                                    <a
                                        href="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                                        target="_blank"
                                    >
                                        <img
                                            src="{{ route('tickets.attachments.show', [$ticket, $attachment]) }}"
                                            alt="{{ $attachment->file_name }}"
                                            class="attachment-image"
                                            loading="lazy"
                                        >
                                    </a>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @endif


                <small>
                    {{ $reply->created_at->format('d M Y, h:i A') }}
                </small>

            </div>

        @empty

            <p>No replies yet.</p>

        @endforelse

    </div>


    {{-- Add Reply --}}
    <div class="reply-form">

        <h2>Add a Reply</h2>

        <form
            action="{{ route('tickets.reply', $ticket) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            {{-- Message --}}
            <textarea
                name="message"
                rows="5"
                placeholder="Write your reply..."
                required
            >{{ old('message') }}</textarea>

            @error('message')
                <p class="error">
                    {{ $message }}
                </p>
            @enderror


            {{-- Attachment --}}
            <div class="attachment-field">

                <label for="attachment">
                    Attachment
                </label>

                <input
                    type="file"
                    id="attachment"
                    name="attachment"
                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                >

                <small>
                    Allowed: JPG, JPEG, PNG, PDF, DOC, DOCX — Maximum 5MB
                </small>

                @error('attachment')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <button type="submit">
                Send Reply
            </button>

        </form>

    </div>

</div>

</body>

</html>