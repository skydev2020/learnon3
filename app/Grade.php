<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'name', 'price_usa', 'price_alb', 'price_can'
    ];

    //returning all subjects for a Grade
    public function subjects() {
        return $this->belongsToMany('App\Subject');
    }
}
