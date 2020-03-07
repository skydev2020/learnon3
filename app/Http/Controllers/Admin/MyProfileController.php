<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class MyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myUser = Auth::User();
        return view('admin.myprofile.index')->with('myuser', $myUser);
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
    public function update(Request $request, User $myprofile)
    {
        $validator = Validator::make($request->all(), [
            'email'         => ['required', 'string', 'email', 'max:255'],
            'fname'        => ['required', 'string', 'max:255'],
            'lname'         => ['required', 'string', 'max:255'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.myprofile.index');
        }
        
        $data = $request->all();
        $myprofile->email = $data['email'];
        $myprofile->fname = $data['fname'];
        $myprofile->lname = $data['lname'];
        $myprofile->password = Hash::make($data['password']);
 
        if(!$myprofile->save()) {
            $request->session()->flash('error', 'There is an error modifying your account information!');
            return redirect()->route('admin.myprofile.index');
        }

        $request->session()->flash('success', 'You have modified your account information!');
        return redirect()->route('admin.myprofile.index');
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
}
