<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderStatus;
use App\OrderTotal;
use App\OrderHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class ReceivedPaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            'id'            => 'nullable|integer',
            's_name'        => 'nullable|string',
            'status_id'     => 'nullable|integer',
            'date_added'    => 'nullable|date',
            
        ]);

        $q = "1=1 ";
        if (isset($request_data['id'])) {
            $q .= " and id like '%" . $request_data['id'] . "%'";
        } else $request_data['id'] = "";

        if (isset($request_data['date_added'])) {
            $q.= " and created_at like '%".$request_data['date_added']."%'";
        } else $request_data['date_added'] = "";

        if (isset($request_data['status_id'])) {
            $q.= " and status_id like '%".$request_data['status_id']."%'";
        } else $request_data['status_id'] = "";

        $orders = Order::whereRaw($q);
        
        if (isset($request_data['s_name'])) {
            $orders = $orders->whereHas('users', function($user) use ($request_data) {
            return $user->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
            });
        } else $request_data['s_name'] = "";
        $orders = $orders->get();
        $order_statuses = OrderStatus::all();

        $data = [
            'orders'    => $orders,
            'statuses'  => $order_statuses,
            'old'       => $request_data,
        ];

       if( count($orders) == 0 ) $request->session()->flash('error', "No search results!");
        
        return view('admin.receivedpayments.index')->with('data', $data);
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $receivedpayment)
    {
        $order_total =  OrderTotal::where('order_id', 'like', $receivedpayment->id)
        ->where('title', 'like', 'Total:')->first();
        $order_subtotal =  OrderTotal::where('order_id', 'like', $receivedpayment->id)
        ->where('title', 'like', 'Sub-Total:')->first();
        $order_card =  OrderTotal::where('order_id', 'like', $receivedpayment->id)
        ->where('title', 'like', '%Credit Card Convenience Fee:%')->first();
        $orderhistories = OrderHistory::where('order_id', 'like', $receivedpayment->id)->get();
        $order_statuses = OrderStatus::all();

        $data = [
            'order'             => $receivedpayment,
            'order_total'       => $order_total,
            'order_subtotal'    => $order_subtotal,
            'order_card'        => $order_card,
            'order_histories'   => $orderhistories,
            'statuses'          => $order_statuses,
        ];
        return view('admin.receivedpayments.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $receivedpayment)
    {
        $validator = Validator::make($request->all(), [
            'left_hours'        => ['required', 'string'],
            'status_id'         => ['required', 'int'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.receivedpayments.edit', $receivedpayment);
        }
        $data = $request->all();

        if ($request->input('action') == 'update')
        {
            $receivedpayment->left_hours = $data['left_hours'];
            if ($receivedpayment->save()) {
                $request->session()->flash('success', 'You have modified orders!');
            }
    
            $orderhistory = OrderHistory::create([
                'order_id'          => $receivedpayment->id,
                'order_status_id'   => $data['status_id'],
                'notify'            => '0',
                'comment'           => "Remaining Hours Update From ". $receivedpayment->left_hours . ' To ' . $data['left_hours']
            ]);
            return redirect()->route('admin.receivedpayments.edit', $receivedpayment);
        }
        else {
            
            $orderhistory = OrderHistory::create([
                'order_id'          => $receivedpayment->id,
                'status_id'          => $data['status_id'],
                'notify'            => '0',
                'comment'           => $data['comment']
            ]);
            $request->session()->flash('success', 'You have modified order histories!');
            return redirect()->route('admin.receivedpayments.edit', $receivedpayment);
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if (Gate::denies('manage-payments'))
        {
            return redirect()->route('admin.receivedpayments.index');
        }

        if ($order->delete())
        {
            session()->flash('success', 'You have modified the order!');
        } else {
            session()->flash('error', 'There is an error deleting the order');
        }
        return redirect()->route('admin.receivedpayments.index');
    }
}
