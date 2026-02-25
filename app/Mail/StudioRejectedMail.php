<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\StudioOwner\StudiosModel;

class StudioRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The studio instance.
     *
     * @var \App\Models\StudioOwner\StudiosModel
     */
    public $studio;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\StudioOwner\StudiosModel $studio
     * @return void
     */
    public function __construct(StudiosModel $studio)
    {
        $this->studio = $studio;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Studio Registration Rejected - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.studio-rejected',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}