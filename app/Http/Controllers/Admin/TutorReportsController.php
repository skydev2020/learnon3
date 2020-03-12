<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Session;
use App\Assignment;
use Illuminate\Http\Request;

class TutorReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
        $tutor_reports = Array();
        foreach($tutors as $tutor)
        {
            //Get Total Students Tutored Count per tutor
            $sessions = Session::whereHas('assignments', function($assignment) use ($tutor){
                return $assignment->where('tutor_id', $tutor->id);
            })->get();
            $students_tutored = (float)count($sessions);

            //Get Total Hours Tutored per tutor
            $sessions = Session::whereHas('assignments', function($assignment) use ($tutor){
                return $assignment->where('tutor_id', $tutor->id);
            })->get('session_duration');
            $hours_tutored = (float)array_sum($sessions);

            //Get Average Hours Per Student with each tutor
            $avg_hours = (float)($hours_tutored / $students_tutored);

            //Get Total Hours Tutored per tutor
            $session_dates = Session::whereHas('assignments', function($assignment) use ($tutor){
                return $assignment->where('tutor_id', $tutor->id);
            })->get('session_date');
            $avg_duration = get_durations($session_dates) / $students_tutored;


        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function get_durations(Array $dates)
    {
        $min_date = $dates->first();
        $max_date = $dates->first();
        foreach($dates as $date) {
            if ($date > $max_date) $max_date = $date;
            if ($date < $min_date) $min_date = $date;
        }

        return (float)date_diff($min_date, $max_date);
    }
}
