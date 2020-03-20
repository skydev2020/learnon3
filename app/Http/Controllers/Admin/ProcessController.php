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
            $result['invoice_date'] = $this->session->data['process_date'];

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
}
