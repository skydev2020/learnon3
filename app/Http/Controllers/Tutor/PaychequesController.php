<?php

namespace App\Http\Controllers\Tutor;

use App\EssayAssignment;
use App\Http\Controllers\Controller;
use App\Paycheque;
use App\User;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaychequesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myuser = Auth::User();
        $paycheques = $myuser->paycheques()->get();
        $data = Array();
        foreach($paycheques as $paycheque)
        {
            $data[date('Y-m', strtotime($paycheque->paycheque_date))] = $paycheque;
        }
        krsort($data);
        return view('tutor.paymentrecords.index') -> with('data', $data);
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
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function show(Paycheque $paymentrecord)
    {
        $log_data = unserialize($paymentrecord->log_data); 

        $data['text_grand_total'] = sprintf("Month Total for %s: $", date("F Y", strtotime($paymentrecord->paycheque_date)));

        $data['paycheque_info'] = Array(
			'session_amount' => round(($paymentrecord->total_amount - $paymentrecord->essay_amount), 2),
			'essay_amount' => $paymentrecord->essay_amount,
			'total_paid' => $paymentrecord->paid_amount
		);
						
		$data['paymentrecord_info'] = Array(
			'session_amount' => round(($paymentrecord->total_amount - $paymentrecord->essay_amount), 2),
			'essay_amount' => $paymentrecord->essay_amount,
			'total_paid' => $paymentrecord->paid_amount
		);
		$sessions_ides = $log_data['all_sessions'];
        $students_raise = $log_data['all_students_data'];
		$essays_ides = $log_data['tutor_essays_details'];
		
		$sessions_raise = Array();
		foreach($students_raise as $each_student) {
			// foreach($each_student as $each_session) {
			// 	$sessions_raise[$each_session['session_id']] = $each_session['raise_amount'];		
			// }
		}
		$sessions_raise_keys = array_keys($sessions_raise);
		
		$sessions = Array();
        if(!empty($sessions_ides))
        {
			$sessions = Session::where(function($session) use ($sessions_ides){
                return $session->whereIn('id', $sessions_ides);
            }) -> get();
        }

		$essays = Array();
		if(!empty($essays_ides)){
            $essays = EssayAssignment::where(function($essay_assignment) use ($essays_ides){
                return $essay_assignment->whereIn('id', $essays_ides);
            }) -> get();
        }
		
		$data['all_sessions'] = Array();
		foreach ($sessions as $each_session) {
			$data['all_sessions'][] = Array(
				'session_id' => $each_session->id,
                'student_name' => $each_session->assignments()->first()->student()['fname'] . ' '
                                    . $each_session->assignments()->first()->student()['lname'],
				'session_duration' => $each_session->session_duration." hours",
				'session_date' => date("d-M-Y", strtotime($each_session->session_date)),
                'session_amount' => (in_array($each_session->id, $sessions_raise_keys)) ? 
                $sessions_raise[$each_session->id] : $each_session->session_duration * 
                ($each_session->method == "Online" ? 35 : 42),
			);			
		}
		
		$data['all_essays'] = Array();
		foreach ($essays as $each_essay) {
			$data['all_essays'][] = array(
				'essay_id' => $each_essay->id,
				'student_name' => $each_essay->assignment_num, //changed 7th May, 2013 as name is supposed to be hidden in tutors login
				'essay_topic' => $each_essay->topic,
				'essay_date' => date("Y-m-d", strtotime($each_essay->date_completed)),
				'essay_amount' => $each_essay->paid,
			);			
        }
        if (empty($data['all_sessions']) && empty($data['all_essays'])) session()->flash('error', 'No search Result!');
        else if (empty($data['all_sessions'])) session()->flash('error', 'No sessions!');
        else if (empty($data['all_essays'])) session()->flash('error', 'No Essays!');

        return view('tutor.paymentrecords.show') -> with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function edit(Paycheque $paycheque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paycheque $paycheque)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paycheque $paycheque)
    {
        //
    }
}
