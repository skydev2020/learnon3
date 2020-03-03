<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function students() {
        return $this->belongsTo('App\User', 'student_id');
    }
}
