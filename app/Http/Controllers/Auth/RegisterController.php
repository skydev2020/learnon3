<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Role;
use App\Country;
use App\State;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:1', 'confirmed'],
            'home_phone' => ['required', 'string'],
            'cell_phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state_id' => ['required', 'integer'],
            'pcode' => ['required', 'string'],
            'country_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            session()->flash('error', $validator->messages()->first());
        }

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'fname' => $data['first_name'],
            'lname' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'home_phone' => $data['home_phone'],
            'cell_phone' => $data['cell_phone'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state_id' =>  $data['state_id'],
            'pcode' => $data['pcode'],
            'country_id' => $data['country_id'],
        ]);
        // echo($data['state_id']);
        // dd($data['country_id']);

        if ($user == NULL)
        {
            session()->flash('error', "There was an error registering your account");
            return null;
        }

        $role = Role::select('id')->where('name', 'Student')->first();
        $user->roles()->attach($role);

        session()->flash('success', $user->fname . $user->lname . " has been registered successfully");

        return $user;
    }


}
