<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlAlias extends Model
{
    protected $fillable = [
        'query', 'keyword'
    ];
}
