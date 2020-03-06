<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class MailLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            'mail_to'   => 'nullable|string'
        ]);

        $maillogs = MailLog::all();
        
        if (isset($request_data['mail_to']))
        {
            $maillogs = MailLog::where('mail_to', 'like', "%" . $request_data['mail_to'] . "%")->get();
        } else $request_data['mail_to'] = "";

        if (count($maillogs) == 0)
        {
            $request->session()->flash('error', "No search Result!");
        }

        $data = [
            'maillogs'  => $maillogs,
            'old'       => $request_data
        ];
        return view('admin.maillogs.index')->with('data', $data);
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
     * @param  \App\MailLog  $mailLog
     * @return \Illuminate\Http\Response
     */
    public function show(MailLog $maillog)
    {
        return view('admin.maillogs.view')->with('maillog', $maillog);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MailLog  $mailLog
     * @return \Illuminate\Http\Response
     */
    public function edit(MailLog $maillog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MailLog  $mailLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MailLog $mailLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MailLog  $mailLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(MailLog $maillog)
    {
        if (Gate::denies('manage-cms')) {
            return redirect()->route('admin.maillogs.index');
        }

        $maillog->delete();
        return redirect()->route('admin.maillogs.index');
    }
}
