<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'ip_address', 'platform', 'activity', 'activity_details'
    ];

    public function users() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public static function log_activity($user_id, $activity, $activity_details="") {
        return ActivityLog::create([
            'user_id'           => $user_id,
            'ip_address'        => $_SERVER['REMOTE_ADDR'],
            'platform'          => $_SERVER['HTTP_USER_AGENT'],
            'activity'          => $activity,
            'activity_details'  => $activity_details
        ]);
    }
}
