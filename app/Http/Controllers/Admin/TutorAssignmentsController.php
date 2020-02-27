<?php

namespace App\Http\Controllers\Admin;

use App\Assignment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Rate;
use App\Role;
use Config;
use App\User;

class TutorAssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            's_name' => 'nullable|string',
            't_name' => 'nullable|string',
            'a_date' => 'nullable|date',
        ]);

        $q = "1=1 ";

        if (isset($request_data['a_date'])) {
            $q.= " and created_at like '%".$request_data['a_date']."%'";
        }
        else $request_data['a_date'] = "";

        $assignments = Assignment::query()->whereRaw($q);

        if (isset($request_data['s_name']))
        {
            $assignments = $assignments->whereHas('students', function($student) use ($request_data) {
                return $student->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
            });
        }
        else $request_data['s_name'] = "";

        if (isset($request_data['t_name']))
        {
            $assignments = $assignments->whereHas('tutors', function($tutor) use ($request_data) {
                return $tutor->where('fname', 'like', "%" . $request_data['t_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['t_name'] . "%");
            });
        }
        else $request_data['t_name'] = "";

        $assignments = $assignments->get();
        $data = [
            'assignments'   => $assignments,
            'old'           => [
                't_name'    => $request_data['t_name'],
                's_name'    => $request_data['s_name'],
                'a_date'    => $request_data['a_date'],
            ]
        ];
        //dd($datas['old']['t_name']);

        if( count($assignments) != 0 )
        {
            return view('admin.tutorassignments.index')->with('data', $data);
        }
        
        request()->session()->flash('error', null);
        if (count($assignments) == 0) {
            request()->session()->flash('error', "No search results!");
        }

//     $assignmentIDs = Assignment::where('name', 'like' "%" . $name . "%")->get(['id'])->pluck('id')->toArray();
//      $assignments = Assignment::whereNotIn('id', $assignmentIDs)->get();

        return view('admin.tutorassignments.index')->with('data', $data);
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
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $tutorassignment)
    {
        if (Gate::denies('edit-users')) {
            return redirect(route('admin.tutorassignments.index'));
        }

        $tutors = Role::find(config('global.TUTOR_ROLE_ID'))->users()->get();
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        $rates = Rate::all();
        $data = [
            'assignment'    => $tutorassignment,
            'tutors'        => $tutors,
            'students'      => $students,
            'rates'         => $rates,
        ];
        return view('admin.tutorassignments.edit')->with(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $tutorassignment)
    {
        $tutorassignment->tutor_id = $request->tutor_val;
        $tutorassignment->student_id =$request->student_val;
        $tutorassignment->subjects = $request->subject_value;
        $tutorassignment->base_wage = $request->tpay_value;
        $tutorassignment->base_invoice = $request->spay_value;
        $tutorassignment->final_status = $request->status;

        if ($tutorassignment->save()){
            $request->session()->flash('success', 'The assignment has been updated successfully');
        } else {
            $request->session()->flash('error', 'There was an error updating the assignment');
        }

        $assignments = Assignment::all();
        $data = [
            'assignments'   => $assignments
        ];
        return redirect()->route('admin.tutorassignments.index')->with('data', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $tutorassignment)
    {


        if (Gate::denies('delete-users')) {
            $assignments = Assignment::all();
            $data = [
                'assignments' => $assignments,
            ];
            return redirect(route('admin.tutorassignments.index'))->with('data', $data);
        }

        $tutorassignment->delete();
        $assignments = Assignment::all();
        $data = [
            'assignments' => $assignments,
        ];

        return redirect()->route('admin.tutorassignments.index')->with('data', $data);
    }
}
