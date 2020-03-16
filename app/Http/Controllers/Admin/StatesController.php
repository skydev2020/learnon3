<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();
        return view('admin.states.index') -> with ('states', $states);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.states.create');
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
            return redirect()->route('admin.states.create');
        }

        $validator = Validator::make($request->all(), [
            'name'  => ['required', 'string', 'min:3', 'max:128'],
            'code'  => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.states.create');
        }
        
        $data = $request->all();
        $state = State::create([
            'name'  => $data['name'],
            'code'  => $data['code'],
        ]);

        if($state == NULL) {
            $request->session()->flash('error', 'There is an error creating Province/State!');
            return redirect()->route('admin.states.create');
        }
        
        $request->session()->flash('success', 'You have modified Province/State!');
        return redirect()->route('admin.states.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        return view('admin.states.edit')->with('state', $state);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        if (Gate::denies('manage-system')) {
            return redirect()->route('admin.states.edit')->with('state', $state);
        }

        $validator = Validator::make($request->all(), [
            'name'  => ['required', 'string', 'min:3', "max:128"],
            'code'  => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.states.edit', $state);
        }
        
        $data = $request->all();
        $state->name = $data['name'];
        $state->code = $data['code'];       

        if(!$state->save()) {
            $request->session()->flash('error', 'There is an error modifying Province/State!');
            return redirect()->route('admin.states.edit', $state);
        }

        $request->session()->flash('success', 'You have modified Province/State!');
        return redirect()->route('admin.states.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        if (Gate::denies('manage-system')) {
            return redirect()->route('admin.states.index');
        }

        $state->delete();
        return redirect()->route('admin.states.index');
    }
}
