<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Setting;
use App\Mail\SendMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class EmailSendController extends Controller
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
        return view('admin.emailsend.index') -> with('data', $data);
    }

    public function show(Request $request)
    {
        if (Gate::denies('manage-cms')) {
            return redirect()->route('admin.emailsend.index');
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
                            $mail = $this -> baseMail();
                            $mail->setTo($tutor->email);
                            $mail->setFrom(Setting::where('key', 'config_email2')->first()['value']);
                            $mail->setSubject($data['subject']);					
                            $mail->setHtml($message);
                            $mail->send();
                        }
                    break;
                    case 3: //Students
                        foreach ($students as $student)
                        {
                            $mail = $this -> baseMail();
                            $mail->setTo($student->email);
                            $mail->setFrom(Setting::where('key', 'config_email')->first()['value']);
                            $mail->setSubject($data['subject']);					
                            $mail->setHtml($message);
                            $mail->send();
                        }
                    break;
                    default:
                        $request->session()->flash('error', "There is an error sending messages!");
                        return redirect()->route('admin.emailsend.index');                        
                }
            break;

            case 3: //Selected Users
                foreach($data['users'] as $userId)
                {
                    $userEmail = User::where('id', $userId)->first()['email'];
                    $mail = $this -> baseMail();
                    $mail->setTo($userEmail);
                    $mail->setFrom(Setting::where('key', 'config_email')->first()['value']);
                    $mail->setSubject($data['subject']);					
                    $mail->setHtml($message);
                    $mail->send();
                }
            break;
        }
        return redirect()->route('admin.emailsend.index');
    }
}
