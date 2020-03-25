<?php

namespace App\Http\Controllers\Student;

use App\Country;
use App\Grade;
use App\Http\Controllers\Controller;
use App\State;
use App\StudentStatus;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $children = Auth::User()->children() -> get();
        return view('students.children.index')->with('children', $children);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::all();
        $countries = Country::all();
        $grades = Grade::with('subjects')->get();
        $grades_array = $grades->toArray();
        $statuses = StudentStatus::all();

        return view('students.children.create', compact('grades', 'states', 'countries', 'grades_array', 'statuses'));
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
            'fname'                 => ['required', 'string', 'max:255'],
            'lname'                 => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'unique:users', 'email', 'max:255'],
            'status'                => ['required', 'integer'],
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
            return redirect()->route('student.children.create');
        }
        
        $data = $request->all();
        $user = User::create([
            'fname'                 => $data['fname'],
            'lname'                 => $data['lname'],
            'email'                 => $data['email'],
            'student_status_id'     => $data['status'],
            'home_phone'            => $data['home_phone'],
            'cell_phone'            => $data['cell_phone'],
            'address'               => $data['address'],
            'city'                  => $data['city'],
            'state_id'              => $data['state_id'],
            'pcode'                 => $data['pcode'],
            'country_id'            => $data['country_id'],
            'grade_id'              => $data['grade_id'],
            'parent_fname'          => $data['parent_fname'],
            'parent_lname'          => $data['parent_lname'],
            'other_notes'           => $data['other_notes'],
            'school'                => $data['school'],
            'major_intersection'    => $data['major_intersection'],
            'parent_id'             => Auth::user()->id,
            'approved'              => 1,
            'status_id'             => 1
        ]);
        foreach ($data['subjects'] as $subject) {
            $user -> subjects() -> attach($subject);
        }

        if ($user == NULL)
        {
             session() -> flash('error', "There is an error adding a children!");
             return redirect() -> route('student.children.create');
        }

        session() -> flash('success', "You have added a Children!");
        return redirect() -> route('student.children.index');
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
}
