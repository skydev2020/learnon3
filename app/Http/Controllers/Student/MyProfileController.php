<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\User;
use App\State;
use App\Country;
use App\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myuser = Auth::User();
        $states = State::all();
        $countries = Country::all();
        $grades = Grade::with('subjects')->get();
        $grades_array = $grades->toArray();

        return view('students.myprofile.index', compact('grades', 'states', 'countries', 'grades_array', 'myuser'));
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
            'fname'                 => ['required', 'string', 'max:255'],
            'lname'                 => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'home_phone'            => ['required', 'string'],
            'cell_phone'            => ['required', 'string'],
            'address'               => ['required', 'string'],
            'city'                  => ['required', 'string'],
            'state_id'              => ['required', 'integer'],
            'pcode'                 => ['required', 'string'],
            'country_id'            => ['required', 'integer'],
            'grade_id'              => ['required', 'integer'],
            'subjects'              => ['required'],
            'parent_fname'          => ['required', 'string'],
            'parent_lname'          => ['required', 'string'],
            'other_notes'           => ['required', 'string'],
            'school'                => ['required', 'string'],
            'major_intersection'    => ['required', 'string']
        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator -> messages() -> first());
            return redirect()->route('student.myprofile.index');
        }
        $data = $request->all();
        $myprofile-> email = $data['email'];
        $myprofile-> password = Hash::make($data['password']);
        $myprofile-> fname = $data['fname'];
        $myprofile-> lname = $data['lname'];
        $myprofile-> grade_id = $data['grade_id'];
        $myprofile-> parent_fname = $data['parent_fname'];
        $myprofile-> parent_lname = $data['parent_lname'];
        $myprofile-> home_phone = $data['home_phone'];
        $myprofile-> cell_phone = $data['cell_phone'];
        $myprofile-> address = $data['address'];
        $myprofile-> city = $data['city'];
        $myprofile-> state_id = $data['state_id'];
        $myprofile-> pcode = $data['pcode'];
        $myprofile-> country_id = $data['country_id'];
        $myprofile-> other_notes = $data['other_notes'];
        foreach ($data['subjects'] as $subject) {
            $myprofile -> subjects() -> attach($subject);
        }

        if (!$myprofile->save())
        {
            session()->flash('error', "There is an error modifying student!");
        }
        session()->flash('success', "You have modified student!");
        return redirect()->route('student.myprofile.index');
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
