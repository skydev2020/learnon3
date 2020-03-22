<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    //
    protected $fillable = [
        'tutor_id', 'student_id', 'subjects', 'base_wage', 'base_invoice', 'total_hour worked', 'assigned_at', 'city',
         'status_by_tutor', 'status_by_students', 'final_status'
    ];

    
    public function student() {
        return $this->belongsTo('App\User', 'student_id')->first();
    }

    public function tutor() {
        return $this->belongsTo('App\User', 'tutor_id')->first();
    }

    public function students() {
        return $this->belongsTo('App\User', 'student_id');
    }

    public function tutors() {
        return $this->belongsTo('App\User', 'tutor_id');
    }

    public function sessions() {
        return $this -> hasMany('App\Session', 'assignment_id');
    }
}
