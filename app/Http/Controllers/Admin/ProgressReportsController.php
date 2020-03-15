<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProgressReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class ProgressReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            't_name'        => 'nullable|string',
            's_name'        => 'nullable|string',
            'grade'         => 'nullable|string',
            'subjects'      => 'nullable|string',
            'date_added'    => 'nullable|date', 
        ]);

        $q = "1=1 ";
        if (isset($request_data['subjects'])) {
            $q .= " and subjects like '%" . $request_data['subjects'] . "%'";
        } else $request_data['subjects'] = "";
        if (isset($request_data['date_added'])) {
            $q .= " and created_at like '%" . $request_data['date_added'] . "%'";
        } else $request_data['date_added'] = "";
        $progressreports = ProgressReport::whereRaw($q);

        if (isset($request_data['t_name'])) {
            $progressreports = $progressreports->whereHas('tutors', function ($tutor) use ($request_data){
                return $tutor->where('fname', 'like', "%" . $request_data['t_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['t_name'] . "%");
            });
        } else $request_data['t_name'] = "";

        if (isset($request_data['s_name'])) {
            $progressreports = $progressreports->whereHas('students', function ($student) use ($request_data){
                return $student->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
            });
        } else $request_data['s_name'] = "";

        if (isset($request_data['grade'])) {
            $progressreports = $progressreports->whereHas('grades', function ($grade) use ($request_data){
                return $grade->where('name', 'like', "%" . $request_data['grade'] . "%");
            });
        } else $request_data['grade'] = "";

        $progressreports = $progressreports->get();

        $data = [
            'progressreports'   => $progressreports,
            'old'               => $request_data
        ];

        if (count($progressreports) == 0) $request->session()->flash('error', 'No Search Result!');

        return view('admin.progressreports.index')->with('data', $data);
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
     * @param  \App\ProgressReport  $progressReport
     * @return \Illuminate\Http\Response
     */
    public function show(ProgressReport $progressreport)
    {
        return view('admin.progressreports.show')->with('progressreport', $progressreport);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgressReport  $progressReport
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgressReport $progressReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgressReport  $progressReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgressReport $progressReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgressReport  $progressReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgressReport $progressReport)
    {
        //
    }
}
