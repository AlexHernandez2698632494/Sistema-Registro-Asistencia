<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class propagation extends Mailable
{
    use Queueable, SerializesModels;

    public $nameEvent;
    public $place;
    public $date;
    public $time;
    public $description;
    public $price;
    public $image;
    public $subject = "Te invitamos a nuestro Evento";

    public function __construct($nameEvent,$place,$date,$time,$description,$price,$image)
    {
        $this->nameEvent = $nameEvent;
        $this->place = $place;
        $this->date = $date;
        $this->time = $time;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Propagation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.propagations',
            with: [
                'nameEvent' => $this->nameEvent,
                'place' => $this->place,
                'date' => $this->date,
                'time' => $this->time,
                'description' => $this->description,
                'image' => $this->image
            ]
            // with[
            //     'nameEvent' => $this->nameEvent,
            //     'place' => $this->place,               
            //     'date' => $this->date,            
            //     'time' => $this->time,             
            //     'description' => $this->description,
            //     'price' => $this->price,               
            //     'image' => $this->image
            // ]
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
