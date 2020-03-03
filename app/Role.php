<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // returning all users beglong to a Role
    public function users() {
        return $this->belongsToMany('App\User');
    }
}
