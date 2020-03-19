<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Income;
use App\Expense;

use App\Imports\ImportMonthlyIncome;
use App\Imports\ImportProfit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use File;

use Maatwebsite\Excel\Facades\Excel;
use symfony\console\Input\Input;

class CSVUploadController extends Controller
{
    public function index()
    {
        return view('admin.csvupload.index');
    }

    public function store(Request $request)
    {
        //dd ($request['income_file']);
        $validator = Validator::make($request->all(), [
            'income_file'   => 'nullable',
            'expense_file'  => 'nullable',
        ]);
        
        if ($validator->fails())
        {
            session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.csvupload.index');
        }

        $data = $request->all();
        if (!isset($data['income_file']) && !isset($data['expense_file']))
        {
            session()->flash('error', "Please select at least one Income or Expense File!");
            return redirect()->route('admin.csvupload.index');
        }
        
        if ($file = $request->file('income_file'))
        {
            if ($file->getClientOriginalExtension() != 'csv')
            {
                session()->flash('error', "Please select CSV File!");
                return redirect()->route('admin.csvupload.index');
            }
            
            Excel::import(new ImportMonthlyIncome, request()->file('income_file'));
            session() -> flash('success', "CSV File Uploaded successfully.");
        }
  
        if ($file = $request->file('expense_file'))
        {
            if ($file->getClientOriginalExtension() != 'csv')
            {
                session()->flash('error', "Please select CSV File!");
                return redirect()->route('admin.csvupload.index');
            }
            Excel::import(new ImportProfit, request()->file('expense_file'));
            session() -> flash('success', "CSV File Uploaded successfully.");
        }

        return redirect()->route('admin.expenses.index');
    }
}