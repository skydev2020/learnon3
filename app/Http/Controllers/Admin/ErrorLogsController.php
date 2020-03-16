<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorLogsController extends Controller
{
    public function index()
    {
        $file_name = "C:/xampp/htdocs/learnon3/logs/error_new.txt";
        $data = file_get_contents($file_name, FALSE, NULL);
        return view('admin.errorlogs.index')->with('data', $data);
    }

    public function show()
    {
        $file_name = "C:/xampp/htdocs/learnon3/logs/error_new.txt";
        
        $handle = fopen($file_name, 'w+');
        if ($handle == NULL)
        {
            session()->flash('error', "There is an error clearing you error log!");
        }
        else 
        {
            fclose($handle);
            session()->flash('success', "You have successfully cleared your error log!");
        }
        return redirect()->route('admin.errorlogs.index');
    }
}
