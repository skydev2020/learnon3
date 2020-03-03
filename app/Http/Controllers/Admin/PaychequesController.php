<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Paycheque;
use Illuminate\Http\Request;

class PaychequesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.paycheques.index');
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
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function show(Paycheque $paycheque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function edit(Paycheque $paycheque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paycheque $paycheque)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paycheque  $paycheque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paycheque $paycheque)
    {
        //
    }
}
