<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutoringStatusesController extends Controller
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function onlinetutoring()
    {
        $user = Auth::user();
        $user->service_method = "Online";
        if (!$user->save()) session()->flash('error', "There is an error changing Service Method!");
        else session()->flash('success', "Your Tutoring has changed to Online Video Tutoring!");
        return view('home');
    }

    public function psersontutoring()
    {
        $user = Auth::user();
        $user->service_method = "Home";
        if (!$user->save()) session()->flash('error', "There is an error changing Service Method!");
        else session()->flash('success', "Your Tutoring has changed to In Person Tutoring!");
        return view('home');
    }

    public function both()
    {
        $user = Auth::user();
        $user->service_method = "Both";
        if (!$user->save()) session()->flash('error', "There is an error changing Service Method!");
        else session()->flash('success', "Your Tutoring has changed to Mix of Online and In Person Tutoring!");
        return view('home');
    }

    public function stopTutoring()
    {
        $user = Auth::user();
        $user->student_status_id = 2;
        if (!$user->save()) session()->flash('error', "There is an error changing your tutoring status!");
        else session()->flash('success', "Your tutoring status has been changed to Stop Tutoring!");
        return view('home');
    }

    public function resumeTutoring()
    {
        $user = Auth::user();
        $user->student_status_id = 2;
        if (!$user->save()) session()->flash('error', "There is an error changing your tutoring status!");
        else session()->flash('success', "Your tutoring status has been changed to Resume Tutoring!");
        return view('home');
    }

    public function changeTutor()
    {
        $user = Auth::user();
        $user->student_status_id = 2;
        if (!$user->save()) session()->flash('error', "There is an error changing your tutoring status!");
        else session()->flash('success', "Your tutoring status has been changed to Change Tutor!");
        return view('home');
    }

    public function startNewTutoring()
    {
        $user = Auth::user();
        $user->student_status_id = 2;
        if (!$user->save()) session()->flash('error', "There is an error changing your tutoring status!");
        else session()->flash('success', "Your tutoring status has been changed to Start New Tutoring!");
        return view('home');
    }
}
