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
        $field = isset($_GET['field']) ? trim($_GET['field']) : "";
        $dir = isset($_GET['dir']) ? trim($_GET['dir']) : "asc";
        $url = "";
        $objs = null;

        if ($field!="") {
            $objs = Package::orderBy($field, $dir)->get()->toArray();            
        }
        else {
            $objs=Package::all()->toArray();
        }        

        $data = [
            'packages'   => $objs,            
            'url'           => $url,
            'order'  => [
                'field' => $field,
                'dir' => $dir
            ],
        ];   
     
        return view('admin.packages.index')->with('data', $data);
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
            'name'              => ['required', 'string'],
            'hours'             => ['required', 'numeric'],
            'prepaid'           => ['required', 'integer'],
            'student'           => ['nullable', 'integer'],
            'grades'            => ['nullable', 'Array'],
            'description'       => ['nullable', 'string'],
            'price_canada'      => ['required', 'numeric'],
            'price_usa'         => ['required', 'numeric'],
            'price_others'      => ['required', 'numeric'],
            'status'            => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect(route('admin.packages.create'));
        }

        $data = $request->all();
        $package = Package::create([
            'name'              => $data['name'],
            'prepaid'           => $data['prepaid'],
            'student_id'        => $data['student'],
            'description'       => $data['description'],
            'price_can'         => $data['price_canada'],
            'price_usa'         => $data['price_usa'],
            'price_alb'         => $data['price_others'],
            'hours'             => $data['hours'],
            'status'            => $data['status']
        ]);

        if ($package == NULL)
        {
            $request->session()->flash('error', "There was an error creating the package");
            return redirect(route('admin.packages.create'));
        }
        if (isset($data['grades'])) {
            foreach ($data['grades'] as $grade)
            {
                $package->grades()->attach($grade);
            }
        }
        
        $package->save();
        $request->session()->flash('success', "The Package has been created successfully");
        
        return redirect()->route('admin.packages.index');
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
            'hours'             => ['required', 'numeric'],
            'prepaid'           => ['required', 'integer'],
            'student'           => ['nullable', 'integer'],
            'grades'            => ['nullable', 'Array'],
            'description'       => ['nullable', 'string'],
            'price_canada'      => ['required', 'numeric'],
            'price_usa'         => ['required', 'numeric'],
            'price_others'      => ['required', 'numeric'],
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

        if (isset($data['grades'])) {
            $package->grades()->sync($data['grades']);
        }
        else {
            $package->grades()->detach();
        }

        if (!$package->save())
        {
            $request->session()->flash('error', "There was an error modifying package!");
            return redirect()->route('admin.packages.edit', $package);
        }

        $request->session()->flash('success', "You have modified information!");
        return redirect()->route('admin.packages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        if (Gate::denies('manage-students')) {
            session()->flash('error', "You don't have enough permission.");
            return redirect()->route('admin.packages.index');
        }
        
        $package->grades()->detach();
        $package->delete();
        session()->flash('success', "The Package has been deleted successfully");
        return redirect()->route('admin.packages.index');
    }

    /**
     * Remove multiple packages from database
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function multiDelete(Request $request)
    {
        $data = $request->all();
        
        if (Gate::denies('manage-students')) {
            session()->flash('error', "You don't have enough permission.");
            return redirect()->route('admin.packages.index');
        }
            
		if (isset($data['sids']) && $this->validateMultiDelete()) {
            $sids = $data['sids'];
            $obj_ids = explode(",", $sids);
                        
            if (count($obj_ids) ==0 ) {
                session()->flash('error', 'Nothing has been selected!');
                return redirect()->route('admin.packages.index');
            }

			foreach ($obj_ids as $id) {
                $obj = Package::find($id);                
                $obj->grades()->detach();
                $obj->delete();
			}
			            
            session()->flash('success', 'You have deleted packages!');		                       
            return redirect()->route('admin.packages.index');
        }
        session()->flash('error', 'Nothing has been selected or invalid request!');
        return redirect()->route('admin.packages.index');
    }

    /**
     * Check Multi Delete Permission, not implemented at the moment
     */
    public function validateMultiDelete()
    {
        return true;
    }
}
