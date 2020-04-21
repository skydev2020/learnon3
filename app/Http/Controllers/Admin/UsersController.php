<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('manage-users')) {
            return redirect(route('admin.users.index'));
        }

        $roles = Role::all();
        return view('admin.users.create')->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('manage-users')) return redirect()->route('admin.users.create');

        $data = $request->all();
        $validator = Validator::make($data, [
            'fname'         => ['required', 'string', 'max:255'],
            'lname'         => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'roles'         => ['required', 'array'],
            'approved'      => ['nullable', 'integer'],
            'status'        => ['nullable', 'integer']
        ]);

        if ($validator->fails())
        {
            session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.users.create');
        }

        $user = User::create([
            'fname'                 => $data['fname'],
            'lname'                 => $data['lname'],
            'email'                 => $data['email'],
            'password'              => Hash::make($data['password']),
            'home_phone'            => '',
            'cell_phone'            => '',
            'address'               => '',
            'city'                  => '',
            'state_id'              => 1,
            'pcode'                 => '',
            'country_id'            => 1,
            'grade_id'              => 1,
            'parent_fname'          => '',
            'parent_lname'          => '',
            'school'                => '',
            'referrer_id'           => 1,
            'service_method'        => ''
        ]);

        if ($user == NULL)
        {
            session()->flash('error', "There is an error creating the user!");
            return redirect()->route('admin.users.create');
        }

        foreach ($data['roles'] as $role) {
            $user->roles()->attach($role);
        }
        $user->save();

        session()->flash('success', $user->fname . $user->lname . " has been created successfully");
        return redirect()->route('admin.users.index');
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
        if (Gate::denies('edit-users')) {
            return redirect(route('admin.users.index'));
        }

        $roles = Role::all();
        return view('admin.users.edit')->with([
            'user' => $user,
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
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);

        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;

        if ($user->save()){
            $request->session()->flash('success', $user->fname . ' ' . $user->lname .' has been updated');
        } else {
            $request->session()->flash('error', 'There was an error updating the user');
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        if (Gate::denies('delete-users')) {
            return redirect(route('admin.users.index'));
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
