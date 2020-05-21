<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Assignment;
use App\Role;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Config;

class AssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->validate($request, [
            's_name' => 'nullable|string',
            't_name' => 'nullable|string',
            'a_date' => 'nullable|date',
        ]);
        // $s_name = isset($_GET['s_name']) ? trim($_GET['s_name']) : "";
        // $t_name =  isset($_GET['t_name']) ? trim($_GET['t_name']) : "";
        // $a_id = isset($_GET['a_id']) ? trim($_GET['a_id']) : "";
        // $a_date = isset($_GET['a_date']) ? trim($_GET['a_date']) : "";

        $q = "1=1 ";

        if (isset($data['a_date'])) {
            $q.= " and created_at like '%".$data['a_date']."%'";
        } else $data['a_date'] = "";

        $assignments = Assignment::whereRaw($q);

        if (isset($data['s_name']))
        {
            $assignments = $assignments->whereHas('students', function($student) use ($data) {
                return $student->where('fname', 'like', "%" . $data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $data['s_name'] . "%");
            });
        } else $data['s_name'] = "";

        if (isset($data['t_name']))
        {
            $assignments = $assignments->whereHas('tutors', function($tutor) use ($data) {
                return $tutor->where('fname', 'like', "%" . $data['t_name'] . "%")
                ->orwhere('lname', 'like', "%" . $data['t_name'] . "%");
            });
        } else $data['t_name'] = "";

        $assignments = $assignments->get();

        $data = [
            'assignments'   => $assignments,
            'old'           => $data,
        ];

        if( count($assignments) != 0 )
        {
            return view('admin.assignments.index')->with('data', $data);
        }

        if (count($assignments) == 0) {
            session()->flash('error', "No search results!");
        }

        return view('admin.assignments.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'tutors'    => Role::find(config('global.TUTOR_ROLE_ID'))->users()->get(),
            'students'  => Role::find(config('global.STUDENT_ROLE_ID'))->users()->get(),
            'subjects'  => Subject::all(),
        ];
        return view('admin.assignments.create')->with('data', $data);
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
            'tutor_val'             => ['required', 'integer'],
            'student_val'           => ['required', 'integer'],
            'subjects'              => ['nullable', 'Array'],
            'base_invoice'          => ['required', 'string'],
            'base_wage'             => ['required', 'string'],
            'active'                => ['nullable', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect(route('admin.assignments.create'));
        }

        $data = $request->all();
        $assignment = Assignment::create([
            'tutor_id'              => $data['tutor_val'],
            'student_id'            => $data['student_val'],
            'base_wage'             => $data['base_wage'],
            'base_invoice'          => $data['base_invoice'],
            'active'                => $data['active'],
        ]);

        if ($assignment == NULL)
        {
            session()->flash('error', "There was an error creating the assignment");
            return redirect(route('admin.users.assignments.create'));
        }
        if (isset($data['subjects']))
        {
            foreach ($data['subjects'] as $subject)
            {
                $assignment->attach($subject);
            }
            $assignment->save();
        }
        session() -> flash('success', "The assignment has been created successfully");
        return redirect() -> route('admin.assignments.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignments)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //dd($assignment->id);
        if (Gate::denies('manage-students')) {
            return redirect(route('admin.assignments.index'));
        }
        $data = [
            'assignment'    => $assignment,
            'tutors'        => Role::find(config('global.TUTOR_ROLE_ID'))->users()->get(),
            'students'      => Role::find(config('global.STUDENT_ROLE_ID'))->users()->get(),
            'subjects'      => Subject::all()
        ];
        return view('admin.assignments.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        if (Gate::denies('manage-students')) return redirect()->route('admin.students.index');

        $validator = Validator::make($request->all(), [
            'tutor_val'         => ['required', 'integer'],
            'student_val'       => ['required', 'integer'],
            'base_invoice'      => ['required', 'string'],
            'base_wage'         => ['required', 'string'],
            'subjects'          => ['nullable', 'Array'],
            'active'            => ['nullable', 'integer']
        ]);
        if ($validator->fails())
        {
            session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.assignments.edit', $assignment);
        }

        $assignment->tutor_id = $request->tutor_val;
        $assignment->student_id =$request->student_val;
        $assignment->base_wage = $request->base_wage;
        $assignment->base_invoice = $request->base_invoice;
        $assignment->active = $request->active;
        $assignment->subjects()->sync($request->subjects);

        if (!$assignment->save()){
            $request->session()->flash('error', 'There was an error updating the assignment');
            return redirect()->route('admin.assignments.edit', $assignment);
        }

        $request->session()->flash('success', 'The assignment has been updated successfully');
        return redirect()->route('admin.assignments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        if (Gate::denies('manage-students')) {
            session()->flash('error', "You don't have enough permission.");
            return redirect()->route('admin.assignments.index');
        }
        
        $assignment->delete();
        session() -> flash('success', "Student assignment details has been successfully deleted.");
        return redirect()->route('admin.assignments.index');
    }

    /**
     * Remove multiple objects from database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function multiDelete(Request $request)
    {
        $data = $request->all();
        
        if (Gate::denies('manage-students')) {
            session()->flash('error', "You don't have enough permission.");
            return redirect()->route('admin.assignments.index');
        }       
        
		if (isset($data['sids']) && $this->validateMultiDelete()) {
            $sids = $data['sids'];
            $obj_ids = explode(",", $sids);            
            
            if (count($obj_ids) ==0 ) {
                session()->flash('error', 'Nothing has been selected!');
                return redirect()->route('admin.assignments.index');
            }

			foreach ($obj_ids as $id) {
                $obj = Assignment::find($id);
                $obj->delete();
			}
			            
            session()->flash('success', 'You have deleted student assignments!');		
                       
            return redirect() -> route('admin.assignments.index');
        }

        session()->flash('error', 'Nothing has been selected or invalid request!');
        return redirect()->route('admin.assignments.index');
    }

    /**
     * Check Multi Delete Permission, not implemented at the moment
     */
    public function validateMultiDelete()
    {
        return true;
    }

}
