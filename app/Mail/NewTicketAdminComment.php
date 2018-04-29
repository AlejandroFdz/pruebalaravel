<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTicketAdminComment extends Mailable
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
        return $this->subject('Un cliente comentó su Ticket.')->markdown('emails.admin.newticketadmincomment', compact('ticket_id', $this->ticket_id));
    }
}
