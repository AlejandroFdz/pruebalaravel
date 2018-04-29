<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketComments extends Model
{
    public $table = "comments";

    protected $fillable = [
    	'subject',
    	'description',
    	'ticket_id',
    	'client_id'
    ];
}
