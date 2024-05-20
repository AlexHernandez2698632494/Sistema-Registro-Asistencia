<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class Credentials extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $pass;
    public $name;
    public $subjet = "Credenciales de usuario";
    /**
     * Create a new message instance.
     */
    public function __construct($user,$pass,$name)
    {
        $this->user  = $user;
        $this->pass = $pass;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Credentials',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.credentials',
            with: [
                'user' => $this->user,
                'pass' => $this->pass,
                'name' => $this->name
            ]
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
