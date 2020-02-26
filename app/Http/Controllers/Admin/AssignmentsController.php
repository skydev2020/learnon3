<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Assignment;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Config;

class AssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->validate($request, [
            's_name' => 'nullable|string',
            't_name' => 'nullable|string',
            'a_id'   => 'nullable|numeric',
            'a_date' => 'nullable|date',
        ]);

        // $s_name = isset($_GET['s_name']) ? trim($_GET['s_name']) : "";
        // $t_name =  isset($_GET['t_name']) ? trim($_GET['t_name']) : "";
        // $a_id = isset($_GET['a_id']) ? trim($_GET['a_id']) : "";
        // $a_date = isset($_GET['a_date']) ? trim($_GET['a_date']) : "";

        $q = "1=1 ";
        if (isset($data['a_id'])) {
            $q.= " and id like '%".$data['a_id']."%'";
        }

        if (isset($data['a_date'])) {
            $q.= " and created_at like '%".$data['a_date']."%'";
        }

        $assignments = Assignment::query()->whereRaw($q);

        if (isset($data['s_name']))
        {
            $assignments = Assignment::whereHas('students', function($student) use ($data) {
                return $student->where('fname', 'like', "%" . $data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $data['s_name'] . "%");
            });
        }

        if (isset($data['t_name']))
        {
            $assignments = Assignment::whereHas('tutors', function($tutor) use ($data) {
                return $tutor->where('fname', 'like', "%" . $data['t_name'] . "%")
                ->orwhere('lname', 'like', "%" . $data['t_name'] . "%");
            });
        }

        $assignments = $assignments->get();

        if( count($assignments) != 0 )
        {
            return view('admin.assignments.index')->with('assignments', $assignments);
        }

        //$assignments = Assignment::all();

        session()->flash('error', null);
        if (count($assignments) == 0) {
            session()->flash('error', "No search results!");
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
            'subject_value'         => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', "There was an error creating the assignment");
            $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
            $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
            return redirect(route('admin.assignments.create'));
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
            return redirect(route('admin.users.assignments.create'));
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
