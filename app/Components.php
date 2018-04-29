<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Components extends Model
{
    protected $fillable = [
        'id',
        'name',
        'margin',
        'padding',
        'content'
    ];
}
