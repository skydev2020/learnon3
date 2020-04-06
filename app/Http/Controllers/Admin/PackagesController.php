<?php

namespace App\Http\Controllers\Admin;

use App\Grade;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Package;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        if (Gate::denies('manage-students')) return redirect()->route('admin.packages.index');

        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        $grades = Grade::all();
        $data = [
            'students'  => $students,
            'grades'    => $grades
        ];
        return view('admin.packages.create') -> with('data', $data);
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
            'price_alb'         => $data['price_others'],
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
        $students = Role::find(config('global.STUDENT_ROLE_ID'))->users()->get();
        $grades = Grade::all();
        $data = [
            'students'  => $students,
            'grades'    => $grades,
            'package'   => $package
        ];

        return view('admin.packages.edit') -> with('data', $data);
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
        $validator = Validator::make($request->all(), [
            'name'              => ['required', 'string'],
            'hours'             => ['required', 'string'],
            'prepaid'           => ['required', 'integer'],
            'student'           => ['nullable', 'integer'],
            'grades'            => ['required', 'Array'],
            'description'       => ['required', 'string'],
            'price_canada'      => ['required', 'string'],
            'price_usa'         => ['required', 'string'],
            'price_others'      => ['required', 'string'],
            'status'            => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect(route('admin.packages.edit', $package));
        }

        $data = $request->all();
        $package->name          = $data['name'];
        $package->prepaid       = $data['prepaid'];
        $package->student_id    = $data['student'];
        $package->description   = $data['description'];
        $package->price_can     = $data['price_canada'];
        $package->price_usa     = $data['price_usa'];
        $package->price_alb     = $data['price_others'];
        $package->hours         = $data['hours'];        
        $package->status        = $data['status'];
        foreach ($data['grades'] as $grade)
        {
            $package->grades()->attach($grade);
        }

        if (!$package->save())
        {
            $request->session()->flash('error', "There was an error modifying package!");
            return redirect(route('admin.users.assignments.create'));
        }

        $request->session()->flash('success', "You have modified information!");
        $packages = Package::all();
        return view('admin.packages.index')->with('packages', $packages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        if (Gate::denies('manage-students')) return redirect()->route('admin.packages.index');

        $package->delete();
        session()->flash('success', "The Package has been deleted successfully");
        return redirect()->route('admin.packages.index');
    }
}
