<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    protected $fillable = [
    	'name',
    	'subject',
    	'from',
    	'email',
    	'id_user',
    	'company'
    ];
}
