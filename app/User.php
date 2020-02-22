<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'email', 'password', 'home_phone', 'cell_phone', 'address', 'city', 'state_id', 'pcode',
         'country_id', 'grade_id', 'subjects', 'parent_fname', 'parent_lname', 'street', 'school', 'how_id', 'other_notes',
         'post_secondary_edu', 'area_of_concentration', 'tutoring_courses', 'work_experience', 'tutoring_areas',
         'gender', 'certified_teacher', 'criminal_record', 'criminal_check'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function hasAnyRoles($roleNames) {
        if ($this->roles()->whereIn('name', $roleNames)->first()) {
            return true;
        }

        return false;
    }

    public function hasRole($roleName) {
        if ($this->roles()->where('name', $roleName)->first()) {
            return true;
        }

        return false;
    }

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function state(){
        return $this->belongsTo('App\State');
    }

    public function grade(){
        return $this->belongsTo('App\Grade');
    }

    public function how(){
        return $this->belongsTo('App\How');
    }
}
