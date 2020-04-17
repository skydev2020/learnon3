<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notification_from', 'notification_to', 'headers', 'subject', 'message'
    ];

    public function from_user()
    {
        return $this->belongsTo('App\User', 'notification_from')->first();
    }

    public static function addInformation($from, $to, $subject, $message)
    {
        return Notification::create([
            'notification_from'     => $from,
            'notification_to'       => $to,
            'subject'               => $subject,
            'message'               => $message
        ]);
    }
}
