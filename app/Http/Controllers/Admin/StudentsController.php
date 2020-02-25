<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\StudentStatus;
use App\Grade;
use Illuminate\Http\Request;
use Config;
/**
 * StudentsController is working with Students
 * Student is a User whose Role is Student
 */

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource of ROLE_STUDEN
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $s_name = isset($_GET['s_name']) ? trim($_GET['s_name']) : "";
        $s_city =  isset($_GET['s_city']) ? trim($_GET['s_city']) : "";
        $s_date = isset($_GET['s_date']) ? trim($_GET['s_date']) : "";
        $s_sub = isset($_GET['s_sub']) ? trim($_GET['s_sub']) : "";
        $s_status_id = isset($_GET['s_status_id']) ? trim($_GET['s_status_id']) : "";


        // if($s_name) {
        //     $students = $students->where('fname', 'like', "abc");
        // }
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()
        ->where('city','like', '%'. $s_city .'%')
        ->where('created_at', 'like', '%'. $s_date .'%')
        // ->where('subjects', 'like', '%'. $s_sub .'%')
        // ->where('student_status_id', 'like', '%'. $s_status_id .'%')
        // ->where('fname', 'like', '%'. $s_name .'%')
        // ->orWhere('lname', 'like', '%'. $s_name .'%')
        ->get();

        //$students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->where('email','like', '%learnon%')->get();
        // $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        $student_statuses = StudentStatus::all();
        $data = [
            'students' => $students,
            'student_statuses' => $student_statuses,
            'old' => [
                's_name' => $s_name,
                's_city' => $s_city,
                's_date' => $s_date,
                's_sub' => $s_sub,
                's_status_id' => $s_status_id,
                ]
        ];


        if (count($students) == 0) {
            session()->flash('error', "No search results!");
        }

        return view('admin.students.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


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
    public function show(User $student)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $student)
    {
        return view('admin.students.contract')->with([
            'student' => $student
        ]);
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
}
