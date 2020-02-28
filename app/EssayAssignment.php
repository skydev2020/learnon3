<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EssayAssignment extends Model
{
    public function students() {
        return $this->belongsTo('App\User', 'student_id');
    }

    public function tutors() {
        return $this->belongsTo('App\User', 'tutor_id');
    }

    public function statuses() {
        return $this->belongsTo('App\EssayStatus', 'status_id');
    }
}
