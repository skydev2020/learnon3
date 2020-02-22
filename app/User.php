<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'email', 'password', 'home_phone', 'cell_phone', 'address', 'city', 'state_id', 'pcode',
         'country_id', 'grade_id', 'parent_fname', 'parent_lname', 'street', 'school', 'how_id'
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
}
