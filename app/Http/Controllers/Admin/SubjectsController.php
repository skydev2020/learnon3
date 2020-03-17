<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subjects.index')->with('subjects', $subjects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subjects.create');
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
            return redirect()->route('admin.subjects.create');
        }

        $validator = Validator::make($request->all(), [
            'name'  => ['required', 'string', 'min:3', 'max:128'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.subjects.create');
        }
        
        $data = $request->all();
        $subject = Subject::create([
            'name'  => $data['name']
        ]);

        if($subject == NULL) {
            $request->session()->flash('error', 'There is an error creating Subjects!');
            return redirect()->route('admin.subjects.create');
        }
        
        $request->session()->flash('success', 'You have modified Subjects!');
        return redirect()->route('admin.subjects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit')->with('subject', $subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        if (Gate::denies('manage-system')) {
            return redirect()->route('admin.subjects.edit')->with('subject', $subject);
        }

        $validator = Validator::make($request->all(), [
            'name'  => ['required', 'string', 'min:3', "max:128"],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.subjects.edit', $subject);
        }
        
        $data = $request->all();
        $subject->name = $data['name'];     

        if(!$subject->save()) {
            $request->session()->flash('error', 'There is an error modifying Subjects!');
            return redirect()->route('admin.subjects.edit', $subject);
        }

        $request->session()->flash('success', 'You have modified Subjects!');
        return redirect()->route('admin.subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        if (Gate::denies('manage-system')) {
            return redirect()->route('admin.subjects.index');
        }

        $subject->delete();
        return redirect()->route('admin.subjects.index');
    }
}
