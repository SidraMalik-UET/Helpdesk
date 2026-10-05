<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAttachment extends Model
{
    protected $fillable = [
        'ticket_id',
        'reply_id',
        'user_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function reply(): BelongsTo
    {
        return $this->belongsTo(TicketReply::class, 'reply_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine if the attachment is an image.
     */
    public function isImage(): bool
    {
        if (!empty($this->file_type) && str_starts_with($this->file_type, 'image/')) {
            return true;
        }

        $extension = strtolower(pathinfo($this->file_name ?? '', PATHINFO_EXTENSION));
        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp']);
    }

    /**
     * Determine if the attachment is a PDF.
     */
    public function isPdf(): bool
    {
        if ($this->file_type === 'application/pdf') {
            return true;
        }

        $extension = strtolower(pathinfo($this->file_name ?? '', PATHINFO_EXTENSION));
        return $extension === 'pdf';
    }

    /**
     * Return formatted human-readable file size.
     */
    public function formattedSize(): string
    {
        $bytes = (int) $this->file_size;
        if ($bytes <= 0) {
            return '';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 1) . ' ' . ($units[$i] ?? 'B');
    }
}