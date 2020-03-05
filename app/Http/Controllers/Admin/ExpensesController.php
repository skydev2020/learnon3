<?php

namespace App\Http\Controllers\Admin;

use App\Expense;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            'e_name'        => 'nullable|string',
            'amount'        => 'nullable|string',
            'expense_date'  => 'nullable|date',
            
        ]);

        $q = "1=1 ";
        if (isset($request_data['e_name'])) {
            $q .= " and name like '%" . $request_data['e_name'] . "%'";
        } else $request_data['e_name'] = "";

        if (isset($request_data['amount'])) {
            $q.= " and amount like '%".$request_data['amount']."%'";
        } else $request_data['amount'] = "";

        if (isset($request_data['expense_date'])) {
            $q.= " and date like '%".$request_data['expense_date']."%'";
        } else $request_data['expense_date'] = "";

        $expenses = Expense::whereRaw($q)->get();
        
        $data = [
            'expenses'  => $expenses,
            'old'       => $request_data,
        ];

       if( count($expenses) == 0 ) $request->session()->flash('error', "No search results!");
        
        return view('admin.expenses.index')->with('data', $data);
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
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
