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
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date',
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

        $expenses_search = Expense::whereRaw($q)->get();

        $expenses_searchdate = Expense::all();

        if (isset($request_data['start_date']) && isset($request_data['end_date']))
        {
            $expenses_searchdate = Expense::whereBetween('date', [
                $request_data['start_date'], $request_data['end_date']
            ])->get();
        } else{
            $request_data['start_date'] = isset($request_data['start_date']) ? $request_data['start_date'] : "";
            $request_data['end_date'] = isset($request_data['end_date']) ? $request_data['end_date'] : "";
        }



        if ($request->input('action') == 'search') {
            $expenses = $expenses_search;

        } else {
            $expenses = $expenses_searchdate;
        }

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
        return view('admin.expenses.create');
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
            'e_name'        => ['required', 'string'],
            'expense_date'  => ['required', 'date'],
            'amount'        => ['required', 'string'],
            'notes'         => ['nullable', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.expenses.create');
        }

        $data = $request->all();
        if (!isset($data['notes'])) $data['notes'] = '';
        $expense = Expense::create([
            'name'              => $data['e_name'],
            'date'              => $data['expense_date'],
            'amount'            => $data['amount'],
            'detail'            => $data['notes'],
        ]);

        if($expense == NULL) {
            $request->session()->flash('error', 'There is an error creating the Expense details');
            return redirect()->route('admin.expenses.create');
        }

        $request->session()->flash('success', 'Expense details have been successfully created');
        return redirect()->route('admin.expenses.index');
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
        return view('admin.expenses.edit')->with('expense', $expense);
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
        $validator = Validator::make($request->all(), [
            'e_name'        => ['required', 'string'],
            'expense_date'  => ['required', 'date'],
            'amount'        => ['required', 'string'],
            'notes'         => ['nullable', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.expenses.edit', $expense);
        }

        $data = $request->all();
        $expense->name = $data['e_name'];
        $expense->date = $data['expense_date'];
        $expense->amount = $data['amount'];
        if (isset($data['notes'])) $expense->detail = $data['notes'];

        if(!$expense->save()) {
            $request->session()->flash('error', 'There is an error updating the Expense details');
            return redirect()->route('admin.expenses.edit', $expense);
        }

        $request->session()->flash('success', 'Expense details have been successfully updated');
        return redirect()->route('admin.expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        if (Gate::denies('manage-payments')) {
            return redirect()->route('admin.expenses.index');
        }

        $expense->delete();
        return redirect()->route('admin.expenses.index');
    }
}
