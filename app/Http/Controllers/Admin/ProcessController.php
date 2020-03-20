<?php

namespace App\Http\Controllers\Admin;
use App\Session;
use App\Assignment;
use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    protected $current_step = "";
    protected $payment_process = Array();

    public function index(Request $request)
    {
        if (isset($this->session->data['current_step']))
            $current_step = $this->session->data['current_step'];
		else
            $current_step = "";
        
            if(isset($this->session->data['payment_process']))
            $payment_process = $this->session->data['payment_process'];
            else
            $payment_process = array();
    
            if(empty($current_step))
            
            $request_data = $this->validate($request, [
                'current_step'      => 'nullable|string',
                's_name'            => 'nullable|string',
                'date_added'        => 'nullable|date',
                'status'            => 'nullable|string'
            ]);
            $this->session->data['process_date'] = $request_data['payment_date'];
            $payment_process = array();

            if(isset($request_data['process'])) {

                if(count($request_data['process']) > 0) {

                    foreach($request_data['process'] as $each_step) {
                        $payment_process[$each_step] = 1;
                    }

                    $payment_process['finished'] = 1;

                    $this->session->data['payment_process'] = $payment_process;
                }

                $payment_process = $this->session->data['payment_process'];
                $current_step = "";
                foreach($payment_process as $current_step => $each_step) {
                    if($each_step) {
                        $this->session->data['current_step'] = $current_step;
                        break;
                    }
                }
            }
    
            switch($current_step) {
                case 'collect_hours':
                    $this->collect_hours();
                    break;
                case 'generate_invoices':
                    $this->generate_invoices();
                    break;
                case 'generate_paycheques':
                    $this->generate_paycheques();
                    break;
                case 'send_invoices':
                    $this->send_invoices();
                    break;
                case 'send_paycheques':
                    $this->send_paycheques();
                    break;
                case 'finished':
                    $this->finished();
                    break;
            }
    
            if(count($payment_process) > 1)
            $this->data['processing'] = 1;
            else
            $this->data['processing'] = 0;
    
            /*
             echo "<pre>";
             print_r($payment_process);
             echo "</pre>";
             */
    
            $this->data['billing_process'] = array_keys($payment_process);

        return view('admin.process.index') -> with('data', $data);
    }

    public function collect_hours() {

		$billing_date = $this->session->data['process_date'];
        $billing_date = substr($billing_date,0,strlen($billing_date)-2);
        
        $session_durations = Session::where(function($session) use ($billing_date){
            return $session->where('date_submission', 'like', "%" . $billing_date . "%")
            -> where('i_locked', 0);
        }) -> get('session_duration') -> pluck('session_duration') -> toArray();

        $total_approved = array_sum($session_durations);
        $total_notapproved = 0;

        #---------------- Setting Template Data ----------------#

        if(isset($this->session->data['process_data']))
            $process_data = $this->session->data['process_data'];
        else
            $process_data = array();

        if(!isset($process_data['collect_hours'])) {
            $process_data['collect_hours'] = array(
            'total_approved' => $total_approved,
            'total_notapproved' => $total_notapproved,
            );
                
            $this->session->data['process_data'] = $process_data;
        }
        #---------------- Setting Template Data ----------------#

        ################# Setting up the next Step #####################
        $payment_process = $this->session->data['payment_process'];
        $payment_process['collect_hours'] = 0;
        $this->session->data['payment_process'] = $payment_process;
            
        foreach($payment_process as $current_step => $each_step) {
            if($each_step) {
                $this->session->data['current_step'] = $current_step;
                break;
            }
        }
        ################# Setting up the next Step #####################
    }
    
    public function generate_invoices()
    {
        $billing_date = $this->session->data['process_date'];
		$billing_date = substr($billing_date,0,strlen($billing_date)-2);

		$filter_data = array (
			'filter_billing_date' => $billing_date,
			'filter_locked' => '0'
			);

        //get information of all the students who have conducted sessions (either package or no package)
        $sessions = Session::where(function ($session) use ($billing_date){
            return $session->where('date_submission', 'like', "%" . $billing_date . "%")
            -> where('i_locked', 0);
        });

        $total_students = $this -> generateStudentsInvoice($billing_date);
        $total_generated = 0;
        $total_updated = 0;
        // Generate invoice for student
        foreach($total_students as $each_student) {
            foreach($each_student->getstudentSessions() as $each_session)
            {
                $bill_info = $this->checkStudentMiniBill($each_student, $each_session);
                if ($bill_info > 0)
            }
        }
        #---------------- Setting Template Data ----------------#


        ################# Setting up the next Step #####################
        $allowed_next = 1;
        if($allowed_next) {
            $payment_process = $this->session->data['payment_process'];
                
            $payment_process['generate_invoices'] = 0;
            $this->session->data['payment_process'] = $payment_process;
                
            foreach($payment_process as $current_step => $each_step) {
                if($each_step) {
                    $this->session->data['current_step'] = $current_step;
                    break;
                }
            }
        }
        ################# Setting up the next Step #####################
    }

    public function generateStudentsInvoice($billing_date)
    {
        $sessions = Session::where(function ($session) use ($billing_date) {
            return $session->where('date_submission', 'like', "%" . $billing_date . "%")
            -> where('i_locked', 0);
        })->get();
        
        $assignmentIds = Assignment::whereHas('sessions', function($session) use ($billing_date){
            return $session->where('date_submission', 'like', "%" . $billing_date . "%")
            -> where('i_locked', 0);
        }) -> get('id') -> pluck('id') -> toArray();

        $students = User::whereHas('assignments', function($assignment) use ($assignmentIds) {
            return $assignment -> whereIn('id', $assignmentIds);
        }) -> get();

        return $students;
    }

    public function getstudentSessions($student_id, $billing_date)
    {
        $sessions = Session::where(function ($session) use ($billing_date) {
            return $session->where('date_submission', 'like', "%" . $billing_date . "%")
            -> where('i_locked', 0) -> has('assignments');
        })->get();

        $student = User::where('id', $student_id) -> first();
        $assignmentIds = $student -> assignments() -> get('id') -> pluck('id') -> toArray();
        $sessions = Session::whereIn('id', $assignmentIds);
    }

    public function checkStudentMiniBill($student, $session)
    {
        if ($student->grade_id <= 7 && $session['session_duration'] < 1.00) return 1.00;
        elseif ($student->grade_id > 7 && $session['session_duration'] < 1.50) return 1.00;

        return 0;
    }
}
