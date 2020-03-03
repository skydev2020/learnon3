<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    //returning all subjects for a Grade
    public function subjects() {
        return $this->belongsToMany('App\Subject');
    }
}
