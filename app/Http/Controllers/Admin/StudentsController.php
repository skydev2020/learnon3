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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    public function update(Request $request, User $student)
    {
        $validator = Validator::make($request->all(), [
            'fname'                 => ['required', 'string', 'max:255'],
            'lname'                 => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'grade_id'              => ['required', 'integer'],
            'subjects'              => ['required', 'Array'],
            'home_phone'            => ['required', 'string'],
            'cell_phone'            => ['required', 'string'],
            'address'               => ['required', 'string'],
            'city'                  => ['required', 'string'],
            'state_id'              => ['required', 'integer'],
            'pcode'                 => ['required', 'string'],
            'country_id'            => ['required', 'integer'],
            'parent_fname'          => ['required', 'string'],
            'parent_lname'          => ['required', 'string'],
            'service_method'        => ['required', 'string'],
            'other_notes'           => ['required', 'string'],
            'school'                => ['required', 'string'],
            'major_intersection'    => ['required', 'string'],
            'referrer_id'           => ['required', 'integer'],
            'student_status_id'     => ['required', 'integer'],
            'approved'              => ['required', 'integer'],
            'status'                => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator -> messages() -> first());
            return redirect()->route('admin.students.edit', $student);
        }
        $data = $request->all();
        $student-> email = $data['email'];
        $student-> password = Hash::make($data['password']);
        $student-> fname = $data['fname'];
        $student-> lname = $data['lname'];
        $student-> grade_id = $data['grade_id'];
        $student-> parent_fname = $data['parent_fname'];
        $student-> parent_lname = $data['parent_lname'];
        $student-> home_phone = $data['home_phone'];
        $student-> cell_phone = $data['cell_phone'];
        $student-> address = $data['address'];
        $student-> city = $data['city'];
        $student-> state_id = $data['state_id'];
        $student-> pcode = $data['pcode'];
        $student-> country_id = $data['country_id'];
        $student-> service_method = $data['service_method'];
        $student-> other_notes = $data['other_notes'];
        $student-> major_intersection = $data['major_intersection'];
        $student-> school = $data['school'];
        $student-> referrer_id = $data['referrer_id'];
        $student-> student_status_id = $data['student_status_id'];
        $student-> approved = $data['approved'];
        $student-> status = $data['status'];
        
        $student-> subjects() -> sync($data['subjects']);
        if (!$student->save())
        {
            session()->flash('error', "There is an error modifying student!");
            return redirect()->route('admin.students.edit', $student);
        }
        session()->flash('success', "You have modified student!");
        return redirect()->route('admin.students.index');
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
