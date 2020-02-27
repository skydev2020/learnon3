<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
    public function show(User $tutor)
    {
        return view('admin.tutors.contract')->with([
            'tutor' => $tutor
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $tutor)
    {
        if (Gate::denies('edit-users')) {
            return redirect(route('admin.tutors.index'));
        }

        $roles = Role::all();
        return view('admin.tutors.edit')->with([
            'tutor' => $tutor,
            'roles' => $roles
        ]);
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
        $tutor->roles()->sync($request->roles);

        $tutor->fname = $request->fname;
        $tutor->lname = $request->lname;
        $tutor->email = $request->email;
        if ($request->approved) $tutor->approved = $request->approved;
        if ($request->status) $tutor->status = $request->status;
        if ($tutor->save()){
            $request->session()->flash('success', $tutor->fname . ' ' . $tutor->lname .' has been updated');
        } else {
            $request->session()->flash('error', 'There was an error updating the tutor');
        }
        
        //dd($user->fname);
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
