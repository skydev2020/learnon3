<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\sendmail;
use App\Order;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Student_PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $field = isset($_GET['field']) ? trim($_GET['field']) : "";
        $dir = isset($_GET['dir']) ? trim($_GET['dir']) : "asc";
        $url = "";

        $orders = Order::has('packages')->has('users');
        
        if (($field=="firstname") || ($field=="total_hours") || ($field=="left_hours") || ($field=="created_at")) {
            // $q.= " order by ".$field." ".$dir;
            $orders = $orders->orderBy($field, $dir);            
        }
        $objs=[];
        $orders=$orders->get();
        // dd($orders);
        foreach ($orders as $order) {                        
            $obj= $order->toArray();
            
            if ($order->package()) {
                $obj['package_name'] = $order->package()['name'];
            }
            else {
                $obj['package_name'] = "" ;
            }                       
            $objs[]=$obj;
        }

        if ($field=="package_name") {
            $fields  = array_column($objs, $field);
            if ($dir == 'asc') {
                array_multisort($fields, SORT_ASC, $objs);
            }
            else {
                array_multisort($fields, SORT_DESC, $objs);
            }
        }   

        $data = [
            'orders'   => $objs,            
            'url'           => $url,
            'order'  => [
                'field' => $field,
                'dir' => $dir
            ],
        ];        
        return view('admin.student_packages.index')->with('data', $data);
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $student_package)
    {
        $subject = 'Reminder: Few Hours left in your Package';
        $message = 'Hello @STUDENT_NAME@, <br><br>
        You have few hours remaining in your package. <br>
        Purchase more hours to continue availaing discounted hours.<br>
        Login to your account to purchase discounted hours.
        <br><br> Regards, <br>Team Learnon!';
			
        // Here you can define keys for replace before sending mail to Student
        $replace_info = Array(
            'STUDENT_NAME' => $student_package->users()->first()['fname'].' '.$student_package->users()->first()['lname'], 
        );
        
        foreach($replace_info as $rep_key => $rep_text) {
            $message = str_replace('@'.$rep_key.'@', $rep_text, $message);
        }

        $data = [
            'subject'   => $subject,
            'message'   => $message
        ];
        Mail::to($student_package->users()->first()['email']) -> send(new sendmail($data));
        session()->flash('success', "Reminder sent successfully!");
        return redirect()->route('admin.student_packages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
