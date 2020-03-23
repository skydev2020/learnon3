<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    protected $fillable = [
        'student_id', 'grade_id', 'subjects', 'student_prepared', 'questions_ready', 'pay_attention',
        'weaknesses', 'listen_to_suggestions', 'improvements', 'other_comments', 'tutor_id'
    ];
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