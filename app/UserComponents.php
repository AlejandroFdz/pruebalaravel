<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserComponents extends Model
{
    protected $fillable = [
        'id',
        'name',
        'margin',
        'padding',
        'content'
    ];
}
