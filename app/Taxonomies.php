<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxonomies extends Model
{
    protected $fillable = [
        'id',
        'id_template',
        'order',
        'id_component'
    ];
}
