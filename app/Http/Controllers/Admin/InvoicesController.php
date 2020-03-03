<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Invoice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            's_name'            => 'nullable|string',
            'date_added'        => 'nullable|date',
            'status'            => 'nullable|string'
        ]);

        $q = "1=1 ";

        if (isset($request_data['date_added'])) {
            $q.= " and date_added like '%".$request_data['date_added']."%'";
        } else $request_data['date_added'] = "";

        if (isset($request_data['status'])) {
            $q.= " and status like '%".$request_data['status']."%'";
        } else $request_data['status'] = "";

        $studentInvoices = Invoice::whereRaw($q);
        
        if (isset($request_data['s_name'])) {
            $studentInvoices = $studentInvoices->whereHas('students', function($student) use ($request_data) {
            return $student->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
            });
        } else $request_data['s_name'] = "";
        $studentInvoices = $studentInvoices->get();

        $data = [
            'studentInvoices'   => $studentInvoices,
            'old'               => $request_data,
        ];

       if( count($studentInvoices) == 0 ) $request->session()->flash('error', "No search results!");
        
        return view('admin.invoices.index')->with('data', $data);
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
     * @param  \App\Invoice  $Invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $Invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $Invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        return view('admin.invoices.edit')->with('invoice', $invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $Invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice, Int $flag)
    {
        if ($flag == 0) {
            $validator = Validator::make($request->all(), [
                'invoice_date'      => ['required', 'date'],
                'num_of_sessions'   => ['required', 'int'],
                'total_hours'       => ['required', 'string'],
                'total_amount'      => ['required', 'string'],
                'paid_amount'       => ['required', 'string'],
                'invoice_notes'     => ['required', 'string'],
                'status'            => ['required', 'string'],
            ]);

            if ($validator->fails())
            {
                $request->session()->flash('error', $validator->messages()->first());
                return redirect()->route('admin.invoices.edit', $invoice);
            }

            $data = $request->all();
            $invoice->invoice_date = $data['invoice_date'];
            $invoice->num_of_sessions = $data['num_of_sessions'];
            $invoice->total_hours = $data['total_hours'];
            $invoice->total_amount = $data['total_amount'];
            $invoice->paid_amount = $data['paid_amount'];
            $invoice->invoice_notes = $data['invoice_notes'];
            $invoice->status = $data['status'];

            if($invoice->save()){
                $request->session()->flash('success', 'You have modified invoices!');
                return redirect()->route('admin.invoices.index');
            }
            
            $request->session()->flash('error', 'There was an error modifying invoices');
            return redirect()->route('admin.invoices.edit', $invoice);
        } else if ($flag == 1) {

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $studentInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
