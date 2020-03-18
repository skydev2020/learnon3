<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CSVUploadController extends Controller
{
    public function index()
    {
        return view('admin.csvupload.index');
    }
}
