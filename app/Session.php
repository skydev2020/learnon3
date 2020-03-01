<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'assignment_id', 'session_date', 'session_duration', 'session_notes'
    ];

    public function assignments() {
        return $this->belongsTo('App\Assignment', 'assignment_id');
    }
}
