<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CashierVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $token,
        public string $name
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Email Kasir - '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cashier-verification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
