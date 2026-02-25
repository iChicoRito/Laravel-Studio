<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PhotographerRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Photographer data.
     *
     * @var array
     */
    public $photographerData;

    /**
     * Temporary password.
     *
     * @var string
     */
    public $temporaryPassword;

    /**
     * Create a new message instance.
     */
    public function __construct(array $photographerData, string $temporaryPassword)
    {
        $this->photographerData = $photographerData;
        $this->temporaryPassword = $temporaryPassword;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Studio Photographer Account Registration',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.photographer-registration',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
