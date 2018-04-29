<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailQueueNotify extends Model
{
    public $table = 'email_queue_notify';

    protected $fillable = [
    	'id_user',
    	'email'
    ];
}
