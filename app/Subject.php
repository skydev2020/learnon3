<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //returning all grades for a Subject
    public function grades() {
        return $this->belongsTo('App\Grade');
    }
}
