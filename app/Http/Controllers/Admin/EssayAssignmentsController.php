<?php

namespace App\Http\Controllers\Admin;

use App\EssayAssignment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EssayAssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            'a_id'              => 'nullable|integer',
            's_name'            => 'nullable|string',
            't_name'            => 'nullable|string',
            'topic'             => 'nullable|string',
            'status'            => 'nullable|string',
            'paid_to_tutor'     => 'nullable|decimal',
            'price_owed'        => 'nullable|decimal',
            'a_date_from'       => 'nullable|date',
            'a_date_to'         => 'nullable|date',
            'c_date_from'       => 'nullable|date',
            'c_date_to'         => 'nullable|date',
        ]);

        $q = "1=1 ";

        if (isset($request_data['a_id'])) {
            $q.= " and a_id is " . $request_data['a_id'];
        } else $request_data['a_id'] = "";

        if (isset($request_data['topic'])) {
            $q.= " and topic like '%" . $request_data['topic'] . "%'";
        } else $request_data['topic'] = "";

        if (isset($request_data['status'])) {
            $q.= " and status_id is " . $request_data['status'];
        } else $request_data['status'] = "";

        if (isset($request_data['paid_to_tutor'])) {
            $q.= " and paid is " . $request_data['paid_to_tutor'];
        } else $request_data['paid_to_tutor'] = "";

        if (isset($request_data['price_owed'])) {
            $q.= " and owed is " . $request_data['price_owed'];
        } else $request_data['price_owed'] = "";

        // if (isset($request_data['a_date_from']) && isset($request_data['a_date_to'])) {
        //     $q .= "and date assigned between '" . $request_data['a_date_from'] . "' and '" . $request_data['a_date_to']
        //     . "'";
        // }

        // if (isset($request_data['c_date_from']) && isset($request_data['c_date_to'])) {
        //     $q .= "and date completed between " . $request_data['c_date_from'] . ' and ' . $request_data['c_date_to'];
        // }

        $essay_assignments = EssayAssignment::query()->whereRaw($q);

        if (isset($request_data['s_name']))
        {
            $essay_assignments = $essay_assignments->whereHas('students', function($student) use ($request_data) {
                return $student->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
            });
        } else $request_data['s_name'] = "";

        if (isset($request_data['t_name']))
        {
            $essay_assignments = $essay_assignments->whereHas('tutors', function($tutor) use ($request_data) {
                return $tutor->where('fname', 'like', "%" . $request_data['t_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['t_name'] . "%");
            });
        } else $request_data['t_name'] = "";

        // $essay_assignments = $essay_assignments->where('date_assigned', 'between',
        //  $request_data['a_date_from'], $request_data['a_date_to']);

        if (!isset($request_data['a_date_from'])) $request_data['a_date_from'] = "";
        if (!isset($request_data['a_date_to'])) $request_data['a_date_to'] = "";
        if (!isset($request_data['c_date_from'])) $request_data['c_date_from'] = "";
        if (!isset($request_data['c_date_to'])) $request_data['c_date_to'] = "";
        
        //$essay_assignments = $essay_assignments->has('students')->orhas('tutors');
        $essay_assignments = $essay_assignments->get();
        $data = [
            'essay_assignments' => $essay_assignments,
            'old'               => $request_data,
        ];

        if( count($essay_assignments) != 0 )
        {
            return view('admin.essayassignments.index')->with('data', $data);
        }
        
        request()->session()->flash('error', null);
        if (count($essay_assignments) == 0) {
            request()->session()->flash('error', "No search results!");
        }

        return view('admin.essayassignments.index')->with('data', $data);
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
     * @param  \App\EssayAssignment  $essay_Assignment
     * @return \Illuminate\Http\Response
     */
    public function show(EssayAssignment $essay_Assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EssayAssignment  $essay_Assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(EssayAssignment $essay_Assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Essay_Assignment  $essay_Assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EssayAssignment $essay_Assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Essay_Assignment  $essay_Assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(EssayAssignment $essay_Assignment)
    {
        //
    }
}
