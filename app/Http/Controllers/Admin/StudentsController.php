<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\StudentStatus;
use App\Grade;
use App\Referrer;
use App\State;
use Illuminate\Http\Request;
use Config;
use App\Subject;
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

        $q = "1=1 ";

        if ($s_city) {
            $q.= " and city like '%".$s_city."%'";
        }

        if ($s_date) {
            $q.= " and created_at like '%".$s_date."%'";
        }

        $q.= " and grade_id >= '1'";

        if ($s_status_id) {
            $q.= " and student_status_id like '%".$s_status_id."%'";
        }

        if ($s_name) {
            $q.= " and (fname like '%".$s_name."%' or lname like '%" .$s_name . "%') ";
        }


        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()
        ->whereRaw($q);

        if ($s_sub) {
            $students = $students->whereHas('subjects', function($subject) use ($s_sub) {
                return $subject->where('name', 'like', "%" . $s_sub . "%");
            });
        }

        $students = $students->get();

        $student_statuses = StudentStatus::all();
        $subjects = Subject::all();
        $data = [
            'students'          => $students,
            'student_statuses'  => $student_statuses,
            'subjects'          => $subjects,
            'old' => [
                's_name' => $s_name,
                's_city' => $s_city,
                's_date' => $s_date,
                's_sub' => $s_sub,
                's_status_id' => $s_status_id,
                ]
        ];

        session()->flash('error', null);
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
        $data = [
            'student'           => $student,
            'referrers'         => Referrer::all(),
            'student_statuses'  => StudentStatus::all()
        ];
        return view('admin.students.show')->with(['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $student)
    {
        $states = State::all();
        $countries = Country::all();
        $grades = Grade::with('subjects')->get();
        $grades_array = $grades->toArray();
        $referrers = Referrer::all();
        $student_statuses = StudentStatus::all();
        
        return view('admin.students.edit', compact('grades', 'states', 'countries', 'grades_array', 'referrers'
        , 'student_statuses', 'student'));
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

     /**
     * Manage Invoices
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function manageInvoices(User $student)
    {
        dd('abcdd');
    }

     /**
     * Show Contract
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showContract(User $student)
    {
        dd('abcdd32234');
    }
}
