<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Grade;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Config;
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
        //$students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->where('email','like', '%learnon%')->get();
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        return view('admin.students.index')->with('students', $students);
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
    public function show()
    {
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()
        ->where('fname', '>=', $_GET['s_name'])
        ->where('city','>=', $_GET['s_city'])
        ->where('created_at', '>=', $_GET['s_date'])
        ->where('subjects', '>=', $_GET['s_sub'])
        ->get();

        if (count($students) != 0)
            return view('admin.students.index')->with('students', $students);

        else {
            session()->flash('error', "No search results!");
            $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
            return view('admin.students.index')->with('students', $students);
        }
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
