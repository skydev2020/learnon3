<?php

namespace App\Imports;

use App\EssayAssignment;
use App\Notification;
use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportEssay implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (count($row) > 10)
        {
            if (User::where('email', 'like', $row[10])->get() != NULL)
            {
                Notification::create([
                    'notification_from' => Auth::User()->id,
                    'notification_to'   => User::where('email', 'like', $row[10]) -> first()['id'],
                    'headers'           => '',
                    'subject'           => "Essay assigned",
                    'message'           => "You have been assigned an essay to complete."
                ]);
            }

            return new EssayAssignment([
                'assignment_num'    => substr($row[2], 1),
                'topic'             => $row[4],
                'description'       => $row[4],
                'format'            => '',
                'student_id'        => User::where('email', 'like', $row[3]) -> first()['id'],
                'tutor_id'          => User::where('email', 'like', $row[10]) -> first()['id'],
                'date_assigned'     => strtotime($row[5]) != NULL ? date('Y-m-d', strtotime($row[5])) : "",
                'date_completed'    => strtotime($row[6]) != NULL ? date('Y-m-d', strtotime($row[6])) : "",
                'due_date'          => strtotime($row[6]) != NULL ? date('Y-m-d', strtotime($row[6])) : "",
                'paid'              => str_replace('$', '', $row[11]),
                'owed'              => str_replace('$', '', $row[7]),
                'current_status'    => User::where('email', 'like', $row[10])->get()==NULL ? 7 : 1,
                'status'            => User::where('email', 'like', $row[10])->get()==NULL ? 7 : 1,
            ]);
        }
        return NULL;
    }
}
