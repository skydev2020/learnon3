<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\Session;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Auth::user()->invoices()->get();
        $status = Array();
        foreach ($invoices as $invoice)
        {
            $status[$invoice->id] = "";
            $orders = $invoice->orders() -> get();
            if (count($orders) > 0)
            {
                $paid_orders = $invoice->orders()->where(function($order){
                    return $order -> where('status_id', 5);
                }) -> get();
                if ($paid_orders != NULL) $status[$invoice->id] = "Hold For Approval";
                else $status[$invoice->id] = "Paid";
            } else if($invoice->status != "Paid")
            {
                $status[$invoice->id] = ($invoice->status == 'Reminder Sent') ? 'Unpaid' : $invoice->status;
            }
        }
        $data = [
            'invoices'  => $invoices,
            'statuses'  => $status
        ];
        return view('students.invoices.index') -> with('data', $data);
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
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $sessions = unserialize($invoice->log_data)['student_sessions'];
        $corret_total = 0;
        foreach ($sessions as $session) {
            if ($session['session_duration'] < '1.00') $min_charge_time = '1.00';
            else $min_charge_time = $session['session_duration'];

            $total = round(($min_charge_time * $session['base_invoice']), 2);
            $corret_total += $total;

            $data['invoice_details'][] = Array (
            'tutor_name'    => $session['tutor_name'],
            'date'    => date("M d", strtotime($session['session_date'])),
            'duration'    => Session::getAllDurations()[$session['session_duration']],
            'rate'    => '$ '.$session['base_invoice']." /hours ",
            'total'    => '$ '.$total,
            'min_charge_time'=> $min_charge_time,
            );
        }

        if ($invoice->status != "Hold For Approval")
        {
            $invoice->total_amount = $corret_total;
            $invoice->save();
        }

        $data['invoice'] = $invoice;
        $data['config_name'] = Setting::where('key', 'config_name')->first()['value'];
        $data['config_address'] = Setting::where('key', 'config_address')->first()['value'];
        
        return view('students.invoices.show') -> with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
