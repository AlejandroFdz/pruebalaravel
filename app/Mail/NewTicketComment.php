<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTicketComment extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->ticket_id = $data['ticket_id'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Correo Hormiga comentó tu Ticket.')->markdown('emails.tickets.newticketcomment', compact('ticket_id', $this->ticket_id));
    }
}
