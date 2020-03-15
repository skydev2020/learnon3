<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Session;
use App\Assignment;
use App\Invoice;
use App\Order;
use Illuminate\Http\Request;

class StudentReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        //dd($students);
        $student_reports = Array();
        foreach($students as $student)
        {
            //Get Total Hours and Total Amount of Invoices
            $invoices = Invoice::where('user_id', $student->id);
            $total_hours = array_sum($invoices->get('total_hours')->pluck('total_hours')->toArray());
            $total_amount = array_sum($invoices->get('total_amount')->pluck('total_amount')->toArray());

            //Get Total Hours and Total Amount of Orders
            $orders = Order::where('user_id', $student->id)
             -> where('package_id', '!=', 0)
             -> where('status_id', 5);
            $total_hours += array_sum($orders->get('total_hours')->pluck('total_hours')->toArray());
            $total_amount += array_sum($orders->get('total')->pluck('total')->toArray());

            //Get Total Revenuses
            $sessions = Session::whereHas('assignments', function($assignment) use ($student){
                return $assignment->where('student_id', $student->id);
            })->get();

            $total_revenues = $this->stuff($sessions);

            $student_reports[] = array("Id" => $student['id']
            , "Student Name" => $student['fname'] . ' ' . $student['lname']
            , 'Email' => $student['email'], 'City' => $student['city']
            , 'Total Hours' => $total_hours, 'Total Revenues' =>$total_amount
            , 'Total Profits' => $total_amount - $total_revenues);
        }

        return view('admin.studentreports.index')->with('reports', $student_reports);
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
        //
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
        //
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

    public function stuff($sessions){
        $computed = Array();
        for($index = 0; $index < count($sessions); $index++){
            $base_wage = $sessions[$index]->assignments() == NULL ? 0 : 
            $sessions[$index]->assignments()->first()['base_wage'];
            array_push($computed, $sessions[$index]->session_duration * $base_wage);
        }
        return array_sum($computed);
      }
}
