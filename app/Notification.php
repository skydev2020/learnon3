<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notification_from', 'notification_to', 'headers', 'subject', 'message'
    ];
}
