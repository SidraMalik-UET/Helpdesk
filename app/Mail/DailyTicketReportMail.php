<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyTicketReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $report;

    public function __construct(array $report)
    {
        $this->report = $report;
    }

    public function build(): static
    {
        return $this->subject('Daily Smart Helpdesk Ticket Report')
            ->view('emails.daily-ticket-report');
    }
}
