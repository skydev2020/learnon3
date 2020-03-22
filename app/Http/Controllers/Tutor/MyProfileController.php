<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\User;
use App\State;
use App\Country;
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
        $states = State::all();
        $countries = Country::all();
        $data = [
            'myuser'    => $myUser,
            'states'    => $states,
            'countries' => $countries
        ];
        return view('tutor.myprofile.index')->with('data', $data);
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
        //dd("aaa");
        
        $validator = Validator::make($request->all(), [
            'fname'             => ['required', 'string', 'max:255'],
            'lname'             => ['required', 'string', 'max:255'],
            'home_phone'        => ['required', 'string', 'max:255'],
            'cell_phone'        => ['required', 'string', 'max:255'],
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
            'address'           => ['required', 'string', 'max:255'],
            'city'              => ['required', 'string', 'max:255'],
            'state_id'          => ['required', 'integer'],
            'pcode'             => ['required', 'string', 'max:255'],
            'country_id'        => ['required', 'integer'],
            'email'             => ['required', 'string', 'email', 'max:255'],
            'other_notes'       => ['required', 'string', 'max:255'],
            'post_secondary_edu'=> ['required', 'string', 'max:255'],
            'subjects_studied'  => ['required', 'string', 'max:255'],
            'tutoring_courses'  => ['required', 'string', 'max:255'],
            'work_experience'   => ['required', 'string', 'max:255'],
            'tutoring_areas'    => ['required', 'string', 'max:255'],
            'gender'            => ['required', 'string', 'max:255'],
            'certified'         => ['required', 'string', 'max:255'],
            'cr_radio'          => ['required', 'string', 'max:255'],
            'cc_radio'          => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('tutor.myprofile.index');
        }
        
        $data = $request->all();
        $myprofile->fname = $data['fname'];
        $myprofile->lname = $data['lname'];
        $myprofile->home_phone = $data['home_phone'];
        $myprofile->cell_phone = $data['cell_phone'];
        $myprofile->address = $data['address'];
        $myprofile->city = $data['city'];
        $myprofile->state_id = $data['state_id'];
        $myprofile->pcode = $data['pcode'];
        $myprofile->country_id = $data['country_id'];
        $myprofile->email = $data['email'];
        $myprofile->other_notes = $data['other_notes'];
        $myprofile->post_secondary_edu = $data['post_secondary_edu'];
        $myprofile->subjects_studied = $data['subjects_studied'];
        $myprofile->tutoring_courses = $data['tutoring_courses'];
        $myprofile->work_experience = $data['work_experience'];
        $myprofile->tutoring_areas = $data['tutoring_areas'];
        $myprofile->gender = $data['gender'];
        $myprofile->certified_teacher = $data['certified'];
        $myprofile->criminal_record = $data['cr_radio'];
        $myprofile->criminal_check = $data['cc_radio'];
        $myprofile ->password = Hash::make($data['password']);
 
        if(!$myprofile->save()) {
            $request->session()->flash('error', 'There is an error modifying your account information!');
            return redirect()->route('tutor.myprofile.index');
        }

        $request->session()->flash('success', 'You have modified your account information!');
        return redirect()->route('tutor.myprofile.index');
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
