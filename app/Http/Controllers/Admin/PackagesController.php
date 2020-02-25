<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return view('admin.packages.index')->with('packages', $packages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'             => ['required', 'string'],
            'description'      => ['required', 'string'],
            'price_canada'     => ['required', 'string'],
            'price_usa'        => ['required', 'string'],
            'price_others'     => ['required', 'string'],
            'hours'            => ['required', 'string'],
            'status'           => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', "There was an error creating new package");
            return redirect(route('admin.users.assignments.create'));
        }

        $data = $request->all();
        $package = Package::create([
            'name'              => $data['name'],
            'description'       => $data['description'],
            'price_canada'      => $data['price_canada'],
            'price_usa'         => $data['price_usa'],
            'price_others'      => $data['price_others'],
            'hours'             => $data['hours'],
            'hours'             => $data['hours'],
        ]);

        if ($package == NULL)
        {
            $request->session()->flash('error', "There was an error creating the assignment");
            return redirect(route('admin.users.assignments.create'));
        }

        $request->session()->flash('success', "The Package has been created successfully");
        $packages = Package::all();
        return view('admin.packages.index')->with('packages', $packages);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
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
