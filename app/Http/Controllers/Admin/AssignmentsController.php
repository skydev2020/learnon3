<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Assignment;
use App\Role;
use Illuminate\Http\Request;

class AssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignments = Assignment::all();
        return view('admin.assignments.index')->with('assignments', $assignments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        return view('admin.assignments.create')->with('tutors', $tutors)->with('students', $students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $cur_date = date("d/m/Y");
        $validator = Validator::make($request->all(), [
            'tutor_val'             => ['required', 'integer'],
            'student_val'           => ['required', 'integer'],
            'subject_value'           => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            session()->flash('error', "There was an error creating the assignment");
            $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
            $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
            return redirect(route('admin.users.assignments.create')->with('tutors', $tutors)->with('students', $students));
        }

        $data = $request->all();
        $assignment = Assignment::create([
            'tutor_id'              => $data['tutor_val'],
            'student_id'            => $data['student_val'],
            'subjects'              => $data['subject_value'],
            'base_wage'             => $data['tpay_value'],
            'base_invoice'          => $data['spay_value'],
            'assigned_at'           => $cur_date,
            'status_by_tutor'       => $data['status'],
            'status_by_student'     => $data['status'],
            'final_status'          => $data['status'],
        ]);

        if ($assignment == NULL)
        {
            session()->flash('error', "There was an error creating the assignment");
            $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
            $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
            return redirect(route('admin.users.assignments.create')->with('tutors', $tutors)->with('students', $students));
        }

        session()->flash('success', "The assignment has been created successfully");
        $assignments = Assignment::all();
        return view('admin.assignments.index')->with('assignments', $assignments);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
}
