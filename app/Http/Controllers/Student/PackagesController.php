<?php

namespace App\Http\Controllers\Student;

use App\Grade;
use App\Http\Controllers\Controller;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myuser = Auth::user();
        $packages = Grade::find($myuser->grade_id)->packages()->get()->toArray();
        $package_ides = array_column($packages, 'id');

        $packages = Package::where(function($package) use ($myuser, $package_ides) {
            return $package -> whereIn('id', $package_ides)
             -> orwhere('user_id', $myuser->id);

            if($myuser->country()->first()['name'] == 'Canada') {
                if($myuser->state()->first()['name'] == 'Alberta' || $myuser->state()->first()['code'] == 'AB' )
                {
                    return $package -> where('package_alb', '!=', '0.00');
                } else return $package -> where('package_can', '!=', '0.00');
            } else return $package -> where('package_usa', '!=', '0.00');
        }) -> get();

        $prices = Array();
        foreach ($packages as $package)
        {
            if($myuser->country()->first()['name'] == 'Canada') {
                if($myuser->state()->first()['name'] == 'Alberta' || $myuser->state()->first()['code'] == 'AB' )
                {
                    $prices[$package->id] = $package ->price_alb;
                } else $prices[$package->id] = $package ->price_can;
            } else $prices[$package->id] = $package ->price_usa;
        }
        return view('students.packages.index')->with('data', [
            'packages'  => $packages,
            'prices'    => $prices
        ]);
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
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }
}
