<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    protected $fillable = [
    	'name', 
    	'description',
    	'client_id',
    ];
}
