<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EssayAssignment extends Model
{
    protected $fillable = [
        'assignment_num', 'topic', 'description', 'format', 'student_id', 'tutor_id', 'paid', 'owed',
         'date_assigned', 'date_completed', 'date_due', 'status_id'
    ];

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
