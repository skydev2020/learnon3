<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Information;
use App\UrlAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class InformationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informations = Information::all();
        return view('admin.informations.index')->with('informations', $informations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.informations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('manage-cms')) {
            return redirect()->route('admin.informations.create');
        }

        $validator = Validator::make($request->all(), [
            'title'        => ['required', 'string'],
            'description'  => ['required', 'string'],
            'status'       => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.informations.create');
        }
        
        $data = $request->all();
        $information = Information::create([
            'title'         => $data['title'],
            'description'   => $data['description'],
            'status'        => $data['status']
        ]);

        if($information == NULL) {
            $request->session()->flash('error', 'There is an error creating information!');
            return redirect()->route('admin.informations.create');
        }

        if (isset($data['keyword'])) {
            UrlAlias::create([
                'query'     => "information_id=" . $information->id,
                'keyword'   => $data['keyword']
            ]);
        }
        $request->session()->flash('success', 'You have created information!');
        return redirect()->route('admin.informations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function edit(Information $information)
    {
        $urlalias = Urlalias::all()->first();
        $urlalias = $urlalias->whereRaw("query like 'information_id=" . $information->id . "'")->first();
        $data = [
            'information'   => $information,
            'urlalias'      => $urlalias
        ];
        return view('admin.informations.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Information $information)
    {
        if (Gate::denies('manage-cms')) {
            return redirect()->route('admin.informations.edit')->with('information', $information);
        }

        $validator = Validator::make($request->all(), [
            'title'        => ['required', 'string'],
            'description'  => ['required', 'string'],
            'status'       => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.informations.edit', $information);
        }
        
        $data = $request->all();
        $information->title = $data['title'];
        $information->description = $data['description'];
        $information->status = $data['status'];
        $urlalias = UrlAlias::whereRaw("query like 'information_id=" . $information->id . "'")->first();
        if (isset($data['keyword'])) {
            if ($urlalias != NULL) $urlalias->delete();
            UrlAlias::create([
                'query'     => "information_id=" . $information->id,
                'keyword'   => $data['keyword']
            ]);
        }
       

        if(!$information->save()) {
            $request->session()->flash('error', 'There is an error modifying information!');
            return redirect()->route('admin.informations.edit', $information);
        }

        $request->session()->flash('success', 'You have modified information!');
        return redirect()->route('admin.informations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function destroy(Information $information)
    {
        if (Gate::denies('manage-cms')) {
            return redirect()->route('admin.informations.index');
        }

        $information->delete();
        return redirect()->route('admin.informations.index');
    }
}
