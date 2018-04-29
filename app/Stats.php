<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    protected $fillable = [
    	'list_id',
    	'subscriber_id',
    	'opened',
    	'clicks'
    ];
}
