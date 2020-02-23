<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    //
    
    public function student() {
        $assignments = belongsTo(App\Assignment);
        return $assignments->first();
    }

    public function tutor() {
        $assignments = belongsTo(App\Assignment);
        return $assignments->second();
    }
}
