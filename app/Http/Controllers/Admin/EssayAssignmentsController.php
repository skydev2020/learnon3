<?php
namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\EssayAssignment;
use App\Http\Controllers\Controller;

use App\Role;
use App\EssayStatus;
use App\Imports\ImportEssay;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

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

        $essay_assignments = EssayAssignment::whereRaw($q);

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
            'tutor_id'          => ['nullable', 'integer'],
            'student_id'        => ['nullable', 'integer'],
            'topic'             => ['required', 'string'],
            'description'       => ['required', 'string'],
            'file_format'       => ['nullable', 'string'],
            'price_owed'        => ['nullable', 'integer'],
            'paid_to_tutor'     => ['nullable', 'integer'],
            'date_assigned'     => ['nullable', 'date'],
            'date_completed'    => ['nullable', 'date'],
            'date_due'          => ['nullable', 'date'],
            'status_id'         => ['nullable', 'integer'],
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
        return view('admin.essayassignments.upload');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EssayAssignment  $essay_Assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(EssayAssignment $essayassignment)
    {
        $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        $essay_statuses = EssayStatus::all();
        $data = [
            'tutors'            => $tutors,
            'students'          => $students,
            'statuses'          => $essay_statuses,
            'essayassignment'   => $essayassignment
        ];
        return view('admin.essayassignments.edit')->with('data', $data);
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
        $validator = Validator::make($request->all(), [
            'assignment_num'    => ['required', 'integer'],
            'tutor_id'          => ['nullable', 'int'],
            'student_id'        => ['nullable', 'int'],
            'topic'             => ['required', 'string'],
            'description'       => ['required', 'string'],
            'file_format'       => ['nullable', 'string'],
            'paid_to_tutor'     => ['nullable', 'string'],
            'price_owed'        => ['nullable', 'string'],
            'date_assigned'     => ['nullable', 'date'],
            'date_completed'    => ['nullable', 'date'],
            'date_due'          => ['nullable', 'date'],
            'status_id'         => ['nullable', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.essayassignments.edit', $essayassignment);
        }

        $data = $request->all();
        $essayassignment->assignment_num = $data['assignment_num'];
        $essayassignment->tutor_id = $data['tutor_id'];
        $essayassignment->student_id = $data['student_id'];
        $essayassignment->topic = $data['topic'];
        $essayassignment->description = $data['description'];
        $essayassignment->format = $data['file_format'];
        $essayassignment->paid = $data['paid_to_tutor'];
        $essayassignment->owed = $data['price_owed'];
        $essayassignment->date_assigned = $data['date_assigned'];
        $essayassignment->date_completed = $data['date_completed'];
        $essayassignment->date_due = $data['date_due'];
        $essayassignment->status_id = $data['status_id'];

        if($essayassignment->save()){
            $request->session()->flash('success', 'The Homework Assignmnet has been updated successfully');
            return redirect()->route('admin.essayassignments.index');
        }

        $request->session()->flash('error', 'There was an error updating the homework assignment');
        return redirect()->route('admin.essayassignments.edit');
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
        return redirect()->route('admin.essayassignments.index')->with('data', $data);
    }

    public function upload_csv(Request $request)
    {
        // dd($request->file('file1')->getMimeType());
        $validator = Validator::make([
            'file1'     => isset($request->file1) ? $request->file('file1')->getClientOriginalExtension() : NULL,
            'file2'     => isset($request->file2) ? $request->file('file2')->getClientOriginalExtension() : NULL,
            'file3'     => isset($request->file3) ? $request->file('file3')->getClientOriginalExtension() : NULL,
        ], [
            'file1'     => ['nullable', 'in:csv'],
            'file2'     => ['nullable', 'in:csv'],
            'file3'     => ['nullable', 'in:csv'],
        ]);

        if ($validator->fails())
        {
            session() -> flash('error', $validator->messages()->first());
            return redirect()->route('admin.essayassignments.upload');
        }
        if (!isset($request->file1) && !isset($request->file2) && !isset($request->file3))
        {
            session() -> flash('error', "Please select file");
            return redirect()->route('admin.essayassignments.upload');
        }

        if (isset($request->file1))
        {
            $essay = Excel::import(new ImportEssay, $request->file('file1'));
            ActivityLog::log_activity(Auth::User()->id, "Essay Upload CSV", "Essay uploaded");
        }
        if (isset($request->file2))
        {
            Excel::import(new ImportEssay, request()->file('file2'));
            ActivityLog::log_activity(Auth::User()->id, "Essay Upload CSV", "Essay uploaded");
        }
        if (isset($request->file3))
        {
            Excel::import(new ImportEssay, request()->file('file3'));
            ActivityLog::log_activity(Auth::User()->id, "Essay Upload CSV", "Essay uploaded");
        }
        session() -> flash('success', "CSV File Uploaded successfully");
        return redirect() -> route('admin.essayassignments.index');
    }
}
