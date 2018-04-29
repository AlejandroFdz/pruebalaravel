<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultTemplates extends Model
{
    protected $fillable = [
        'id',
        'components_taxonomy',
        'featured_picture'
    ];
}
