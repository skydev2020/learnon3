<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Assignment;
use App\Broadcast;
use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Rate;
use App\Role;
use App\Subject;
use Config;
use App\User;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TutorAssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            's_name' => 'nullable|string',
            't_name' => 'nullable|string',
            'a_date' => 'nullable|date',
        ]);

        $q = "1=1 ";

        if (isset($request_data['a_date'])) {
            $q.= " and created_at like '%".$request_data['a_date']."%'";
        }
        else $request_data['a_date'] = "";

        $assignments = Assignment::query()->whereRaw($q);

        if (isset($request_data['s_name']))
        {
            $assignments = $assignments->whereHas('students', function($student) use ($request_data) {
                return $student->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
            });
        }
        else $request_data['s_name'] = "";

        if (isset($request_data['t_name']))
        {
            $assignments = $assignments->whereHas('tutors', function($tutor) use ($request_data) {
                return $tutor->where('fname', 'like', "%" . $request_data['t_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['t_name'] . "%");
            });
        }
        else $request_data['t_name'] = "";

        $assignments = $assignments->get();
        $data = [
            'assignments'   => $assignments,
            'old'           => [
                't_name'    => $request_data['t_name'],
                's_name'    => $request_data['s_name'],
                'a_date'    => $request_data['a_date'],
            ]
        ];
        //dd($datas['old']['t_name']);

        if( count($assignments) != 0 )
        {
            return view('admin.tutorassignments.index')->with('data', $data);
        }
        
        request()->session()->flash('error', null);
        if (count($assignments) == 0) {
            request()->session()->flash('error', "No search results!");
        }

//     $assignmentIDs = Assignment::where('name', 'like' "%" . $name . "%")->get(['id'])->pluck('id')->toArray();
//      $assignments = Assignment::whereNotIn('id', $assignmentIDs)->get();

        return view('admin.tutorassignments.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('manage-tutors')) {
            return redirect(route('admin.tutorassignments.index'));
        }

        $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        $rates = Rate::all();
        $subjects = Subject::all();
        $data = [
            'tutors'        => $tutors,
            'students'      => $students,
            'subjects'      => $subjects,
            'rates'         => $rates,
        ];
        return view('admin.tutorassignments.create')->with('data', $data);
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
            'tutor_val'     => ['required', 'integer'],
            'student_val'   => ['required', 'integer'],
            'tpay_value'    => ['required', 'string'],
            'spay_value'    => ['required', 'string'],
            'subjects'      => ['required', 'Array'],
            'status'        => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.tutorassignments.create');
        }

        $data = $request->all();
        $assignment = Assignment::create([
            'tutor_id'      => $data['tutor_val'],
            'student_id'    => $data['student_val'],
            'base_wage'     => $data['tpay_value'],
            'base_invoice'  => $data['spay_value'],
            'active'        => $data['status'],
        ]);

        if ($assignment == NULL)
        {
            session()->flash('error', "There is an error creating the assignment!");
            return redirect()->route('admin.tutorassignments.create');
        }

        foreach($data['subjects'] as $subject)
        {
            $assignment->subjects()->attach($subject);
        }
        $assignment->save();
        Notification::addInformation(Auth::User()->id, $data['student_val'], "Tutor assigned"
            , "You have been assigned a tutor for tutoring.");

        Notification::addInformation(Auth::User()->id, $data['tutor_val'], "Student assigned"
            , "You have been assigned a student for tutoring.");   
            
        ActivityLog::log_activity(Auth::User()->id, "Tutor Assigned", "A tutor is assigned to a student.");

        $tutor_mail = Broadcast::where('id', 4)->first();
        $subject = $tutor_mail->subject;
        $message = $tutor_mail->content;
        
        // Here you can define keys for replace before sending mail to Student
        $tutor = User::where('id', $data['tutor_val'])->first();
        $replace_info = Array(
                        'TUTOR_NAME' => $tutor->fname .' ' . $tutor->lname, 
                    );
        
        foreach($replace_info as $rep_key => $rep_text) {
            $message = str_replace('@'.$rep_key.'@', $rep_text, $message);
        }

        Mail::to($tutor->email)->send(new SendMail([
            'subject'   => $subject,
            'message'   => $message
        ]));
        session()->flash('success', "The assignment has been created successfully");
        return redirect()->route('admin.tutorassignments.index');
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
    public function edit(Assignment $tutorassignment)
    {
        if (Gate::denies('manage-tutors')) {
            return redirect(route('admin.tutorassignments.index'));
        }

        $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        $rates = Rate::all();
        $subjects = Subject::all();
        $data = [
            'assignment'    => $tutorassignment,
            'tutors'        => $tutors,
            'students'      => $students,
            'subjects'      => $subjects,
            'rates'         => $rates,
        ];
        return view('admin.tutorassignments.edit')->with(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $tutorassignment)
    {
        $tutorassignment->tutor_id = $request->tutor_val;
        $tutorassignment->student_id =$request->student_val;
        $tutorassignment->subjects = $request->subject_value;
        $tutorassignment->base_wage = $request->tpay_value;
        $tutorassignment->base_invoice = $request->spay_value;
        $tutorassignment->final_status = $request->status;

        if ($tutorassignment->save()){
            $request->session()->flash('success', 'The assignment has been updated successfully');
        } else {
            $request->session()->flash('error', 'There was an error updating the assignment');
        }

        $assignments = Assignment::all();
        $data = [
            'assignments'   => $assignments
        ];
        return redirect()->route('admin.tutorassignments.index')->with('data', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $tutorassignment)
    {


        if (Gate::denies('delete-users')) {
            $assignments = Assignment::all();
            $data = [
                'assignments' => $assignments,
            ];
            return redirect(route('admin.tutorassignments.index'))->with('data', $data);
        }

        $tutorassignment->delete();
        $assignments = Assignment::all();
        $data = [
            'assignments' => $assignments,
        ];

        return redirect()->route('admin.tutorassignments.index')->with('data', $data);
    }
}
