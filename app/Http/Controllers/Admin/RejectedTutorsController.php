<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RejectedTutorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            't_name'            => 'nullable|string',
            'email'             => 'nullable|email',
            't_date'            => 'nullable|date',
        ]);

        $q = "1=1 ";

        $q.= " and (status_id is NULL or 0) ";

        if (isset($request_data['t_name'])) {
            $q.= " and (fname like '%".$request_data['t_name']."%' or lname like '%" .$request_data['t_name'] . "%') ";
        } else $request_data['t_name'] = "";

        if (isset($request_data['t_date'])) {
            $q.= " and created_at like '%".$request_data['t_date']."%'";
        } else $request_data['t_date'] = "";

        if (isset($request_data['email'])) {
            $q.= " and email like '%".$email."%'";
        } else $request_data['email'] = "";

        $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()
        ->whereRaw($q)->get();
        
        $data = [
            'tutors'            => $tutors,
            'old'               => $request_data,
        ];

        if( count($tutors) != 0 ) return view('admin.rejectedtutors.index')->with('data', $data);
        
        request()->session()->flash('error', "No search results!");
        return view('admin.rejectedtutors.index')->with('data', $data);
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
    public function edit(User $rejectedtutor)
    {
        if (Gate::denies('manage-tutors')) {
            return redirect(route('admin.rejectedtutors.index'));
        }

        $roles = Role::all();
        return view('admin.rejectedtutors.edit')->with('tutor', $rejectedtutor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $rejectedtutor)
    {
        $validator = Validator::make($request->all(), [
            'email'             => ['required', 'email','unique:users'],
            'fname'             => ['required', 'string'],
            'lname'             => ['required', 'string'],
            'home_phone'        => ['required', 'string'],
            'cell_phone'        => ['required', 'string'],
            'password'          => ['required', 'string', 'min:1', 'confirmed'],
            'address'           => ['required', 'string'],
            'city'              => ['required', 'string'],
            'state_id'          => ['required', 'integer'],
            'pcode'             => ['required', 'string'],
            'country_id'        => ['required', 'integer'],
            'other_notes'       => ['required', 'string'],
            'post_secondary_edu'=> ['required', 'string'],
            'area_of_concentration'=> ['required', 'string'],
            'tutoring_courses'  => ['required', 'string'],
            'sex_val'           => ['required', 'string'],
            'certified'         => ['required', 'string'],
            'cr_radio'          => ['required', 'string'],
            'cc_radio'          => ['required', 'string'],
            'approved'          => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.rejectedtutors.edit', $rejectedtutor);
        }

        $data = $request->all();
        $rejectedtutor->email = $data['email'];
        $rejectedtutor->fname = $data['fname'];
        $rejectedtutor->lname = $data['lname'];
        $rejectedtutor->home_phone = $data['home_phone'];
        $rejectedtutor->cell_phone = $data['cell_phone'];
        $rejectedtutor->password = $data['password'];
        $rejectedtutor->address = $data['address'];
        $rejectedtutor->city = $data['city'];
        $rejectedtutor->state_id = $data['state_id'];
        $rejectedtutor->pcode = $data['pcode'];
        $rejectedtutor->country_id = $data['country_id'];
        $rejectedtutor->other_notes = $data['other_notes'];
        $rejectedtutor->post_secondary_edu = $data['post_secondary_edu'];
        $rejectedtutor->area_of_concentration = $data['area_of_concentration'];
        $rejectedtutor->tutoring_courses = $data['tutoring_courses'];
        $rejectedtutor->work_experience = $data['work_experience'];
        $rejectedtutor->tutoring_areas = $data['tutoring_areas'];
        $rejectedtutor->gender = $data['sex_val'];
        $rejectedtutor->certified_teacher = $data['certified'];
        $rejectedtutor->criminal_record = $data['cr_radio'];
        $rejectedtutor->criminal_check = $data['cc_radio'];
        $rejectedtutor->approved = $data['approved'];

        if($rejectedtutor->save()){
            $request->session()->flash('success', 'The tutor has been updated successfully');
            return redirect()->route('admin.rejectedtutors.index');
        }
        
        $request->session()->flash('error', 'There was an error updating the tutor');
        return redirect()->route('admin.rejectedtutors.edit', $rejectedtutor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $rejectedtutor)
    {
        if (Gate::denies('manage-tutors')) {
            
            return redirect(route('admin.rejectedtutors.index'));
        }

        $rejectedtutor->delete();
        return redirect(route('admin.rejectedtutors.index'));    
    }
}
