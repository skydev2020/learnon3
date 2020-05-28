<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Country;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\State;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TutorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $s_data = $this->validate($request, [            
            't_name' => 'nullable|string',
            'email' => 'nullable|string',
            'status' => 'nullable|integer',
            'approved' => 'nullable|integer',
            't_date' => 'nullable|date',
        ]);

        $field = isset($_GET['field']) ? trim($_GET['field']) : "";
        $dir = isset($_GET['dir']) ? trim($_GET['dir']) : "asc";
        
        // $t_name = isset($_GET['t_name']) ? trim($_GET['t_name']) : "";
        // $email = isset($_GET['email']) ? trim($_GET['email']) : "";
        // $status = isset($_GET['status']) ? trim($_GET['status']) : "";
        // $approved = isset($_GET['approved']) ? trim($_GET['approved']) : "";
        // $t_date = isset($_GET['t_date']) ? trim($_GET['t_date']) : "";

        $q = "1=1 ";
        $url = "";

        if (isset($s_data['email'])) {
            $q.= " and email like '%".$s_data['email']."%'";
            $url.= "&email=".$s_data['email'];
        }
        else {
            $s_data['email'] = "";
        }

        if (isset($s_data['status'])) {        
            $q.= " and status like ".$s_data['status'];
            $url.= "&status=".$s_data['status'];
        }
        else {
            $s_data['status'] = "";
        }

        if (isset($s_data['approved'])) {
            $q.= " and approved like ".$s_data['approved'];
            $url.= "&approved=".$s_data['approved'];
        }
        else {
            $s_data['approved'] = "";
        }

        if (isset($s_data['t_date'])) {
            $q.= " and created_at like '%".$s_data['t_date']."%'";
            $url.= "&t_date=".$s_data['t_date'];
        }
        else {
            $s_data['t_date'] = "";
        }

        if (isset($s_data['t_name'])) {        
            $q.= " and (fname like '%".$s_data['t_name']."%' or lname like '%" .$s_data['t_name'] . "%') ";
            $url.= "&t_name=".$s_data['t_name'];
        }
        else {
            $s_data['t_name'] = "";
        }


        $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()
        ->whereRaw($q);

        if ($field!="") {            
            $tutors = $tutors->orderBy($field, $dir);
        }

        if ($url !="") {
            $url = substr($url, 1);
        }

        //$q = "1=1  and (approved is NULL or 0) and (fname like '%learnon%' or lname like '%learnon%')";
        $tutors = $tutors->get();

        $data = [
            'tutors' => $tutors,
            'search' => $s_data,
            'url'    => $url,
            'order'  => [
                'field' => $field,
                'dir' => $dir
            ]
        ];

        session()->flash('error', null);
        if (count($tutors) == 0) {
            session()->flash('error', "No search results!");
            return view('admin.tutors.index')->with('data', $data);
        }

        return view('admin.tutors.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('manage-tutors')) return redirect()->route('admin.tutor.index');

        $data = [
            'states'    => State::all(),
            'countries' => Country::all()
        ];
        return view('admin.tutors.create')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('manage-tutors')) {
            return redirect(route('admin.tutors.create'));
        }

        $validator = Validator::make($request->all(), [
            'fname'                 => ['required', 'string', 'max:255'],
            'lname'                 => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'home_phone'            => ['nullable', 'string'],
            'cell_phone'            => ['nullable', 'string'],
            'address'               => ['required', 'string'],
            'city'                  => ['required', 'string'],
            'state_id'              => ['required', 'integer'],
            'pcode'                 => ['required', 'string'],
            'country_id'            => ['required', 'integer'],
            'other_notes'           => ['nullable', 'string'],
            'post_secondary_edu'    => ['required', 'string'],
            'subjects_studied'      => ['required', 'string'],
            'tutoring_courses'      => ['required', 'string'],
            'work_experience'       => ['required', 'string'],
            'tutoring_areas'        => ['required', 'string'],
            'references'            => ['required', 'string'],
            'gender'                => ['nullable', 'string'],
            'certified_teacher'     => ['required', 'string'],
            'criminal_record'       => ['required', 'string'],
            'criminal_check'        => ['required', 'string'],
            'approved'              => ['nullable', 'integer'],
            'status'                => ['nullable', 'integer'],
        ]);
        if ($validator->fails())
        {
            session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.tutors.create');
        }
        $data = $request->all();

        $tutor = User::create([
            'fname'                 => $data['fname'],
            'lname'                 => $data['lname'],
            'email'                 => $data['email'],
            'password'              => Hash::make($data['password']),
            'home_phone'            => $data['home_phone'],
            'cell_phone'            => $data['cell_phone'],
            'address'               => $data['address'],
            'city'                  => $data['city'],
            'state_id'              => $data['state_id'],
            'pcode'                 => $data['pcode'],
            'country_id'            => $data['country_id'],
            'other_notes'           => $data['other_notes'],
            'post_secondary_edu'    => $data['post_secondary_edu'],
            'subjects_studied'      => $data['subjects_studied'],
            'tutoring_courses'      => $data['tutoring_courses'],
            'work_experience'       => $data['work_experience'],
            'tutoring_areas'        => $data['tutoring_areas'],
            'references'            => $data['references'],
            'gender'                => $data['gender'],
            'certified_teacher'     => $data['certified_teacher'],
            'criminal_record'       => $data['criminal_record'],
            'criminal_check'        => $data['criminal_check'],
            'approved'              => $data['approved'],
            'status'                => $data['status'],
        ]);

        if ($tutor == NULL) {
            session()->flash('error', "There is an error creating tutor!");
            return redirect()->route('admin.tutors.create');
        }

        $role = Role::select('id')->where('name', 'Tutor')->first();
        $tutor->roles()->attach($role);
        ActivityLog::log_activity(Auth::user()->id, "Tutor Added", "A new tutor added.");
        session()->flash('success', $tutor->fname . ' ' . $tutor->lname .' has been updated');
        return redirect()->route('admin.tutors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $tutor)
    {
        $data = ['tutor' => $tutor];
        $pdf = PDF::loadView('admin.tutors.contract', $data);
        return $pdf->stream('admin.tutors.contract');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $tutor)
    {
        if (Gate::denies('manage-tutors')) {
            return redirect(route('admin.tutors.index'));
        }

        $data = [
            'tutor'     => $tutor,
            'states'    => State::all(),
            'countries' => Country::all()
        ];
        return view('admin.tutors.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $tutor)
    {
        if (Gate::denies('manage-tutors')) {
            return redirect(route('admin.tutors.edit', $tutor));
        }

        $validator = Validator::make($request->all(), [
            'fname'                 => ['required', 'string', 'max:255'],
            'lname'                 => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email',  'max:255'],
            'password'              => ['nullable', 'string', 'min:8', 'confirmed'],
            'home_phone'            => ['nullable', 'string'],
            'cell_phone'            => ['nullable', 'string'],
            'address'               => ['required', 'string'],
            'city'                  => ['required', 'string'],
            'state_id'              => ['required', 'integer'],
            'pcode'                 => ['required', 'string'],
            'country_id'            => ['required', 'integer'],
            'other_notes'           => ['required', 'string'],
            'post_secondary_edu'    => ['required', 'string'],
            'subjects_studied'      => ['required', 'string'],
            'tutoring_courses'      => ['required', 'string'],
            'work_experience'       => ['required', 'string'],
            'tutoring_areas'        => ['required', 'string'],
            'references'            => ['required', 'string'],
            'gender'                => ['nullable', 'string'],
            'certified_teacher'     => ['required', 'string'],
            'criminal_record'       => ['required', 'string'],
            'criminal_check'        => ['required', 'string'],
            'approved'              => ['nullable', 'integer'],
            'status'                => ['nullable', 'integer'],
        ]);        
        if ($validator->fails())
        {
            session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.tutors.edit', $tutor);
        }
        
        $data = $request->all();
        // Check user exists with same email except current user
        $user = User::where('email', '=', $data['email'])->first();
        if ($user && $user->id != $tutor->id) {
            session()->flash('error', "User with same email exists");
            return redirect()->route('admin.tutors.edit', $tutor);
        }

        $tutor->fname = $data['fname'];
        $tutor->lname = $data['lname'];
        $tutor->email = $data['email'];
        if ($data['password']) {
            $tutor->password = Hash::make($data['password']);
        }
        $tutor->home_phone = $data['home_phone'];
        $tutor->cell_phone = $data['cell_phone'];
        $tutor->address = $data['address'];
        $tutor->city = $data['city'];
        $tutor->state_id = $data['state_id'];
        $tutor->pcode = $data['pcode'];
        $tutor->country_id = $data['country_id'];
        $tutor->other_notes = $data['other_notes'];
        $tutor->post_secondary_edu = $data['post_secondary_edu'];
        $tutor->subjects_studied = $data['subjects_studied'];
        $tutor->tutoring_courses = $data['tutoring_courses'];
        $tutor->work_experience = $data['work_experience'];
        $tutor->tutoring_areas = $data['tutoring_areas'];
        $tutor->references = $data['references'];
        $tutor->gender = $data['gender'];
        $tutor->certified_teacher = $data['certified_teacher'];
        $tutor->criminal_record = $data['criminal_record'];
        $tutor->criminal_check = $data['criminal_check'];
        $tutor->approved = $data['approved'];
        $tutor->status = $data['status'];

        if ($tutor->save()){
            $request->session()->flash('success', $tutor->fname . ' ' . $tutor->lname .' has been updated');
        } else {
            $request->session()->flash('error', 'There was an error updating the tutor');
            return redirect()->route('admin.tutors.edit', $tutor);
        }

        return redirect()->route('admin.tutors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $tutor)
    {
        if (Gate::denies('manage-tutors')) {
            session()->flash('error', "You don't have enough permission.");
            return redirect()->route('admin.tutors.index');
        }
        
        $tutor->roles()->detach();
        $tutor->delete();
        session()->flash('success', "You have removed tutor!");
        return redirect() -> route('admin.tutors.index');
    }

    /**
     * Remove multiple students from database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function multiDelete(Request $request)
    {
        $data = $request->all();
        
        if (Gate::denies('manage-tutors')) {
            session()->flash('error', "You don't have enough permission.");
            return redirect()->route('admin.tutors.index');
        }
            
		if (isset($data['sids']) && $this->validateMultiDelete()) {
            $sids = $data['sids'];
            $obj_ids = explode(",", $sids);
            
            
            if (count($obj_ids) ==0 ) {
                session()->flash('error', 'Nothing has been selected!');
                return redirect()->route('admin.tutors.index');
            }

			foreach ($obj_ids as $id) {
                $obj = User::find($id);
                
                $obj->roles()->detach();
                $obj->delete();
			}
			            
            session()->flash('success', 'You have deleted tutors!');
            return redirect() -> route('admin.tutors.index');
        }
        session()->flash('error', 'Nothing has been selected or invalid request!');
        return redirect()->route('admin.tutors.index');
    }

    /**
     * Check Multi Delete Permission, not implemented at the moment
     */
    public function validateMultiDelete()
    {
        return true;
    }
}
