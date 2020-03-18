<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Setting;
use App\Mail\SendMail;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function index()
    {
        $users = User::all();
        $administrator =  Role::find(config('global.ADMIN_ROLE_ID'))->users()->first();
        $tutors =  Role::find(config('global.TUTOR_ROLE_ID')) -> users() -> get();
        $students =  Role::find(config('global.STUDENT_ROLE_ID')) -> users() -> get();

        $data = [
            'users'         => $users,
            'administrator' => $administrator,
            'tutors'        => $tutors,
            'students'      => $students
        ];
        return view('admin.notification.index') -> with('data', $data);
    }

    public function show(Request $request)
    {
        if (Gate::denies('manage-cms')) {
            return redirect()->route('admin.notification.index');
        }

        $validator = Validator::make($request->all(), [
            'receivers' => ['required', 'integer'],
            'subject'   => ['required', 'string', 'min:3', 'max:128'],
            'message'   => ['required', 'string'],
        ]);

        // dd (Setting::where('key', 'config_email')->first()['value']);
        $data = $request -> all();
        $users = User::all();
        $administrator =  Role::find(config('global.ADMIN_ROLE_ID'))->users()->first();
        $tutors =  Role::find(config('global.TUTOR_ROLE_ID')) -> users() -> get();
        $students =  Role::find(config('global.STUDENT_ROLE_ID')) -> users() -> get();

        $mail_data = [
            'subject'   => $data['subject'],
            'message'   => $data['message'],
        ];
        //dd($mail_data['message']);


        switch($data['receivers'])
        {
            case 1: //All Users
                $users = User::all();
                foreach ($users as $user)
                {
                    Mail::to($user->email) -> send(new SendMail($mail_data));
                }
            break;
            case 2: //User Group
                switch($data['user_group'])
                {
                    case 1: //Administrator
                        Mail::to($administrator->email) -> send(new SendMail($mail_data));
                    break;
                    case 2: //Tutors
                        foreach ($tutors as $tutor)
                        {
                            Mail::to($tutor->email) -> send(new SendMail($mail_data));
                        }
                    break;
                    case 3: //Students
                        foreach ($students as $student)
                        {
                            Mail::to($student->email) -> send(new SendMail($mail_data));
                        }
                    break;
                    default:
                        session()->flash('error', "There is an error sending messages!");
                        return redirect()->route('admin.notification.index');                        
                }
            break;

            case 3: //Selected Users
                foreach($data['user'] as $userId)
                {
                    $userEmail = User::where('id', $userId)->first()['email'];
                    Mail::to($userEmail) -> send(new SendMail($mail_data));
                }
            break;
        }
        return redirect()->route('admin.notification.index');
    }
}
