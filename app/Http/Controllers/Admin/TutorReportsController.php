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
            })->get('session_duration')->pluck('session_duration')->toArray();
            $hours_tutored = (float)array_sum($sessions);

            //Get Average Hours Per Student with each tutor
            if ($students_tutored != 0) {
                $avg_hours = (float)($hours_tutored / $students_tutored);
            } else $avg_hours = "NAN";

            //Get Total Hours Tutored per tutor
            $session_dates = Session::whereHas('assignments', function($assignment) use ($tutor){
                return $assignment->where('tutor_id', $tutor->id);
            })->get('session_date')->pluck('session_date')->toArray();
            if ($students_tutored != 0){
                $avg_duration = $this->get_durations($session_dates) / $students_tutored;
            } else $avg_duration = "NAN";
            $tutor_reports[] = array("Id"=>$tutor['id'], "Tutor Name" => $tutor['fname'] . ' ' . $tutor['lname']
            , 'Email'=>$tutor['email'], 'Students Tutored'=>$students_tutored, 
            'Hours Tutored'=>$hours_tutored, 'Avg Hours Per Student' =>$avg_hours
            , 'Average Duration Per Student'=>$avg_duration);
        }

        return view('admin.tutorreports.index')->with('reports', $tutor_reports);
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
        $min_date = $dates[0];
        $max_date = $dates[0];
        foreach($dates as $date) {
            if ($date > $max_date) $max_date = $date;
            if ($date < $min_date) $min_date = $date;
        }

        // $date_min = date_create($min_date);
        // $date_max = date_create($max_date);
        // //return (float)date_diff($date_min, $date_max);
        // return $date_max - $date_min;
        return (float)(strtotime($max_date) - strtotime($min_date)) / 86400;
    }
}
