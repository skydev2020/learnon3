<?php

namespace App\Http\Controllers\Admin;
use App\Session;
use App\Assignment;
use App\User;
use App\Order;
use App\Package;
use App\Invoice;
use App\Information;
use App\UrlAlias;
use App\Setting;
use App\OrderHistory;
use App\Mail\SendMail;
use App\Notification; 
use App\EssayAssignment;
use App\Paycheque;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProcessController extends Controller
{
    public function index(Request $request)
    {
        if (session()->has('current_step')) $current_step = session('current_step');
		else $current_step = "";

        if(session()->has('payment_process')) $payment_process = session('payment_process');
        else $payment_process = Array();

        if(empty($current_step))
        if ($this->validateForm($request))
        {
            
            session(['process_date'=> $request['payment_date']]);
            $payment_process = Array();
            if(isset($request['process'])) {                
                if(count($request['process']) > 0) {

                    foreach($request['process'] as $each_step) {
                        $payment_process[$each_step] = 1;
                    }

                    $payment_process['finished'] = 1;

                    session(['payment_process' => $payment_process]);
                }
                $payment_process = session('payment_process');
                $current_step = "";
                foreach($payment_process as $current_step => $each_step) {
                    if($each_step) {
                        session(['current_step' => $current_step]);
                        break;
                    }
                }
            }
        }
        //dd($current_step);
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

        $this->data['billing_process'] = array_keys($payment_process);

        if(session()->has('current_step')) $current_step = session('current_step');
		else $current_step = "";

        if(session()->has('process_data')) $process_data = session('process_data');
        else $process_data = Array();
        if(isset($process_data['collect_hours'])) {
			$this->data['collect_hours'] = 1;
			$this->data['total_approved_hours'] = $process_data['collect_hours']['total_approved'];
			$this->data['total_notapproved_hours'] = $process_data['collect_hours']['total_notapproved'];
		} else {
			$this->data['collect_hours'] = 0;
		}

		if(isset($process_data['generate_invoices'])) {
			$this->data['generate_invoices'] = 1;
			$this->data['total_invoice_generated'] = $process_data['generate_invoices']['total_generated'];
			$this->data['total_invoice_updated'] = $process_data['generate_invoices']['total_updated'];
		} else {
			$this->data['generate_invoices'] = 0;
        }

		if(isset($process_data['send_invoices'])) {
			$this->data['send_invoices'] = 1;
			$this->data['total_invoice_lock'] = $process_data['send_invoices']['total_invoice_lock'];
			$this->data['total_invoice_sent'] = $process_data['send_invoices']['total_invoice_sent'];
		} else {
			$this->data['send_invoices'] = 0;
		}

		if(isset($process_data['generate_paycheques'])) {
			$this->data['generate_paycheques'] = 1;
			$this->data['total_paycheques_generated'] = $process_data['generate_paycheques']['paycheques_generated'];
			$this->data['total_paycheques_updated'] = $process_data['generate_paycheques']['paycheques_updated'];
		} else {
			$this->data['generate_paycheques'] = 0;
		}

		if(isset($process_data['send_paycheques'])) {
			$this->data['send_paycheques'] = 1;
			$this->data['total_paycheques_lock'] = $process_data['send_paycheques']['total_paycheques_lock'];
			$this->data['total_paycheques_sent'] = $process_data['send_paycheques']['total_paycheques_sent'];
		} else {
			$this->data['send_paycheques'] = 0;
		}

        #---------------- Template Process Data ----------------#
        if(isset($request['payment_date']) && !session()->has('success')) {
			$process_date = $request['payment_date'];
		} else if(session()->has('process_date')) {
            $process_date = session('process_date');
        } else $process_date = "";
        //dd($process_date);
		if($current_step == "finished") {
			$this->data['button_save'] = "Finish";
		} else if(!empty($current_step)) {
			$this->data['button_save'] = "Continue";
		} else if(!empty($process_date)) {
			$this->data['button_save'] = "Start";
		} else {
			$this->data['button_save'] = "Select Month";
        }
        
        if (isset($request['payment_date'])) {
            $this->data['payment_date'] = $request['payment_date'];
        } else if (session()->has('process_date')) {
            $this->data['payment_date'] = session('process_date');
        } else {
            $this->data['payment_date'] = 0;
        }

		if (session()->has('success')) {
			$this->data['success'] = session('success');
            session()->forget('success');
            $this->data['payment_date'] = 0;
		} else {
			$this->data['success'] = '';
        }

        if (isset($request['process'])) {
            $payment_process = Array();

            foreach($request['process'] as $each_step) {
                $payment_process[$each_step] = 1;
            }

            $this->data['process'] = $payment_process;
        } else if (session()->has('payment_process')) {
            $this->data['process'] = session('payment_process');
        } else {
            $this->data['process'] = array();
        }
        $all_dates = array();
        foreach(array(0,1,2,3,4) as $each_key) {
            $timestamp = strtotime('now -'.$each_key.'month');

            $all_dates[] = array(
                            'value' => date('Y-m-d', $timestamp),
                            'text' => date('M-Y', $timestamp)
            );
        }

        $this->data['all_dates'] = $all_dates;
        //dd($this->data);
        return view('admin.process.index')->with('data', $this->data);
    }

    public function validateForm(Request $request) {
        if (empty($request['payment_date'])) return false;
        if (session()->has('process_date') && !isset($request['process'])) return false;
        return true;
    }

    public function collect_hours() {

		$billing_date = session('process_date');
        $billing_date = substr($billing_date,0,strlen($billing_date)-2);
        
        $session_durations = Session::where(function($session) use ($billing_date){
            return $session->where('date_submission', 'like', "%" . $billing_date . "%")
            -> where('i_locked', 0);
        }) -> get('session_duration') -> pluck('session_duration') -> toArray();

        $total_approved = array_sum($session_durations);
        $total_notapproved = 0;

        #---------------- Setting Template Data ----------------#

        if(session()->has('process_data'))
            $process_data = session('process_data');
        else
            $process_data = array();

        if(!isset($process_data['collect_hours'])) {
            $process_data['collect_hours'] = array(
            'total_approved' => $total_approved,
            'total_notapproved' => $total_notapproved,
            );
                
            session(['process_data' => $process_data]);
        }
        #---------------- Setting Template Data ----------------#

        ################# Setting up the next Step #####################
        $payment_process = session('payment_process');
        $payment_process['collect_hours'] = 0;
        session(['payment_process' => $payment_process]);
        
        
        foreach($payment_process as $current_step => $each_step) {
            if($each_step) {
                session(['current_step'=> $current_step]);
                break;
            }
        }
        ################# Setting up the next Step #####################
    }
    
    public function generate_invoices()
    {
        $billing_date = session('process_date');
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
        $result = Array();
        foreach($total_students as $each_student) {
            
            $total_session_hours = 0;
            $result = Array();
            $log_data = Array();
            $student_sessions = $this->getstudentSessions($each_student->id, $billing_date);
            $result['num_of_sessions'] = count($student_sessions);
            foreach($student_sessions as $each_session)
            {
                $bill_info = $this->checkStudentMiniBill($each_student, $each_session->session_duration);
                if ($bill_info > 0) $total_session_hours += $bill_info;
                else $total_session_hours += $each_session->session_duration;
            }
            $result['total_hours'] = $result['total_session_hours'] = $total_session_hours;
            $log_data['student_sessions'] = $student_sessions;

            // default status for geneated invoice
            $result['invoice_status'] = 'Hold For Approval';
            $result['invoice_date'] = session('process_date');

            $student_total = $student_package = $update_student_packages = Array();
					
            //Get Package details of this student. Only packages with payment status as 5 are considered.
            $student_packages = $this->getStudentPackages($each_student);
            $bill_info = $this->checkStudentMiniBill($each_student, $result['total_hours']);
            $result['hour_charged'] = $result['total_hours'];
            $result['total_amount'] = 
            round(($result['total_hours'] * $this->getStudentRate($each_student)), 2);

            $left_total_hours = $result['total_hours'];
            foreach ($student_packages as $each_package)
            {
                if ($left_total_hours > 0)
                {
                    $left_total_hours = $result['total_hours'] - $each_package['left_hours'];

                    if ($left_total_hours >= 0)
                    {
                        $update_student_packages[]['dedcut_hours'] = $student_package['left_hours'];
                    }
                    else {
                        $update_student_packages[]['dedcut_hours'] = $student_package['left_hours']+$left_total_hours;
                    }
                    $update_student_packages[]['package'] = $each_package;
                }
            }

            $result['update_student_packages'] = $update_student_packages;
            $log_data['student_packages'] = $update_student_packages;

            if ($left_total_hours != $result['total_hours'])
            {
                if ($left_total_hours < 0) $left_total_hours = 0;

                $student_total['total_hours'] = $result['total_hours'];
                $student_total['total_amount'] = $result['total_amount'];
                $student_total['student_rate'] = $this->getStudentRate($each_student);
                $student_total['left_total_hours'] = $left_total_hours;

                $result['total_amount'] = round(($left_total_hours * $student_total['student_rate']),2);
            }

            $result['student_total'] = $student_total;
            $log_data['student_total'] = $student_total;

            $check_invoice = Invoice::where(function($invoice) use ($each_student, $billing_date){
                return $invoice->where('user_id', $each_student -> id)
                -> where('invoice_date', 'like', "%" . $billing_date . "%");
            })->first();

            $log_data = serialize($log_data);

            /* Softronikx Technologies - Code to send different invoice and package update */
            //15 for package email and 12 for invoice email format from db
            if (count($check_invoice) != NULL) {
                $invoice_mailmsg = $this->getInformation(15);
            } else {
                $invoice_mailmsg = $this->getInformation(12);
            }

            $invoice_mailmsg = $invoice_mailmsg['information']['description'];

            if (count($check_invoice) > 0)
            {
                if (!$check_invoice['is_locked'])
                {
                    $invoice_data = Array();
                    // Update Invoice Mail Format
				 	$invoice_data['update_student_packages'] = $result['update_student_packages'];
				 	$invoice_data['student_total'] = $result['student_total'];
                    $invoice_data['student_name'] = $each_student['name'];
                    
                    if (isset($result['hour_charged']))
                        $invoice_data['hour_charged'] = $result['hour_charged'];
                        $invoice_data['total_hours'] = $result['total_hours'];
                        $invoice_data['studet_sessions'] = $this->student_sessions();
                        $result['invoice_format'] = $this->invoices_format($invoice_mailmsg, 
                        $check_invoice, $invoice_data);
                        $result['log_data'] = $log_data;

                        $this->editStudentInvoice($check_invoice->id, $result);
                        $total_updated += 1;
                }
            } else {
                $next_invoice = $this->generateStudentInvoiceNumber();
                $result['invoice_num'] = $next_invoice;
                $result['invoice_prefix'] = Setting::where('key', 'config_invoice_prefix')->first()['value'];

                // Add Invoice Mail Format
                $result['student_name'] = $each_student['name'];
                $result['invoice_notes'] = "";

                $result['student_sessions'] = $student_sessions;
                $result['duration_array'] = $this->getAllDurations();

                $result['invoice_format'] = $this->invoices_format_new($invoice_mailmsg, $each_student
                 , $result);
                $result['log_data'] = $log_data;

                $this->addStudentInvoice($result);
                $total_generated += 1;
            }
        }
        #---------------- Setting Template Data ----------------#
        $process_data = session('process_data');
       
        if(!isset($process_data['generate_invoices'])) {
            $process_data['generate_invoices'] = array(
            'total_generated' => $total_generated,
            'total_updated' => $total_updated,
            );
                
            session(['process_data' => $process_data]);
        }
        
        //dd($process_data);
        #---------------- Setting Template Data ----------------#

        ################# Setting up the next Step #####################
        $allowed_next = 1;
        if($allowed_next) {
            $payment_process = session('payment_process');
                
            $payment_process['generate_invoices'] = 0;
            session(['payment_process'=> $payment_process]);
                
            foreach($payment_process as $current_step => $each_step) {
                if($each_step) {
                    session(['current_step' => $current_step]);
                    break;
                }
            }
        }
        ################# Setting up the next Step #####################
    }

    public function invoices_format($message, $invoice, $invoice_data)
    {
        $duration_array = $this->getAllDurations();
        if (count($invoice_data['student_sessions']) > 0)
        {
            $session_details = '<table width="50%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left"><strong>DATE</strong></td>
              <td align="right"><strong>DURATION</strong></td>
            </tr>';
            foreach($invoice_data['student_sessions'] as $each_session) {
                $bill_info = $this->checkStudentMiniBill($invoice->users()->first()
                ,$each_session['session_duration']);
				if($bill_info > 0) {
					$min_charged_hours = $bill_info;
				}
				else
				{
					$min_charged_hours = $each_session['session_duration'];
				}
				$sessions_details .= '
				  <tr>
				    <td align="left">'.date("d M Y", strtotime($each_session['session_date'])).'</td>
				    <td align="right">'.$duration_array[$min_charged_hours].'</td>
				  </tr>';
			}

			$sessions_details .= '</table>';
        }

        $package_details = "";
        if(count($invoice_data['update_student_packages']) > 0) {
			$package_details = '<table width="80%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			    <td align="left"><strong>Package Name </strong></td>
			    <td align="center"><strong>Total Hours </strong></td>
			    <td align="center"><strong>Deducted Hours </strong></td>
			  </tr>';
			foreach($invoice_data['update_student_packages'] as $each_package) {
				$package_details .= '
				  <tr>
				    <td align="left">'.$each_package['package_name'].'</td>
				    <td align="center">'.$each_package['left_hours'].'</td>
				    <td align="center">'.$each_package['deduct_hours'].'</td>
				  </tr>';				
			}

			$package_details .= '</table>';
		}

		// Here you can define keys for replace before sending mail to Student
		$replace_info = array(
            'STUDENT_NAME' => $invoice_data['student_name'], 
            'INVOICE_NUMBER' => $invoice['invoice_num'], //$invoice_data['invoice_prefix'].'-'.$invoice_data['invoice_num'] 
            'NUM_OF_SESSIONS' => $invoice['num_of_sessions'], 
            'PACKAGES_DETAILS' => $package_details, 
            'SESSIONS_DETAILS' => $sessions_details, 
            'TOTAL_HOURS' => $this->format_hours($invoice_data['total_hours']), 
            'TOTAL_AMOUNT' => '$'.$invoice['total_amount'], 
            'INVOICE_DATE' => date("M Y", strtotime($invoice['invoice_date'])), 
            'INVOICE_NOTE' => $invoice['invoice_notes'], 
        );

        foreach($replace_info as $rep_key => $rep_text) {
        $message = str_replace('@'.$rep_key.'@', $rep_text, $message);
        }

        return $message;
    }

    public function invoices_format_new($message, $student, $invoice_data)
    {
        $duration_array = $this->getAllDurations();
        if (count($invoice_data['student_sessions']) > 0)
        {
            $session_details = '<table width="50%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left"><strong>DATE</strong></td>
              <td align="right"><strong>DURATION</strong></td>
            </tr>';
            foreach($invoice_data['student_sessions'] as $each_session) {
                $bill_info = $this->checkStudentMiniBill($student,$each_session['session_duration']);
				if($bill_info > 0) {
					$min_charged_hours = $bill_info;
				}
				else
				{
					$min_charged_hours = $each_session['session_duration'];
				}
				$sessions_details .= '
				  <tr>
				    <td align="left">'.date("d M Y", strtotime($each_session['session_date'])).'</td>
				    <td align="right">'.$duration_array[$min_charged_hours].'</td>
				  </tr>';
			}

			$sessions_details .= '</table>';
        }

        $package_details = "";
        if(count($invoice_data['update_student_packages']) > 0) {
			$package_details = '<table width="80%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			    <td align="left"><strong>Package Name </strong></td>
			    <td align="center"><strong>Total Hours </strong></td>
			    <td align="center"><strong>Deducted Hours </strong></td>
			  </tr>';
			foreach($invoice_data['update_student_packages'] as $each_package) {
				$package_details .= '
				  <tr>
				    <td align="left">'.$each_package['package_name'].'</td>
				    <td align="center">'.$each_package['left_hours'].'</td>
				    <td align="center">'.$each_package['deduct_hours'].'</td>
				  </tr>';				
			}

			$package_details .= '</table>';
		}

		// Here you can define keys for replace before sending mail to Student
		$replace_info = array(
            'STUDENT_NAME' => $invoice_data['student_name'], 
            'INVOICE_NUMBER' => $invoice_data['invoice_num'], //$invoice_data['invoice_prefix'].'-'.$invoice_data['invoice_num'] 
            'NUM_OF_SESSIONS' => $invoice_data['num_of_sessions'], 
            'PACKAGES_DETAILS' => $package_details, 
            'SESSIONS_DETAILS' => $sessions_details, 
            'TOTAL_HOURS' => $this->format_hours($invoice_data['total_hours']), 
            'TOTAL_AMOUNT' => '$'.$invoice_data['total_amount'], 
            'INVOICE_DATE' => date("M Y", strtotime($invoice_data['invoice_date'])), 
            'INVOICE_NOTE' => $invoice_data['invoice_notes'], 
        );

        foreach($replace_info as $rep_key => $rep_text) {
        $message = str_replace('@'.$rep_key.'@', $rep_text, $message);
        }

        return $message;
    }

    public function editStudentInvoice($invoice_id, $data)
    {
        $invoice = Invoice::where(function($invoice) use ($invoice_id) {
            return $invoice->where('id', $invoice_id);
        })->first();

        $invoice->invoice_date = $data['invoice_date'];
        $invoice->num_of_sessions = $data['num_of_sesions'];
        $invoice->total_hours = (float)$data['total_hours'];
        $invoice->hour_charged = (float)$data['hour_charged'];
        $invoice->total_amount = (float)$data['total_amount'];
        $invoice->invoice_format = $data['invoice_format'];
        $invoice->log_data = $data['log_date'];
        $invoice->status = $data['invoice_status'];

        return $invoice->save();
    }

    public function addStudentInvoice($data)
    {
        $invoice = Invoice::create([
            'student_id'        => $data['students_id'],
            'invoice_num'       =>  $data['invoice_num'],
            'invoice_prefix'    => $data['invoice_prefix'],
            'invoice_date'      => $data['invoice_date'], 
            'num_of_sessions'   => (int)$data['num_of_sessions'],
            'total_hours'       => (float)$data['total_hours'],
            'hour_charged'      => (float)$data['hour_charged'],
            'total_amount'      => (float)$data['total_amount'] ,
            'invoice_format'    => $data['invoice_format'],
            'log_data'          => $data['log_data'],
            'invoice_status'    => $data['invoice_status'],
        ]);  
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
        return $sessions;
    }

    public function checkStudentMiniBill($student, $session_duration)
    {
        if ($student->grade_id <= 7 && $session_duration < 1.00) return 1.00;
        elseif ($student->grade_id > 7 && $session_duration < 1.50) return 1.00;

        return 0;
    }

    public function getStudentPackages(User $student)
    {
        $orders = Order::where(function($order) use ($student){
            return $order->where('user_id', $student->id)
            -> where('order_status_id', 5)
            -> where('left_hours', '!=', 0)
            -> has('packages');
        }) -> get();
        return $orders;
    }

    public function getStudentRate(User $student)
    {
        $grade = $student->grades() -> first();
        switch($student->country()->first()['name']) {
            case 'Canada':
                if($student->state()['nmae'] == 'Alberta' || $student->state()['nmae'] == 'AB')
                    return $grade['price_alb'];
                else
                    return $grade['price_can'];
            case 'USA':
                return $grade['price_usa'];
            default :
                return $grade['price_usa'];
        }
    }

    public function getInformation(Int $id)
    {
        $information = Information::where(function($information) use ($id){
            return $information->where('id', $id);
        }) -> first();

        $keyword = UrlAlias::where(function($url_alias) use ($id){
            return $url_alias->where('query', 'like', "information_id=" . $id);
        }) -> first()['keyword'];

        return [
            'information'   => $information,
            'keyword'       => $keyword,
        ];
    }

    public function getAllDurations(){
		$duration_array = array(
            ""=>"", 
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
            "5.00"=>"5 Hours",
            "1:00"=>"cancelled with less than 24 hours", 
        );
        return $duration_array;
    }
    
    public function generateStudentInvoiceNumber()
    {
        $invoice_last = Invoice::all()->last();
        $invoice_id = $invoice_last->id + 1;
        $setting = Setting::where(function($setting){
            return $setting->where('key', 'like', 'config_invoice_no');
        })->get();
        $setting->value = $invoice_id;
        $setting->save();
        return $invoice_id;
    }

    public function generate_paycheques() {
        $billing_date = substr(session('process_date'), 0, strlen(session('process_date')) - 2);
        $total_tutors = $this->generateTutorsPaycheque($billing_date, 0);
        $check_all_tutors = Array();
        foreach($total_tutors as $tutor) {
            $check_all_tutors[] = $tutor->id;
        }
        $filter_data_essay = Array(
        'filter_date_completed' => $billing_date,
        'filter_current_status' => 4,
        'filter_locked' => 0
        );
        $all_essayes_tutors = $this->getTutorEssaysAmount($filter_data_essay);
        $check_all_essays = Array();
        foreach($all_essayes_tutors as $tutor) {
            dd($tutor);
            $check_all_essays = $tutor['num_of_essay'];
        }
        $check_all_essays = array_diff($check_all_essays, $check_all_tutors);
        foreach($check_all_essays as $tutor) {
            $total_tutors[] = array(
            'tutors_id' => $tutor,
            'name' => '',
            'num_of_sessions' => 0, 
            'total_hours' => 0,
            'total_amount' => 0			
            );
        }
        $total_generated = $total_updated = 0;
        foreach ($total_tutors as $tutor) {
            $tutor_data = Array();
            $tutor_data = $tutor;
            $log_data = Array();
            $log_data['all_sessions'] = $this->getTutorSessions($tutor_data['tutors_id'], $billing_date, 0);
            $tutorRaiseAmount = $this->getTutorRaiseAmount($tutor_data['tutors_id'], $billing_date, 0);

            $raise_amount = $tutorRaiseAmount['tutor_raise_amount'];
            $log_data['all_students_data'] = $tutorRaiseAmount['all_students_data'];
            if($raise_amount > 0) {
                $tutor_data['raise_amount'] = $raise_amount;
                $tutor_data['total_amount'] = ($tutor_data['total_amount'] + $raise_amount);

            } else {
                $tutor_data['raise_amount'] = 0;
            }
            $filter_data_essay = Array(
				'filter_tutor_id' => $tutor_data['tutors_id'],
				'filter_date_completed' => $billing_date,
				'filter_current_status' => 4,
				'filter_locked' => 0
			);
            $log_data['tutor_essays_details'] = Array();
            $essay_info = $this->getTutorEssaysAmount($filter_data_essay);
            if (count($essay_info) > 0) {
                $essay_info = $essay_info[0];
                $log_data['tutor_essays_details'] = $this->getTutorEssaysDetails($filter_data_essay);
                $tutor_data['num_of_essay'] = $essay_info['num_of_essay'];
                $tutor_data['essay_amount'] = $essay_info['total_amount'];
                $tutor_data['total_amount'] = ($tutor_data['total_amount'] + $essay_info['total_amount']);
            } else {
                $tutor_data['num_of_essay'] = $tutor_data['essay_amount'] = 0;
            }
            $tutor_data['total_amount'] = round($tutor_data['total_amount'], 2);
            $tutor_data['paycheque_status'] = 'Hold For Approval';
            $tutor_data['paycheque_date'] = session('process_date');
            $check_paycheque = $this->checkTutorPaycheque($tutor_data['tutors_id'], $billing_date);
            $tutor_data['log_data'] = serialize($log_data);
            if (count($check_paycheque) > 0) {
                if (! $check_paycheque['is_locked']) {
                    $this->editTutorPaycheque($check_paycheque, $tutor_data);
                    $total_updated ++;
                }
            } else {
                $this->addTutorPaycheque($tutor_data);
                $total_generated ++;
            }
        }
        #---------------- Setting Template Data ----------------#
        $process_data = session('process_data');

        if(!isset($process_data['generate_paycheques'])) {
            $process_data['generate_paycheques'] = Array (
            'paycheques_generated' => $total_generated,
            'paycheques_updated' => $total_updated,
            );                
            session(['process_data' => $process_data]);
        }
        #---------------- Setting Template Data ----------------#
        ################# Setting up the next Step #####################
        $allowed_next = 1;
        if($allowed_next) {
            $payment_process = session('payment_process');
            $payment_process['generate_paycheques'] = 0;
            session(['payment_process' => $payment_process]);              
            foreach($payment_process as $current_step => $each_step) {
                if($each_step) {
                    session(['current_step' => $current_step]);
                    break;
                }
            }
        }
        ################# Setting up the next Step #####################
    }

    public function addTutorPaycheque($data) {
        $paycheque = Paycheque::create([
            'tutor_id'          => $data['tutors_id'],
            'paycheque_date'    => $data['paycheque_date'],
            'num_of_essays'     => $data['num_of_essay'],
            'essay_amount'      => $data['essay_amount'],
            'raise_amount'      => $data['raise_amount'],
            'num_of_sessions'   => $data['num_of_sessions'],
            'total_hours'       => $data['total_hours'],
            'total_amount'      => $data['total_amount'],
            'status'            => $data['paycheque_status']
        ]);
        return $paycheque->id;
    }

    public function editTutorPaycheque($paycheque, $data) {
        $paycheque->paycheque_date = $data['paycheque_date'];
        $paycheque->num_of_essays = $data['num_of_essay'];
        $paycheque->essay_amount = $data['essay_amount'];
        $paycheque->raise_amount = $data['raise_amount'];
        $paycheque->num_of_sessions = $data['num_of_sessions'];
        $paycheque->total_hours = $data['total_hours'];
        $paycheque->total_amount = $data['total_amount'];
        $paycheque->status	 = $data['paycheque_status'];
        $paycheque->log_data = $data['log_data'];
        $paycheque->save();
        return $paycheque;
    }

    public function checkTutorPaycheque($tutor_id, $billing_date) {
        return Paycheque::where(function($paycheque) use ($tutor_id, $billing_date){
            return $paycheque-> where('tutor_id', $tutor_id)
            -> where('paycheque_date', $billing_date);
        }) -> first();
    }

    public function getTutorEssaysDetails($data) {
        $essay_assignments = EssayAssignment::where(function($assignment) use ($data){
            return $assignment -> where('tutor_id', $data['filter_tutor_id'])
            -> where('date_completed', 'like', "%" . $data['filter_date_completed'] . "%")
            -> where('status_id', $data['filter_current_status'])
            -> where('is_locked', $data['filter_locked']);
        }) -> get('id') -> pluck('id') -> toArray();
        return $essay_assignments;
    }

    public function getTutorRaiseAmount($tutor_id, $billing_date, $filter_lock) {
        $sessions = Session::where(function($session) use ($billing_date, $filter_lock){
            return $session -> where('date_submittion', 'like', "%" . $billing_date . "%")
            -> where('p_locked', $filter_lock);
        });
        $sessions = $sessions->whereHas('assignments', function ($assignment) use ($tutor_id){
            return $assignment->where('tutor_id', $tutor_id);
        });
    }

    public function getTutorSessions($tutor_id, $billing_date, $filter_lock) {
        $sessions = Session::where(function($session) use ($billing_date, $filter_lock){
            return $session -> where('date_submittion', 'like', "%" . $billing_date . "%")
            -> where('p_locked', $filter_lock);
        });
        $sessions = $sessions->whereHas('assignments', function ($assignment) use ($tutor_id){
            return $assignment->where('tutor_id', $tutor_id);
        });
        return $sessions->get('id') -> pluck('id') -> toArray();
    }

    public function getTutorEssaysAmount($data) {
        $assignmentIDs = EssayAssignment::where(function($assignment) use ($data) {
            if (!isset($data['filter_tutor_id']))
            {
                return $assignment->where('date_completed', 'like', "%" . $data['filter_date_completed'] . "%")
                -> where('status_id', $data['filter_current_status'])
                -> where('is_locked', $data['filter_locked']);
            }

            return $assignment->where('date_completed', 'like', "%" . $data['filter_date_completed'] . "%")
            -> where('status_id', $data['filter_current_statuys'])
            -> where('is_locked', $data['filter_locked']) -> where('tutor_id', $data['filter_tutor_id']);
        }) -> get('id') -> pluck('id') -> toArray();
        $tutors = User::whereHas('tutor_essayAssignments', function($essayAssignment) use ($assignmentIDs){
            return $essayAssignment->whereIn('id', $assignmentIDs);
        });
        $results = Array();
        foreach($tutors as $tutor) {
            $results[] = [
                'tutor_id'      => $tutor->id,
                'num_of_essay'  => count($tutor->tutor_essayAssignments->get()),
                'total_amount'  => array_sum($tutor->tutor_essayAssignments->get('paid')->pluck('paid')->toArray()),
            ];
        }
        return $results;
    }

    public function generateTutorsPaycheque($billing_date, $filter_lock) {
        $assignmentIds = Assignment::whereHas('sessions', function($session) use ($billing_date, $filter_lock){
            return $session->where('date_submission', 'like', "%" . $billing_date . "%")
            -> where('i_locked', $filter_lock);
        }) -> get('id') -> pluck('id') -> toArray();

        $tutors = User::whereHas('tutor_assignments', function($assignment) use ($assignmentIds) {
            return $assignment -> whereIn('id', $assignmentIds);
        }) -> get();

        return $tutors;
    }

    public function send_invoices()
    {
        $billing_date = session('process_date');
        $billing_date = substr($billing_date, 0, strlen($billing_date) - 2);
 
        $total_invoices = $this->getInvoices($billing_date, 0);
        $total_invoice_lock = 0;
        foreach ($total_invoices as $invoice) {
            if ($this->lockInvoices($invoice)) $total_invoice_lock ++;
        }

        $total_locked_invoices = $this->getInvoices($billing_date, 1);
        $total_invoice_sent = 0;
        foreach($total_locked_invoices as $locked_invoice) {
            if (!empty($locked_invoice->email)) {
                $locked_invoice->invoice_date =  date('d-M-Y', strtotime($locked_invoice->invoice_date));
                if (substr_count($locked_invoice->invoice_format, "Account Update") > 0)
                    $invoice_mailsubject = $this->getInformation(15);
                else $invoice_mailsubject = $this->getInformation(12);

                // take subject from information table
                $subject = str_replace('@INVOICE_DATE@', date('M Y', strtotime($locked_invoice->invoice_date)), 
                    $invoice_mailsubject['information']->title);
                $message = $locked_invoice->invoice_format;
                Mail::to($locked_invoice->users()->first()['email']) -> send(
                new SendMail(['subject' => $subject, 'message' => $message]));
                $locked_invoice->invoice_status = $locked_invoice->total_amount<=0?"Paid":"Reminder Sent";
                $this->addInformation(session('user_id'), $locked_invoice->student_id, $subject
                , 'Your Invoice for the date('.$$locked_invoice->invoice_date.') has been generated.');
                $total_invoice_sent ++;
            }
        }
        #---------------- Setting Template Data ----------------#
        if(session()->has('process_data'))
            $process_data = session('process_data');
        else
            $process_data = Array();

        if(!isset($process_data['send_invoices'])) {
            $process_data['send_invoices'] = Array(
                'total_invoice_lock' => $total_invoice_lock,
                'total_invoice_sent' => $total_invoice_sent,
            );
                
            session(['process_data' => $process_data]);
        }
        #---------------- Setting Template Data ----------------#
        ################# Setting up the next Step #####################
        $allowed_next = 1;
        if($allowed_next) {
            $payment_process = session('payment_process');                
            $payment_process['send_invoices'] = 0;
            session(['payment_process' => $payment_process]);                
            foreach($payment_process as $current_step => $each_step) {
                if($each_step) {
                    session(['current_step' => $current_step]);
                    break;
                }
            }
        }
        ################# Setting up the next Step #####################
    }

    public function getInvoices(String $billing_date, Int $filter_lock)
    {
        $invoices = Invoice::where(function($invoice) use ($billing_date, $filter_lock){
            return $invoice -> where('invoice_date', 'like', "%" . $billing_date . "%")
            -> where('is_locked', $filter_lock);
        });
        return $invoices;
    }

    public function lockInvoices(Invoice $invoice)
    {
        $invoice->is_locked = 1;
        $invoice->save();

        if ($invoice != NULL)
        {
            $get_log_data = unserialize($invoice->log_data);
            if (count($get_log_data['student_packages']) > 0)
            foreach($get_log_data['student_packages'] as $package)
            {
                $left_package_hours = $package['left_hours'] - $package['deduct_hours'];
                if ($left_package_hours < 0) $left_package_hours = 0;

                $order_id = $package['order_id'];
                $hours_left = $left_package_hours;
                $old_left_hours = $package['left_hours'];
                if($old_left_hours != $hours_left) {
                    OrderHistory::create([
                        'order_id'          => $order_id,
                        'order_status_id'   => 5,
                        'notify'            => '0',
                        'comment'           => "Remaining Hours Update From ".$old_left_hours." To ".$hours_left
                    ]);
                }
            }
            $sessions_ides = Array();
                foreach($get_log_data['student_sessions'] as $each_sessions) {
                    $sessions_ides[] = $each_sessions['session_id'];
                }
                if(empty($sessions_ides)) $sessions_ides = 0;

                $session = Session::where(function ($session) use ($sessions_ides) {
                    return $session->whereIn('id', $sessions_ides);
                });
                if ($session != NULL) $session->is_locked = $session->i_locked = 1;
                $session->save();
        }
        return $invoice;
    }

    public function addInformation($from, $to, $subject, $message)
    {
        return Notification::create([
            'notification_from' => $from,
            'notification_to'   => $to,
            'headers'           => "",
            'subject'           => $subject,
            'message'           => $message,
        ]);
    }

    public function send_paycheques() {
        $billing_date = substr(session('process_date'),0,strlen(session('process_date'))-2);
        $total_paycheques = $this->getPaycheques($billing_date, 0);
        $total_paycheques_lock = 0;
        foreach($total_paycheques as $paycheque) { 
            if($this-> lock_paycheques($paycheque)) $total_paycheques_lock ++;
        }
        $total_paycheques_sent = 0;
        #---------------- Setting Template Data ----------------#
        $process_data = session('process_data');
        if(!isset($process_data['send_paycheques'])) {
            $process_data['send_paycheques'] = array(
            'total_paycheques_lock' => $total_paycheques_lock,
            'total_paycheques_sent' => $total_paycheques_sent,
            );                
            session(['process_data' => $process_data]);
        }
        #---------------- Setting Template Data ----------------#
        ################# Setting up the next Step #####################
        $allowed_next = 1;
        if($allowed_next) {
            $payment_process = session('payment_process');
            $payment_process['send_paycheques'] = 0;
            session(['payment_process' => $payment_process]);
            foreach($payment_process as $current_step => $each_step) {
                if($each_step) {
                    session(['current_step' => $current_step]);
                    break;
                }
            }
        }
        ################# Setting up the next Step #####################
    }

    public function getPaycheques($billing_date, $filter_locked) {
        return Paycheque::where(function ($paycheque) use ($billing_date, $filter_locked){
            return $paycheque->where('paycheque_date', 'like', "%" . $billing_date . "%")
            ->where('is_locked', $filter_locked);
        });
    }

    public function lock_paycheques($paycheque) {
        $paycheque->is_locked = 1;
        if ($paycheque->save()) {
            $log_data = unserialize($paycheque->log_data);
            $sessions_ides = $log_data['all_sessions'];			
            $sessions_ides = implode(",", $sessions_ides);
            if(empty($sessions_ides)) $sessions_ides = 0;
            $sessions = Session::where(function($session) use ($sessions_ides){
                return $session->whereIn('id', $sessions_ides);
            });
            foreach ($sessions as $session) {
                $session->is_locked = $session->p_locked = 1;
                $session->save();
            }
            $essays_ides = $log_data['tutor_essays_details'];
            $essays_ides = implode(",", $essays_ides);
            if(empty($essays_ides)) $essays_ides = 0;
            $assignments = EssayAssignment::where(function($assignment) use ($essays_ides){
                return $assignment ->whereIn('id', $essays_ides);
            });
            foreach ($assignments as $assignment) {
                $assignment->is_locked = 1;
                $assignment->save();
            }
        }
        return $paycheque;
    }

    public function finished() {
        session() -> forget('process_date');
		session() -> forget('payment_process');
		session() -> forget('process_data');
        session() -> forget('current_step');
        session()->flash('success', "Billing process has been completed.");
        session(['success' => "Success: Billing process has been completed."]);
        $this->data['payment_date'] = 0;
        //dd("finished");
        //return redirect()->route('admin.process.index');
    }
}