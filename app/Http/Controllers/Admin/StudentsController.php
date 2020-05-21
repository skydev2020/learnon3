<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Country;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\StudentStatus;
use App\Grade;
use App\Referrer;
use App\State;
use Illuminate\Http\Request;
use Config;
use App\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PDF;
/**
 * StudentsController is working with Students
 * Student is a User whose Role is Student
 */

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource of ROLE_STUDEN
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $s_name = isset($_GET['s_name']) ? trim($_GET['s_name']) : "";
        $s_city =  isset($_GET['s_city']) ? trim($_GET['s_city']) : "";
        $s_date = isset($_GET['s_date']) ? trim($_GET['s_date']) : "";
        $s_sub = isset($_GET['s_sub']) ? trim($_GET['s_sub']) : "";
        $s_status_id = isset($_GET['s_status_id']) ? trim($_GET['s_status_id']) : "";
        $field = isset($_GET['field']) ? trim($_GET['field']) : "";
        $dir = isset($_GET['dir']) ? trim($_GET['dir']) : "asc";

        $q = "1=1 ";
        $url = "";
        
        if ($field!="") {
            // $url = "?field=".$field."&dir=".$dir;
        }

        if ($s_city) {
            $q.= " and city like '%".$s_city."%'";
            $url.= "&s_city=".$s_city;
        }

        if ($s_date) {
            $q.= " and created_at like '%".$s_date."%'";
            $url.= "&s_date=".$s_date;
        }

        $q.= " and grade_id >= '1'";

        if ($s_status_id) {
            $q.= " and student_status_id like '%".$s_status_id."%'";
            $url.= "&s_status_id=".$s_status_id;
        }

        if ($s_name) {
            $q.= " and (fname like '%".$s_name."%' or lname like '%" .$s_name . "%') ";
            $url.= "&s_name=".$s_name;
        }
        
        
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()
        ->whereRaw($q);

        if ($field!="") {
            // $q.= " order by ".$field." ".$dir;
            $students = $students->orderBy($field, $dir);
        }
        
        if ($s_sub) {
            $url.= "&s_sub=".$s_sub;
            $students = $students->whereHas('subjects', function($subject) use ($s_sub) {
                return $subject->where('name', 'like', "%" . $s_sub . "%");
            });
        }
        
        if ($url !="") {
            $url = substr($url, 1);
        }
        
        $students = $students->get();        
        $student_statuses = StudentStatus::all();
        $subjects = Subject::all();
        $data = [
            'students'          => $students,
            'student_statuses'  => $student_statuses,
            'subjects'          => $subjects,
            'url'               => $url,
            'order'  => [
                'field' => $field,
                'dir' => $dir
            ],
            'old' => [
                's_name' => $s_name,
                's_city' => $s_city,
                's_date' => $s_date,
                's_sub' => $s_sub,
                's_status_id' => $s_status_id,
                ]
        ];

        // session()->flash('error', null);
        if (count($students) == 0) {
            session()->flash('error', "No search results!");
        }

        return view('admin.students.index')->with('data', $data);
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
        $referrers = Referrer::all();
        $student_statuses = StudentStatus::all();

        return view('admin.students.create', compact('grades', 'states', 'countries', 'grades_array', 'referrers'
        , 'student_statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all()['service_method']);
        $validator = Validator::make($request->all(), [
            'fname'                 => ['required', 'string', 'max:255'],
            'lname'                 => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'grade_id'              => ['required', 'integer'],
            'subjects'              => ['required', 'Array'],
            'home_phone'            => ['required', 'string'],
            'cell_phone'            => ['nullable', 'string'],
            'address'               => ['required', 'string'],
            'city'                  => ['required', 'string'],
            'state_id'              => ['required', 'integer'],
            'pcode'                 => ['required', 'string'],
            'country_id'            => ['required', 'integer'],
            'parent_fname'          => ['required', 'string'],
            'parent_lname'          => ['required', 'string'],
            'service_method'        => ['required', 'string'],
            'other_notes'           => ['nullable', 'string'],
            'school'                => ['required', 'string'],
            'major_intersection'    => ['required', 'string'],
            'referrer_id'           => ['nullable', 'integer'],
            'student_status_id'     => ['nullable', 'integer'],
            'approved'              => ['nullable', 'integer'],
            'status'                => ['nullable', 'integer'],
        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator -> messages() -> first());
            return redirect()->route('admin.students.create');
        }
        $data = $request->all();
        $student = User::create([
            'fname'                 => $data['fname'],
            'lname'                 => $data['lname'],
            'username'                 => $data['email'],
            'email'                 => $data['email'],
            'password'              => Hash::make($data['password']),
            'grade_id'              => $data['grade_id'],
            'home_phone'            => $data['home_phone'],
            'cell_phone'            => $data['cell_phone'],
            'address'               => $data['address'],
            'city'                  => $data['city'],
            'state_id'              => $data['state_id'],
            'pcode'                 => $data['fname'],
            'country_id'            => $data['country_id'],
            'parent_fname'          => $data['parent_fname'],
            'parent_lname'          => $data['parent_lname'],
            'service_method'        => $data['service_method'],
            'other_notes'           => $data['other_notes'],
            'school'                => $data['school'],
            'major_intersection'    => $data['major_intersection'],
            'referrer_id'           => $data['referrer_id'],
            'student_status_id'     => $data['student_status_id'],
            'approved'              => $data['approved'],
            'status'                => $data['status'],
            'user_group_id'         => 0
        ]);
        if ($student == NULL)
        {
            session()->flash('error', "There is an error modifying student!");
            return redirect()->route('admin.students.create');
        }

        $role = Role::select('id')->where('name', 'Student')->first();
        $student->roles()->attach($role);
        foreach($data['subjects'] as $subject)
        {
            $student -> subjects() -> attach($subject);
        }
        $student -> save();
        ActivityLog::log_activity(Auth::user()->id, "Student Added", "A new student added.");
        session()->flash('success', "You have created student!");
        return redirect()->route('admin.students.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $student)
    {
        $data = [
            'student'           => $student,
            'referrers'         => Referrer::all(),
            'student_statuses'  => StudentStatus::all()
        ];
        return view('admin.students.show')->with(['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $student)
    {
        $states = State::all();
        $countries = Country::all();
        $grades = Grade::with('subjects')->get();
        $grades_array = $grades->toArray();
        $referrers = Referrer::all();
        $student_statuses = StudentStatus::all();

        return view('admin.students.edit', compact('grades', 'states', 'countries', 'grades_array', 'referrers'
        , 'student_statuses', 'student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $student)
    {
        $validator = Validator::make($request->all(), [
            'fname'                 => ['required', 'string', 'max:255'],
            'lname'                 => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255'],
            'password'              => ['nullable', 'string', 'min:8', 'confirmed'],
            'grade_id'              => ['required', 'integer'],
            'subjects'              => ['required', 'Array'],
            'home_phone'            => ['required', 'string'],
            'cell_phone'            => ['nullable', 'string'],
            'address'               => ['required', 'string'],
            'city'                  => ['required', 'string'],
            'state_id'              => ['required', 'integer'],
            'pcode'                 => ['required', 'string'],
            'country_id'            => ['required', 'integer'],
            'parent_fname'          => ['required', 'string'],
            'parent_lname'          => ['required', 'string'],
            'service_method'        => ['required', 'string'],
            'other_notes'           => ['nullable', 'string'],
            'school'                => ['required', 'string'],
            'major_intersection'    => ['required', 'string'],
            'referrer_id'           => ['nullable', 'integer'],
            'student_status_id'     => ['nullable', 'integer'],
            'approved'              => ['nullable', 'integer'],
            'status'                => ['nullable', 'integer'],
        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator -> messages() -> first());
            return redirect()->route('admin.students.edit', $student);
        }
        $data = $request->all();
        $student-> email = $data['email'];
        if ($data['password']) {
            $student-> password = Hash::make($data['password']);
        }        
        $student-> fname = $data['fname'];
        $student-> lname = $data['lname'];
        $student-> grade_id = $data['grade_id'];
        $student-> parent_fname = $data['parent_fname'];
        $student-> parent_lname = $data['parent_lname'];
        $student-> home_phone = $data['home_phone'];
        $student-> cell_phone = $data['cell_phone'];
        $student-> address = $data['address'];
        $student-> city = $data['city'];
        $student-> state_id = $data['state_id'];
        $student-> pcode = $data['pcode'];
        $student-> country_id = $data['country_id'];
        $student-> service_method = $data['service_method'];
        $student-> other_notes = $data['other_notes'];
        $student-> major_intersection = $data['major_intersection'];
        $student-> school = $data['school'];
        $student-> referrer_id = $data['referrer_id'];
        $student-> student_status_id = $data['student_status_id'];
        $student-> approved = $data['approved'];
        $student-> status = $data['status'];

        $student-> subjects() -> sync($data['subjects']);
        if (!$student->save())
        {
            session()->flash('error', "There is an error modifying student!");
            return redirect()->route('admin.students.edit', $student);
        }
        ActivityLog::log_activity(Auth::user()->id, "Profile Updated", "Student profile details updated.");
        session()->flash('success', "You have modified student!");
        return redirect()->route('admin.students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $student)
    {
        if (Gate::denies('manage-students')) {
            session()->flash('error', "You don't have enough permission.");
            return redirect()->route('admin.students.index');
        }

        $student->subjects()->detach();
        $student->roles()->detach();
        $student->delete();
        session()->flash('success', "You have removed student!");
        return redirect() -> route('admin.students.index');
    }

     /**
     * Manage Invoices
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function manageInvoices(User $student)
    {
        $data = [
            'invoices'   => $student->invoices()->get(),
            'old'        => [
                'invoice_num'       => "",
                's_name'            => "",
                'date_added'        => "",
                'status'            => ""
            ]
        ];

       if( count($student->invoices()->get()) == 0 ) session()->flash('error', "No search results!");

        return view('admin.invoices.index')->with('data', $data);

    }

     /**
     * Show Contract
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showContract(User $student)
    {
        $data = [
            'student' => $student
        ];

        $pdf = PDF::loadView('admin.students.contract', $data);
        return $pdf->stream('admin.students.contract');
    }

    public function export(Request $request, User $student)
    {
        dd($request['names']);
    }

    /**
     * Remove multiple students from database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function multiDelete(Request $request)
    {
        $data = $request->all();
        
        if (Gate::denies('manage-students')) {
            session()->flash('error', "You don't have enough permission.");
            return redirect()->route('admin.students.index');
        }
            
		if (isset($data['sids']) && $this->validateMultiDelete()) {
            $sids = $data['sids'];
            $obj_ids = explode(",", $sids);
            
            
            if (count($obj_ids) ==0 ) {
                session()->flash('error', 'Nothing has been selected!');
                return redirect()->route('admin.students.index');
            }

			foreach ($obj_ids as $id) {
                $obj = User::find($id);

                $obj->subjects()->detach();
                $obj->roles()->detach();
                $obj->delete();
			}
			            
            session()->flash('success', 'You have deleted students!');
			// $url = '';
			
			// if (isset($this->request->get['page'])) {
			// 	$url .= '&page=' . $this->request->get['page'];
			// }
			// if (isset($this->request->get['sort'])) {
			// 	$url .= '&sort=' . $this->request->get['sort'];
			// }
			// if (isset($this->request->get['order'])) {
			// 	$url .= '&order=' . $this->request->get['order'];
			// }
			
            // $this->redirect(HTTPS_SERVER . 'index.php?route=cms/notifications&token=' . $this->session->data['token'] . $url);
                       
            return redirect() -> route('admin.students.index');
        }
        session()->flash('error', 'Nothing has been selected or invalid request!');
        return redirect()->route('admin.students.index');
    }

    /**
     * Check Multi Delete Permission, not implemented at the moment
     */
    public function validateMultiDelete()
    {
        return true;
    }
}