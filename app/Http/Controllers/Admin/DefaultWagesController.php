<?php

namespace App\Http\Controllers\Admin;

use App\DefaultWage;
use App\Assignment;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use App\Exports\ExportBaseRates;

use Maatwebsite\Excel\Facades\Excel;

class DefaultWagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $defaultwage = DefaultWage::all()->first();
        return view('admin.defaultwages.index') -> with('defaultwage', $defaultwage);
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
     * @param  \App\DefaultWage  $defaultWage
     * @return \Illuminate\Http\Response
     */
    public function show(DefaultWage $defaultWage)
    {
        return Excel::download(new ExportBaseRates, 'baserates.csv');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DefaultWage  $defaultWage
     * @return \Illuminate\Http\Response
     */
    public function edit(DefaultWage $defaultWage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DefaultWage  $defaultWage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DefaultWage $defaultwage)
    {
        if (Gate::denies('manage-payments'))
        {
            return redirect()->route('admin.defaultwages.index');
        }

        $validator = Validator::make($request->all(), [
            'wage_usa'          => ['required', 'string'],
            'wage_canada'       => ['required', 'string'],
            'wage_alberta'      => ['required', 'string'],
            'invoice_usa'       => ['nullable', 'string'],
            'invoice_canada'    => ['nullable', 'string'],
            'invoice_alberta'   => ['nullable', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.defaultwages.index');
        }

        $data = $request->all();
        foreach($data as $key => $value)
        {
            if (isset($defaultwage[$key]))
            {
                $defaultwage[$key] = $value;
            }
        }

        if (!$defaultwage -> save())
        {
            $request->session()->flash('error', "There is an error modifying Base Invoice Rates!");
            return redirect()->route('admin.defaultwages.index');
        }

        $request->session()->flash('success', "You have successfully modified Base Invoice Rates!");
        return view('admin.defaultwages.index') -> with('defaultwage', $defaultwage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DefaultWage  $defaultWage
     * @return \Illuminate\Http\Response
     */
    public function destroy(DefaultWage $defaultWage)
    {
        //
    }

    public function export(Request $request)
    {
    }
}
