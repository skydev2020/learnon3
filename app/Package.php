<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'id', 'name', 'description', 'price_canada', 'price_usa', 'price_others', 'hours', 'status',
         'count'
    ];
}
