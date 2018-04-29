<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTemplates extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'featured_picture',
        'default_template_id'
    ];
}
