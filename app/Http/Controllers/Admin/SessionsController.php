<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Session;
use App\Assignment;
use Illuminate\Http\Request;
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
        $request_data = $this->validate($request, [
            't_name'            => 'nullable|string',
            's_name'            => 'nullable|string',
            'session_duration'  => 'nullable|string',
            'date_submission'   => 'nullable|date',
            'session_date'      => 'nullable|date',
        ]);

        $sessions = Session::has('assignments');

        if (isset($request_data['date_submission'])) {
            $sessions = $sessions->where('date_submission', $request_data['date_submission']);
        } else $request_data['date_submission'] = "";

        if (isset($request_data['session_date'])) {
            $sessions = $sessions->where('session_date', $request_data['session_date']);
        } else $request_data['session_date'] = "";

        if (isset($request_data['s_name'])) {
            $sessions = $sessions->whereHas('assignments', function($assignment) use ($request_data) {
                return $assignment->whereHas('students', function($student) use ($request_data) {
                    return $student->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                                    ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
                    });
                });
        } else $request_data['s_name'] = "";

        if (isset($request_data['t_name'])) {
            $sessions = $sessions->whereHas('assignments', function($assignment) use ($request_data) {
                return $assignment->whereHas('tutors', function($tutor) use ($request_data) {
                    return $tutor->where('fname', 'like', "%" . $request_data['t_name'] . "%")
                                    ->orwhere('lname', 'like', "%" . $request_data['t_name'] . "%");
                    });
                });
        } else $request_data['t_name'] = "";

        if (isset($request_data['session_duration'])) {
            $durations = $this->getAllDurations();
            $session_duration = array_search($request_data['session_duration'], $durations);
            $sessions = $sessions->where('session_duration', 'like', $session_duration);
        } else $request_data['session_duration'] = "";

        $sessions = $sessions->get();
        $session_durations = $this->getAllDurations();

        $data = [
            'sessions'          => $sessions,
            'session_durations' => $session_durations,
            'old'               => $request_data,
        ];

        if( count($sessions) != 0 ) return view('admin.sessions.index')->with('data', $data);
        
        request()->session()->flash('error', "No search results!");
        return view('admin.sessions.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assignments = Assignment::all();
        $durations = $this->getAllDurations();
        $data = [
            'assignments'       => $assignments,
            'session_durations' => $durations,
        ];
        return view('admin.sessions.create')->with('data', $data);
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
            'assignment_id'     => ['required', 'integer'],
            'session_date'      => ['required', 'date'],
            'session_duration'  => ['required', 'string'],
            'notes'             => ['required', 'string']
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.sessions.create');
        }

        $data = $request->all();
        $durations = $this->getAllDurations();
        $session_duration = array_search($data['session_duration'], $durations);

        $session = Session::create([
            'assignment_id'         => $data['assignment_id'],
            'session_date'          => $data['session_date'],
            'session_duration'      => number_format($session_duration, 2),
            'session_notes'         => $data['notes']
        ]);

        if ($session == NULL)
        {
            $request->session()->flash('error', "There was an error logging hours");
            return redirect()->route('admin.sessions.create');
        }

        $request->session()->flash('success', "The hours has been logged successfully");
        return redirect()->route('admin.sessions.index');
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
        $assignments = Assignment::all();
        $data = [
            'session'       => $session,
            'assignments'   => $assignments
        ];
        return view('admin.sessions.edit')->with('data', $data);
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
        $session->assignment_id = $request->assignment_id;
        $session->session_date = $request->session_date;
        $session->session_duration = $request->session_duration;
        $session->session_notes = $request->notes;

        if ($session->save()){
            $request->session()->flash('success', 'The session has been updated successfully');
        } else {
            $request->session()->flash('error', 'There was an error updating the session');
        }
        return redirect()->route('admin.sessions.index');
    }

    public function lock(Request $request, Session $session)
    {
        $session->is_locked = 1;
        $session->i_locked = 1;
        $session->p_locked = 1;

        if ($session->save()){
            $request->session()->flash('success', 'The session has been updated successfully');
        } else {
            $request->session()->flash('error', 'There was an error updating the session');
        }

        $sessions = Session::all();
        $data = [
            'sessions'      => $sessions,
        ];
        return redirect()->route('admin.sessions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        $session->delete();
        return redirect()->route('admin.sessions.index');
    }

    public function getAllDurations(){
		$duration_array = array(
            "0.50"=>"30 Minutes",
            "0.75"=>"45 Minutes", 
            "1.00"=>"1 Hour", 
            "1.25"=>"1 Hour + 15 Minutes", 
            "1.50"=>"1 Hour + 30 Minutes", 
            "1.75"=>"1 Hour + 45 Minutes", 
            "2.00"=>"2 Hours", 
            "2.25"=>"2 Hours + 15 Minutes", 
            "2.50"=>"2 Hours + 30 Minutes", 
            "2.75"=>"2 Hours + 45 Minutes", 
            "3.00"=>"3 Hours", 
            "3.25"=>"3 Hours + 15 Minutes", 
            "3.50"=>"3 Hours + 30 Minutes", 
            "3.75"=>"3 Hours + 45 Minutes", 
            "4.00"=>"4 Hours", 
            "4.25"=>"4 Hours + 15 Minutes", 
            "4.50"=>"4 Hours + 30 Minutes", 
            "4.75"=>"4 Hours + 45 Minutes", 
            "5.00"=>"5 Hours");
		return $duration_array;
	}
}
