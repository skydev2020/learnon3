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
         'country_id', 'grade_id', 'student_status_id', 'parent_fname', 'parent_lname', 'street', 'school', 'referrer_id',
         'other_notes', 'post_secondary_edu', 'subjects_studied', 'tutoring_courses', 'work_experience', 'tutoring_areas',
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

    public function studentStatus(){
        return $this->belongsTo('App\StudentStatus');
    }

    public function state(){
        return $this->belongsTo('App\State');
    }

    public function grades(){
        return $this->belongsTo('App\Grade', 'grade_id');
    }

    public function referrer(){
        return $this->belongsTo('App\Referrer');
    }

    //returning all subjects for a User
    public function subjects() {
        return $this->belongsToMany('App\Subject', 'user_subject');
    }

    public function assignments() {
        return $this -> hasMany('App\Assignment', 'student_id');
    }

    public function tutor_assignments() {
        return $this -> hasMany('App\Assignment', 'tutor_id');
    }

    public function tutor_essayAssignments() {
        return $this -> hasMany('App\EssayAssignment', 'tutor_id');
    }

    public function paycheques(){
        return $this -> hasMany('App\Paycheque', 'user_id');
    }

    public function tutor_reportcards() {
        return $this -> hasMany('App\ProgressReport', 'tutor_id');
    }

    public function fullname() {
        return $this -> fname . ' ' . $this->lname;
    }

    public function invoices() {
        return $this -> hasMany('App\Invoice', 'user_id');
    }
}
