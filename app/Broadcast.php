<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $fillable = [
        'title', 'subject', 'content', 'status'
    ];
}
