<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\State;
use PDF;
use Illuminate\Http\Request;
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
    public function index()
    {
        $t_name = isset($_GET['t_name']) ? trim($_GET['t_name']) : "";
        $email = isset($_GET['email']) ? trim($_GET['email']) : "";
        $status = isset($_GET['status']) ? trim($_GET['status']) : "";
        $approved = isset($_GET['approved']) ? trim($_GET['approved']) : "";
        $t_date = isset($_GET['t_date']) ? trim($_GET['t_date']) : "";

        $q = "1=1 ";

        if ($email) {
            $q.= " and email like '%".$email."%'";
        }

        if ($status) {
            if ($status == "Enabled")
                $q.= " and status like 1";
            else
            {
                $q.= " and (status is NULL or 0)";
            }
        }

        if ($approved) {
            if ($approved == "Yes")
                $q.= " and approved like 1";
            else
                $q.= " and (approved is NULL or 0)";
        }

        if ($t_date) {
            $q.= " and created_at like '%".$t_date."%'";
        }

        if ($t_name) {
            $q.= " and (fname like '%".$t_name."%' or lname like '%" .$t_name . "%') ";
        }


        //$q = "1=1  and (approved is NULL or 0) and (fname like '%learnon%' or lname like '%learnon%')";
        $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()
        ->whereRaw($q)->get();

        $data = [
            'tutors' => $tutors,
            'old' => [
                't_name' => $t_name,
                'email' => $email,
                'status' => $status,
                'approved' => $approved,
                't_date' => $t_date,
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
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'              => ['required', 'string', 'min:1', 'confirmed'],
            'home_phone'            => ['required', 'string'],
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

        if ($tutor != NULL){
            $request->session()->flash('success', $tutor->fname . ' ' . $tutor->lname .' has been updated');
        } else {
            $request->session()->flash('error', 'There was an error updating the tutor');
            return redirect()->route('admin.tutors.create');
        }

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
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'              => ['required', 'string', 'min:1', 'confirmed'],
            'home_phone'            => ['required', 'string'],
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

        $tutor->fname = $data['fname'];
        $tutor->lname = $data['lname'];
        $tutor->email = $data['email'];
        $tutor->password = Hash::make($data['password']);
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
    public function destroy(User $user)
    {
        //
    }
}
