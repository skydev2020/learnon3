<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\OtherIncome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OtherIncomesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.otherincomes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'i_name'        => ['required', 'string'],
            'income_date'   => ['required', 'date'],
            'amount'        => ['required', 'string'],
            'notes'         => ['nullable', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.otherincomes.create');
        }

        $data = $request->all();
        if (!isset($data['notes'])) $data['notes'] = '';
        $otherincome = OtherIncome::create([
            'name'              => $data['i_name'],
            'date'              => $data['income_date'],
            'amount'            => $data['amount'],
            'notes'             => $data['notes'],
        ]);

        if($otherincome == NULL) {
            $request->session()->flash('error', 'There is an error creating the other Income!');
            return redirect()->route('admin.otherincomes.create');
        }

        $request->session()->flash('success', 'Other Income has been successfully created!');
        return redirect()->route('admin.otherincomes.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OtherIncome  $otherIncome
     * @return \Illuminate\Http\Response
     */
    public function show(OtherIncome $otherIncome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OtherIncome  $otherIncome
     * @return \Illuminate\Http\Response
     */
    public function edit(OtherIncome $otherIncome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OtherIncome  $otherIncome
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OtherIncome $otherIncome)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OtherIncome  $otherIncome
     * @return \Illuminate\Http\Response
     */
    public function destroy(OtherIncome $otherIncome)
    {
        //
    }
}
