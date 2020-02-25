<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Assignment;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

        foreach ($assignments as $key => $assignment){
            if (!isset($_GET['s_name'])) break;
            $s_fullname = $assignment->student()['fname'] . ' ' . $assignment->student()['lname'];
            $t_fullname = $assignment->tutor()['fname'] . ' ' . $assignment->tutor()['lname'];
            if ($_GET['s_name'] != "" && strpos($s_fullname, $_GET['s_name']) === false) unset($assignments[$key]);
            else if ($_GET['t_name'] != "" && strpos($t_fullname, $_GET['t_name']) === false) unset($assignments[$key]);

            else if ($_GET['a_id'] != "" && $assignment->id != $_GET['a_id'])
            {
                unset($assignments[$key]);
            }

            else if($_GET['a_date'] != "" && strpos($assignment->created_at, $_GET['a_date']) === false)
            {
                unset($assignments[$key]);
            }
        }

        if (count($assignments) != 0)
            return view('admin.assignments.index')->with('assignments', $assignments);

        else {
            session()->flash('error', "No search results!");
            $assignments = Assignment::all();
            return view('admin.assignments.index')->with('assignments', $assignments);
        }

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
        $validator = Validator::make($request->all(), [
            'tutor_val'             => ['required', 'integer'],
            'student_val'           => ['required', 'integer'],
            'subject_value'           => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', "There was an error creating the assignment");
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
            'status_by_tutor'       => $data['status'],
            'status_by_student'     => $data['status'],
            'final_status'          => $data['status'],
        ]);

        if ($assignment == NULL)
        {
            $request->session()->flash('error', "There was an error creating the assignment");
            $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
            $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
            return redirect(route('admin.users.assignments.create')->with('tutors', $tutors)->with('students', $students));
        }

        $request->session()->flash('success', "The assignment has been created successfully");
        $assignments = Assignment::all();
        return view('admin.assignments.index')->with('assignments', $assignments);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignments)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        if (Gate::denies('edit-users')) {
            return redirect(route('admin.users.index'));
        }
        
        $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        return view('admin.assignments.edit')->with([
            'assignment' => $assignment, 'tutors' => $tutors, 'students' => $students]);
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
        $assignment->tutor_id = $request->tutor_val;
        $assignment->student_id =$request->student_val;
        $assignment->subjects = $request->subject_value;
        $assignment->base_wage = $request->tpay_value;
        $assignment->base_invoice = $request->spay_value;
        $assignment->status_by_tutor = $request->status;
        $assignment->status_by_student = $request->status;
        $assignment->final_status = $request->status;

        if ($assignment->save()){
            $request->session()->flash('success', 'The assignment has been updated successfully');
        } else {
            $request->session()->flash('error', 'There was an error updating the assignment');
        }

        $assignments = Assignment::all();
        return redirect()->route('admin.assignments.index')->with('assignments', $assignments);
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
