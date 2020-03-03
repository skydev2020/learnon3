<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\StudentInvoice;
use Illuminate\Http\Request;

class StudentInvoicesController extends Controller
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

        $studentInvoices = StudentInvoice::whereRaw($q);
        
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
        
        return view('admin.studentinvoices.index')->with('data', $data);
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
     * @param  \App\StudentInvoice  $studentInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(StudentInvoice $studentInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentInvoice  $studentInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentInvoice $studentinvoice)
    {
        return view('admin.studentinvoices.edit')->with('invoice', $studentinvoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentInvoice  $studentInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentInvoice $studentinvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentInvoice  $studentInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentInvoice $studentinvoice)
    {
        //
    }
}
