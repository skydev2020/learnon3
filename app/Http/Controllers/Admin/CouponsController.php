<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index')->with('coupons', $coupons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('manage-cms')){
            return redirect()->route('admin.coupons.create');
        }

        $validator = Validator::make($request->all(), [
            'c_name'        => ['required', 'string'],
            'description'   => ['required', 'string'],
            'code'          => ['required', 'string'],
            'c_type'        => ['nullable', 'string'],
            'discount'      => ['nullable', 'string'],
            'date_start'    => ['nullable', 'date'],
            'date_end'      => ['nullable', 'date'],
            'uses_total'    => ['nullable', 'integer'],
            'uses_customer' => ['nullable', 'integer'],
            'status'        => ['nullable', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.coupons.create');
        }

        $data = $request->all();
        $coupon = Coupon::create([
            'name'          => $data['c_name'],
            'description'   => $data['description'],
            'code'          => $data['code'],
            'type'          => $data['c_type'],
            'discount'      => $data['discount'],
            'date_start'    => $data['date_start'],
            'date_end'      => $data['date_end'],
            'uses_total'    => $data['uses_total'],
            'uses_customer' => $data['uses_customer'],
            'status'        => $data['status'],
        ]);

        if($coupon == NULL) {
            $request->session()->flash('error', 'There is an error creating the coupon!');
            return redirect()->route('admin.coupons.create');
        }

        $request->session()->flash('success', 'You have created the coupon!');
        return redirect()->route('admin.coupons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit')->with('coupon', $coupon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        if (Gate::denies('manage-cms')){
            return redirect()->route('admin.coupons.edit', $coupon);
        }

        $validator = Validator::make($request->all(), [
            'c_name'        => ['required', 'string'],
            'description'   => ['required', 'string'],
            'code'          => ['required', 'string'],
            'c_type'        => ['nullable', 'string'],
            'discount'      => ['nullable', 'string'],
            'date_start'    => ['nullable', 'date'],
            'date_end'      => ['nullable', 'date'],
            'uses_total'    => ['nullable', 'integer'],
            'uses_customer' => ['nullable', 'integer'],
            'status'        => ['nullable', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.coupons.edit', $coupon);
        }

        $data = $request->all();
        $coupon->name = $data['c_name'];
        $coupon->description = $data['description'];
        $coupon->code = $data['code'];
        $coupon->type = $data['c_type'];
        $coupon->discount = $data['discount'];
        $coupon->date_start = $data['date_start'];
        $coupon->date_end = $data['date_end'];
        $coupon->uses_total = $data['uses_total'];
        $coupon->uses_customer = $data['uses_customer'];
        $coupon->status = $data['status'];

        if(!$coupon->save()) {
            $request->session()->flash('error', 'There is an error modifying the coupon!');
            return redirect()->route('admin.coupons.edit', $coupon);
        }

        $request->session()->flash('success', 'You have modified the coupon!');
        return redirect()->route('admin.coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        if (Gate::denies('manage-cms')){
            return redirect()->route('admin.coupons.index');
        }

        $coupon->delete();
        return redirect()->route('admin.coupons.index');
    }
}
