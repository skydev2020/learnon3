<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    //
    public function students() {
        return $this->belongsTo('App\User', 'student_id');
    }
    
    public function tutors() {
        return $this->belongsTo('App\User', 'tutor_id');
    }

    public function grades() {
        return $this->belongsTo('App\Grade', 'grade_id');
    }
}