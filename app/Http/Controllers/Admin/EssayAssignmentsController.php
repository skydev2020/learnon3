<?php

namespace App\Http\Controllers\Admin;

use App\EssayAssignment;
use App\Http\Controllers\Controller;

use App\Role;
use App\EssayStatus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EssayAssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            'a_id'              => 'nullable|integer',
            's_name'            => 'nullable|string',
            't_name'            => 'nullable|string',
            'topic'             => 'nullable|string',
            'status'            => 'nullable|string',
            'paid_to_tutor'     => 'nullable|string',
            'price_owed'        => 'nullable|string',
            'a_date_from'       => 'nullable|date',
            'a_date_to'         => 'nullable|date',
            'c_date_from'       => 'nullable|date',
            'c_date_to'         => 'nullable|date',
        ]);

        $q = "1=1 ";

        if (isset($request_data['a_id'])) {
            $q.= " and assignment_num like " . $request_data['a_id'];
        } else $request_data['a_id'] = "";

        if (isset($request_data['topic'])) {
            $q.= " and topic like '%" . $request_data['topic'] . "%'";
        } else $request_data['topic'] = "";

        if (isset($request_data['status'])) {
            $q.= " and status_id like " . $request_data['status'];
        } else $request_data['status'] = "";

        if (isset($request_data['paid_to_tutor'])) {
            $q.= " and paid like " . (string)number_format($request_data['paid_to_tutor'], 2);
        } else $request_data['paid_to_tutor'] = "";

        if (isset($request_data['price_owed'])) {
            $q.= " and owed like " . (string)number_format($request_data['price_owed'], 2);
        } else $request_data['price_owed'] = "";

        // dd($q);
        $essay_assignments = EssayAssignment::has('tutors')->has('students');
        $essay_assignments = $essay_assignments->whereRaw($q);

        if (isset($request_data['s_name']))
        {
            $essay_assignments = $essay_assignments->whereHas('students', function($student) use ($request_data) {
                return $student->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
            });
        } else $request_data['s_name'] = "";

        if (isset($request_data['t_name']))
        {
            $essay_assignments = $essay_assignments->whereHas('tutors', function($tutor) use ($request_data) {
                return $tutor->where('fname', 'like', "%" . $request_data['t_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['t_name'] . "%");
            });
        } else $request_data['t_name'] = "";

        if (isset($request_data['a_date_from']) && isset($request_data['a_date_to'])) {
            $essay_assignments = $essay_assignments->whereBetween('date_assigned', 
            [ $request_data['a_date_from'], $request_data['a_date_to'] ]);
        }

        if (!isset($request_data['a_date_from'])) $request_data['a_date_from'] = "";
        if (!isset($request_data['a_date_to'])) $request_data['a_date_to'] = "";
        if (!isset($request_data['c_date_from'])) $request_data['c_date_from'] = "";
        if (!isset($request_data['c_date_to'])) $request_data['c_date_to'] = "";
        
        $essay_assignments = $essay_assignments->get();
        $statuses = EssayStatus::all();
        $data = [
            'essay_assignments' => $essay_assignments,
            'statuses'          => $statuses,
            'old'               => $request_data,
        ];

        if( count($essay_assignments) != 0 )
        {
            return view('admin.essayassignments.index')->with('data', $data);
        }
        
        // request()->session()->flash('error', null);
        if (count($essay_assignments) == 0) {
            request()->session()->flash('error', "No search results!");
        }

        return view('admin.essayassignments.index')->with('data', $data);
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
        $a_num = EssayAssignment::all()->last()['assignment_num'] + 1;
        $essay_statuses = EssayStatus::all();
        $data = [
            'a_num'     => $a_num,
            'tutors'    => $tutors,
            'students'  => $students,
            'statuses'  => $essay_statuses,
        ];
        return view('admin.essayassignments.create')->with('data', $data);
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
            'assignment_num'    => ['required', 'integer', 'unique:essay_assignments'],
            'tutor_id'          => ['required', 'integer'],
            'student_id'        => ['required', 'integer'],
            'topic'             => ['required', 'string'],
            'description'       => ['required', 'string'],
            'file_format'       => ['required', 'string'],
            'price_owed'        => ['required', 'integer'],
            'paid_to_tutor'     => ['required', 'integer'],
            'date_assigned'     => ['required', 'date'],
            'date_completed'    => ['required', 'date'],
            'date_due'          => ['required', 'date'],
            'status_id'         => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
            $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
            $a_num = EssayAssignment::all()->last()['assignment_num'] + 1;
            $essay_statuses = EssayStatus::all();
            $data = [
                'a_num'      => $a_num,
                'tutors'    => $tutors,
                'students'  => $students,
                'statuses'  => $essay_statuses,
            ];
            return view('admin.essayassignments.create')->with('data', $data);
        }

        $data = $request->all();
        $assignment = EssayAssignment::create([
            'assignment_num'        => $data['assignment_num'],
            'tutor_id'              => $data['tutor_id'],
            'student_id'            => $data['student_id'],
            'topic'                 => $data['topic'],
            'description'           => $data['description'],
            'format'                => $data['file_format'],
            'paid'                  => $data['paid_to_tutor'],
            'owed'                  => $data['price_owed'],
            'date_assigned'         => $data['date_assigned'],
            'date_completed'        => $data['date_completed'],
            'date_due'              => $data['date_due'],
            'status_id'             => $data['status_id'],
        ]);

        if ($assignment == NULL)
        {
            $request->session()->flash('error', "There was an error creating the homework assignment");
            $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
            $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
            $a_num = EssayAssignment::all()->last()['assignment_num'] + 1;
            $essay_statuses = EssayStatus::all();
            $data = [
                'a_id'      => $a_num,
                'tutors'    => $tutors,
                'students'  => $students,
                'statuses'  => $essay_statuses,
            ];
            return view('admin.essayassignments.create')->with('data', $data);
        }

        $request->session()->flash('success', "The homework assignment has been created successfully");
        $essay_assignments = EssayAssignment::has('students')->has('tutors')->get();
        $essay_statuses = EssayStatus::all();
        $data = [
            'essay_assignments' => $essay_assignments,
            'statuses'          => $essay_statuses,
            'old'               => [
            'a_id'              => $data['assignment_num'],
            's_name'            => "",
            't_name'            => "",
            'topic'             => $data['topic'],
            'status'            => $data['status_id'],
            'paid_to_tutor'     => $data['paid_to_tutor'],
            'price_owed'        => $data['price_owed'],
            'a_date_from'       => $data['date_assigned'],
            'a_date_to'         => $data['date_assigned'],
            'c_date_from'       => $data['date_completed'],
            'c_date_to'         => $data['date_completed'],
            ],
        ];
        return view('admin.essayassignments.index')->with('data', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EssayAssignment  $essay_Assignment
     * @return \Illuminate\Http\Response
     */
    public function show(EssayAssignment $essay_Assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EssayAssignment  $essay_Assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(EssayAssignment $essay_Assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Essay_Assignment  $essay_Assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EssayAssignment $essayassignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Essay_Assignment  $essay_Assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(EssayAssignment $essayassignment)
    {
        $essay_assignments = EssayAssignment::has('students')->has('tutors')->get();
        $essay_statuses = EssayStatus::all();
        $data = [
            'essay_assignments' => $essay_assignments,
            'statuses'          => $essay_statuses,
            'old'               => [
            'a_id'              => $essayassignment->assignment_num,
            's_name'            => "",
            't_name'            => "",
            'topic'             => $essayassignment->topic,
            'status'            => $essayassignment->status_id,
            'paid_to_tutor'     => $essayassignment->paid,
            'price_owed'        => $essayassignment->owed,
            'a_date_from'       => $essayassignment->date_assigned,
            'a_date_to'         => $essayassignment->date_assigned,
            'c_date_from'       => $essayassignment->date_completed,
            'c_date_to'         => $essayassignment->date_completed,
            ],
        ];

        $essayassignment->delete();
        return view('admin.essayassignments.index')->with('data', $data);

        return redirect()->route('admin.tutorassignments.index')->with('data', $data);
    }
}
