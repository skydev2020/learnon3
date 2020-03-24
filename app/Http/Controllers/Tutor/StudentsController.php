<?php

namespace App\Http\Controllers\Tutor;

use App\Assignment;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $myuser = Auth::User();
        
        $validator = Validator::make($request->all(), [
            's_name'        => ['nullable', 'string'],
            'status'        => ['nullable', 'string'],
            'assigned_at' => ['nullable', 'date']
        ]);
        if ($validator->fails())
        {
            session() -> flash('error', $validator->message()->first());
            return back();
        }

        $request_data = $request->all();
        $assignments = $myuser->tutor_assignments();
        
        $q = "1=1 ";
        if (isset($request_data['status'])) {
            $q .= " and status_by_tutor like '%" . $request_data['status'] . "%'";
        } else $request_data['status'] = "";

        if (isset($request_data['assigned_at'])) {
            $q .= " and assigned_at like '%" . $request_data['assigned_at'] . "%'";
        } else $request_data['assigned_at'] = "";

        $assignments = $assignments->whereRaw($q);

        if (isset($request_data['s_name'])) {
            $assignments = $assignments->whereHas('students', function($student) use ($request_data){
                return $student->where('fname', 'like' , "%" . $request_data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
            });  
        } else $request_data['s_name'] = "";
        
        $assignments = $assignments->get();
        $subjects_array = Array();
        foreach ($assignments as $assignment) 
        {
            $subjects_array[$assignment->id] = "";
            $subjects = $assignment->subjects()->get();
            foreach ($subjects as $subject) {
                $subjects_array[$assignment->id] .= $subject->name . ',';
            }
            $subjects_array[$assignment->id] = rtrim($subjects_array[$assignment->id], ',');
        }

        $data = [
            'subjects'      => $subjects_array,
            'assignments'   => $assignments,
            'old'           => $request_data,
        ];
         
        return view('tutor.students.index') -> with('data', $data);
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
    public function show(User $student)
    {
        $tutor_id = Auth::User()->id;
        $assignment = Assignment::where(function($assignment) use ($tutor_id, $student){
            return $assignment->where('tutor_id', $tutor_id)
            -> where('student_id', $student->id);
        }) -> first();

        $subjects_result = "";

        $subjects = $assignment->subjects()->get();
        foreach ($subjects as $subject) {
            $subjects_result .= $subject->name . ',';
        }
        $subjects_result = rtrim($subjects_result, ',');

        $data = [
            'subjects'      => $subjects_result,
            'assignment'    => $assignment,
            'student'       => $student
        ];

        return view('tutor.students.show') -> with('data', $data);
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

    public function changeStatus(Assignment $assignment)
    {
        $assignment->status_by_tutor = ($assignment->status_by_tutor == "Active") ? "Stop Tutoring" : "Active";
        if (!$assignment->save()) session()->flash('error', "There is an error updating Student(s) status.");
        else session()->flash('success', "Student(s) status successfully updated.");

        return redirect()->route('tutor.students.index');
    }
}
