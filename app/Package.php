<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'id', 'name', 'description', 'price_can', 'price_usa', 'price_alb', 'hours', 'status',
         'count', 'prepaid', 'student_id'
    ];
    
    public function grades() {
        return $this -> belongsToMany('App\Grade', 'package_grade');
    }
}
