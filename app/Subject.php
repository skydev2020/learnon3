<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function grades() {
        return $this->belongsTo('App\Grade');
    }
}
