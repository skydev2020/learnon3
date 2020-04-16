<?php

namespace App\Http\Controllers\Admin;

use App\Grade;
use App\Http\Controllers\Controller;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::all();
        return view('admin.grades.index')->with('grades', $grades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('admin.grades.create')->with('subjects', $subjects);
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
            return redirect()->route('admin.grades.create');
        }

        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'min:3', 'max:128'],
            'price_usa' => ['nullable', 'string'],
            'price_alb' => ['nullable', 'string'],
            'price_can' => ['nullable', 'string'],
        ]);


        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.grades.create');
        }

        $data = $request->all();
        $grade = Grade::create([
            'name'      => $data['name'],
            'price_usa' => $data['price_usa'],
            'price_alb' => $data['price_alb'],
            'price_can' => $data['price_can']
        ]);

        if($grade == NULL) {
            $request->session()->flash('error', 'There is an error creating Grades!');
            return redirect()->route('admin.grades.create');
        }

        if (isset($data['subjects']))
        {
            foreach ($data['subjects'] as $subject)
            {
                $grade->subjects()->attach($subject);
            }
        }

        $request->session()->flash('success', 'You have modified Grades!');
        return redirect()->route('admin.grades.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit(Grade $grade)
    {
        $subjects = Subject::all();
        $data =  [
            'subjects'  => $subjects,
            'grade'     => $grade,
        ];
        return view('admin.grades.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $grade)
    {
        if (Gate::denies('manage-system')) {
            return redirect()->route('admin.grades.edit', $grade);
        }

        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'min:3', "max:128"],
            'price_usa' => ['nullable', 'string'],
            'price_can' => ['nullable', 'string'],
            'price_alb' => ['nullable', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.grades.edit', $grade);
        }

        $data = $request->all();
        if (isset($data['subjects'])) $grade->subjects()->sync($data['subjects']);

        $grade->name = $data['name'];
        if (isset($data['price_usa'])) $grade->price_usa = $data['price_usa'];
        if (isset($data['price_alb'])) $grade->price_alb = $data['price_alb'];
        if (isset($data['price_can'])) $grade->price_can = $data['price_can'];

        if(!$grade->save()) {
            $request->session()->flash('error', 'There is an error modifying Grades!');
            return redirect()->route('admin.grades.edit', $grade);
        }

        if (isset($data['subjects']))
        {
            $grade->subjects()->sync($data['subjects']);
        }

        $request->session()->flash('success', 'You have modified Grades!');
        return redirect()->route('admin.grades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        if (Gate::denies('manage-system')) {
            return redirect(route('admin.grades.index'));
        }

        $grade->subjects()->detach();
        $grade->delete();

        return redirect()->route('admin.grades.index');
    }
}
