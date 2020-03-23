<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $sessions = Session::whereHas('assignments', function($assignment) use ($request_data){
                return $assignment->whereHas('sessions', function($tutor) use ($request_data){
                    return $tutor->where('fname', $request_data['s_name'])
                    ->orwhere('lname', $request_data['s_name']);
                });
            });
        } else $request_data['s_name'] = "";
        $sessions = $sessions->get();

        $data = [
            'sessions'  => $sessions,
            'old'       => $request_data
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }
}
