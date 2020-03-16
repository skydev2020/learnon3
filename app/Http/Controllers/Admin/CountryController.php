<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        return view('admin.countries.index')->with('countries', $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('manage-system')) {
            return redirect()->route('admin.countries.create');
        }

        $validator = Validator::make($request->all(), [
            'name'  => ['required', 'string', 'min:3', 'max:128'],
            'code'  => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.countries.create');
        }
        
        $data = $request->all();
        $country = Country::create([
            'name'  => $data['name'],
            'code'  => $data['code'],
        ]);

        if($country == NULL) {
            $request->session()->flash('error', 'There is an error creating countries!');
            return redirect()->route('admin.countries.create');
        }
        
        $request->session()->flash('success', 'You have modified countries!');
        return redirect()->route('admin.countries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit') -> with('country', $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        if (Gate::denies('manage-system')) {
            return redirect()->route('admin.countries.edit')->with('country', $country);
        }

        $validator = Validator::make($request->all(), [
            'name'  => ['required', 'string', 'min:3', "max:128"],
            'code'  => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.countries.edit', $country);
        }
        
        $data = $request->all();
        $country->name = $data['name'];
        $country->code = $data['code'];       

        if(!$country->save()) {
            $request->session()->flash('error', 'There is an error modifying countries!');
            return redirect()->route('admin.countries.edit', $country);
        }

        $request->session()->flash('success', 'You have modified countries!');
        return redirect()->route('admin.countries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        if (Gate::denies('manage-system')) {
            return redirect()->route('admin.countries.index');
        }

        $country->delete();
        return redirect()->route('admin.countries.index');
    }
}
