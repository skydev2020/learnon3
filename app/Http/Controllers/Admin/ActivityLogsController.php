<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class ActivityLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activitylogs = ActivityLog::has('users')->get();
        return view('admin.activitylogs.index')
        ->with('activitylogs', $activitylogs);
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
     * @param  \App\ActivityLog  $activityLog
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityLog $activitylog)
    {
        return view('admin.activitylogs.show')->with('activitylog', $activitylog);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ActivityLog  $activityLog
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityLog $activitylog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ActivityLog  $activityLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivityLog $activityLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ActivityLog  $activityLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityLog $activitylog)
    {
        if (Gate::denies('manage-cms')) {
            return redirect()->route('admin.activitylogs.index');
        }

        $activitylog->delete();
        return redirect()->route('admin.activitylogs.index');
    }
}
