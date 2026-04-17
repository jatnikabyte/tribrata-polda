<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfileVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $token,
        public string $name,
        public string $action = 'update_profile' // 'update_profile' or 'update_password'
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->action === 'update_password'
            ? 'Kode Verifikasi Ubah Password'
            : 'Kode Verifikasi Ubah Profil';

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.profile-verification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
