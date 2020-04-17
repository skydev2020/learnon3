<?php

namespace App\Http\Controllers\Admin;

use App\Assignment;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderByDesc('created_at')->limit(30)->get();
        $users = Role::find(config('global.STUDENT_ROLE_ID'))->users()->orderByDesc('created_at')->limit(30)->get();
        //dd($users);
        foreach ($users as $user)
        {
            $notifications->put($user->id, $user);
        }
        $notifications = $notifications->sortByDesc('created_at');
        $notifications = $notifications->skip(0)->take(30);
        $user = Auth::User();
        if($user->last_login == "" || $user->last_login == "0000-00-00 00:00:00"){
			$last_login = "Never";
		}else{
			$last_login = date('l dS F Y h:i:s A', strtotime($user->last_login));
		}
        $students_num = count(Role::find(config('global.STUDENT_ROLE_ID'))->users()->get());
        $tutors_num = count(Role::find(config('global.TUTOR_ROLE_ID'))->users()->get());
        $received_class = count(Assignment::has('students')->has('sessions')->get());
        $received_percentage = round($received_class * 100 / $students_num, 2);
        $students_current_year = count(Role::find(config('global.STUDENT_ROLE_ID'))->users()
            ->where('created_at', 'like', '%' . date("Y") . '%')->get());
        $tutors_current_year = count(Role::find(config('global.TUTOR_ROLE_ID'))->users()
            ->where('created_at', 'like', date("Y"))->get());

        $received_class = count(Assignment::has('students')->whereHas('sessions', function($session) {
            return $session->where('session_date', 'like', "%" . date("Y") . '%');
        })->get());
        $total_received_class_curryear = round($received_class * 100 / $students_num, 2);
        $data = [
            'notifications' => $notifications,
            'overview'      => [
                'Last Login:'                                                           => $last_login,
                'Number of students registered:'                                        => $students_num,
                'Number of tutors registered:'                                          => $tutors_num,
                '% registered students who have ACTUALLY received a class:'             => $received_percentage . '%',
                'Number of students registered this year:'                              => $students_current_year,
                'Number of tutors registered this year:'                                => $tutors_current_year,
                '% registered students who have ACTUALLY received a class this year:'   => $total_received_class_curryear . '%'
            ],
        ];
        return view('admin.home')->with('data', $data);
    }
}
