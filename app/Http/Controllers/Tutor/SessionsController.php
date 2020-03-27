<?php

namespace App\Http\Controllers\Tutor;

use App\Assignment;
use App\Http\Controllers\Controller;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class SessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            's_name'            => 'nullable | string',
            'session_date'      => 'nullable | date',
            'session_duration'  => 'nullable | string',
            'session_notes'     => 'nullable | string'
        ]);
        if ($validator -> fails())
        {
            session()->flash('error', $validator->messages()->first());
            return back();
        }
        $request_data = $request->all();

        $myuser = Auth::User();
        
        $sessions = Session::whereHas('assignments', function($assignment) use ($myuser){
            return $assignment->whereHas('tutors', function($user) use ($myuser){
                return $user->where('id', $myuser->id);
            });
        });

        $q = "1=1 ";
        if (isset($request_data['session_date'])) {
            $q .= " and session_date like '%" . $request_data['session_date'] . "%'";
        } else $request_data['session_date'] = "";

        if (isset($request_data['session_duration'])) {
            $q .= " and session_duration like '%" . $request_data['session_duration'] . "%'";
        } else $request_data['session_duration'] = "";

        if (isset($request_data['session_notes'])) {
            $q .= " and session_notes like '%" . $request_data['session_notes'] . "%'";
        } else $request_data['session_notes'] = "";
        $sessions = $sessions->whereRaw($q);

        if (isset($request_data['s_name'])) {
            $sessions = $sessions->whereHas('assignments', function($assignment) use ($request_data){
                return $assignment->whereHas('students', function($student) use ($request_data){
                    return $student->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                    ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
                });
            });
        } else $request_data['s_name'] = "";
        $sessions = $sessions->get();

        $data = [
            'sessions'  => $sessions,
            'old'       => $request_data,
            'durations' => Session::getAllDurations()
        ];
        return view('tutor.sessions.index') -> with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $myuser = Auth::User();
        $students = Array();
        foreach($myuser->tutor_assignments()->get() as $assignments)
        {
            $students[] = $assignments->student();
        }

        $students = array_unique($students);

        $data = [
            'students'  => $students,
            'durations' => Session::getAllDurations()
        ];
        return view('tutor.sessions.create') -> with('data', $data);
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
            'student'           => ['required', 'integer'],
            'session_date'      => ['required', 'date'],
            'session_duration'  => ['required', 'string'],
            'session_notes'     => ['required', 'string'],
            'method'            => ['required', 'string']
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('tutor.sessions.create');
        }

        $tutor_id = Auth::user()->id;
        $assignment_id = Assignment::where(function($assignment) use ($tutor_id, $request){
            return $assignment->where('tutor_id', $tutor_id)
            -> where('student_id', $request['student']);
        })->first()['id'];

        $data = $request->all();
        $session = Session::create([
            'assignment_id'     => $assignment_id,
            'session_date'      => $data['session_date'],
            'session_duration'  => $data['session_duration'],
            'session_notes'     => $data['session_notes'],
            'method'            => $data['method']
        ]);

        if ($session == NULL)
        {
            $request->session()->flash('error', "There is an error logging your session!");
            return redirect()->route('tutor.sessions.create');
        }

        $request->session()->flash('success', "Your session logged successfully");
        return redirect()->route('tutor.sessions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $session)
    {
        $myuser = Auth::User();
        $students = Array();
        foreach($myuser->tutor_assignments()->get() as $assignments)
        {
            $students[] = $assignments->student();
        }

        $students = array_unique($students);

        $data = [
            'session'   => $session,
            'students'  => $students,
            'durations' => Session::getAllDurations()
        ];
        return view('tutor.sessions.edit') -> with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Session $session)
    {
        $validator = Validator::make($request->all(), [
            'student'           => ['required', 'integer'],
            'session_date'      => ['required', 'date'],
            'session_duration'  => ['required', 'string'],
            'session_notes'     => ['required', 'string']
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('tutor.sessions.edit', $session);
        }

        $tutor_id = Auth::user()->id;
        $assignment_id = Assignment::where(function($assignment) use ($tutor_id, $request){
            return $assignment->where('tutor_id', $tutor_id)
            -> where('student_id', $request['student']);
        })->first()['id'];

        $data = $request->all();
        $session->assignment_id     = $assignment_id;
        $session->session_date      = $data['session_date'];
        $session->session_duration  = $data['session_duration'];
        $session->session_notes     = $data['session_notes'];

        if (!$session->save())
        {
            $request->session()->flash('error', "There is an error logging your session!");
            return redirect()->route('tutor.sessions.edit', $session);
        }

        $request->session()->flash('success', "Your session logged successfully");
        return redirect()->route('tutor.sessions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        if (Gate::denies('manage-sessions')){
            return redirect() -> route('tutor.sessions.index');
        }

        $session->delete();
        return redirect() -> route('tutor.sessions.index');
    }
}
