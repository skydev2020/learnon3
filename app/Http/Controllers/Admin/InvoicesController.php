<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Invoice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use DateTime;

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
            'invoice_num'       => 'nullable|string',
            's_name'            => 'nullable|string',
            'date_added'        => 'nullable|date',
            'status'            => 'nullable|string'
        ]);

        $q = "1=1 ";
        if (isset($request_data['invoice_num'])) {
            $q .= " and num like '%" . $request_data['invoice_num'] . "%'";
        } else $request_data['invoice_num'] = "";

        if (isset($request_data['date_added'])) {
            $q.= " and date_added like '%".$request_data['date_added']."%'";
        } else $request_data['date_added'] = "";

        if (isset($request_data['status'])) {
            $q.= " and status like '%".$request_data['status']."%'";
        } else $request_data['status'] = "";

        $invoices = Invoice::whereRaw($q);

        if (isset($request_data['s_name'])) {
            $invoices = $invoices->whereHas('students', function($student) use ($request_data) {
            return $student->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
            });
        } else $request_data['s_name'] = "";
        $invoices = $invoices->get();

        $data = [
            'invoices'   => $invoices,
            'old'        => $request_data,
        ];

       if( count($invoices) == 0 ) $request->session()->flash('error', "No search results!");

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
    public function update(Request $request, Invoice $invoice)
    {
        $validator = Validator::make($request->all(), [
            'invoice_date'      => ['nullable', 'date'],
            'num_of_sessions'   => ['required', 'int'],
            'total_hours'       => ['required', 'string'],
            'total_amount'      => ['required', 'string'],
            'paid_amount'       => ['nullable', 'string'],
            'invoice_notes'     => ['nullable', 'string'],
            'status'            => ['nullable', 'string'],
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $studentInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        if (Gate::denies('manage-payments')) {
            return redirect()->route('admin.invoices.index');
        }

        $invoice->delete();
        return redirect()->route('admin.invoices.index');
    }

    public function lock(Request $request, Invoice $invoice)
    {
        if (Gate::denies('manage-payments'))
        {
            return redirect()->route('admin.invoices.index');
        }

        $invoice->is_locked = 1;
        if (!$invoice->save())
        {
            $request->session()->flash('error', 'There is an error locking the Invoice!');
            return redirect()->route('admin.invoices.index');
        }
        session()->flash('success', 'You have Locked the Invoice!');
        return redirect()->route('admin.invoices.index');
    }

    public function unlock(Request $request, Invoice $invoice)
    {
        if (Gate::denies('manage-payments'))
        {
            return redirect()->route('admin.invoices.index');
        }

        $invoice->is_locked = 0;
        if (!$invoice->save())
        {
            $request->session()->flash('error', 'There is an error Unlocking the Invoice!');
            return redirect()->route('admin.invoices.index');
        }
        session()->flash('success', 'You have Unlocked the Invoice!');
        return redirect()->route('admin.invoices.index');
    }

    public function applyLateFee(Request $request, Invoice $invoice){
        if (gate::denies('manage-payments'))
        {
            return redirect()->route('admin.invoices.index');
        }

        $date_added = $invoice->invoice_date;
        $current_date = date('Y-m-d');

        $date_added_obj	= new DateTime($date_added);
		$current_date_obj = new DateTime($current_date);

        $months = $current_date_obj->diff($date_added_obj)->m;
        $late_fee = ($months - 1) * 20;
        $total_amount = $invoice->total_amount - $invoice->late_fee + $late_fee;
        $invoice->late_fee = $late_fee;
        $invoice->total_amount = $total_amount;
        $invoice->status = "Reminder Sent";

        if (!$invoice->save())
        {
            $request->session()->flash('error', 'There is an error applying Late Fee for this invoice!');
            return redirect()->route('admin.invoices.index');
        }
        session()->flash('success', 'Late Fee Applied Successfuly for this invoice!');
        return redirect()->route('admin.invoices.index');
    }
}
