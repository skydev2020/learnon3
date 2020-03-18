<?php

namespace App\Http\Controllers\Admin;

use App\DefaultWage;
use App\Assignment;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        //
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
    public function update(Request $request, DefaultWage $defaultWage)
    {
        //
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
        $results = $this->getTutorBaseRates();
    }

    public function getTutorBaseRates()
    {
        $assignments = Assignment::has('tutors') -> has('students') -> get();
        return $assignments;
    }
}
