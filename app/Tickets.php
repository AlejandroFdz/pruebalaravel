<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $fillable = [
    	'subject',
    	'description',
    	'status',
    	'picture',
    	'client_id'
    ];
}
