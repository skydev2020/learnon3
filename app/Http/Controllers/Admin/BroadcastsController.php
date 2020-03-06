<?php

namespace App\Http\Controllers\Admin;

use App\Broadcast;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class BroadcastsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $broadcasts = Broadcast::all();
        return view('admin.broadcasts.index')->with('broadcasts', $broadcasts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.broadcasts.create');
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
            return redirect()->route('admin.broadcasts.create');
        }

        $validator = Validator::make($request->all(), [
            'title'             => ['required', 'string', 'min:3', 'max:64'],
            'subject'           => ['required', 'string', 'min:3', 'max:64'],
            'mail_template'     => ['required', 'string'],
            'status'            => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.broadcasts.create');
        }
        
        $data = $request->all();
        $broadcast = Broadcast::create([
            'title'             => $data['title'],
            'subject'           => $data['subject'],
            'content'           => $data['mail_template'],
            'status'            => $data['status'],
        ]);
 
        if($broadcast == NULL) {
            $request->session()->flash('error', 'There is an error creating information!');
            return redirect()->route('admin.broadcasts.create');
        }

        $request->session()->flash('success', 'You have created information!');
        return redirect()->route('admin.broadcasts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Broadcast  $broadcast
     * @return \Illuminate\Http\Response
     */
    public function show(Broadcast $broadcast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Broadcast  $broadcast
     * @return \Illuminate\Http\Response
     */
    public function edit(Broadcast $broadcast)
    {
        return view('admin.broadcasts.edit')->with('broadcast', $broadcast);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Broadcast  $broadcast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Broadcast $broadcast)
    {
        if (Gate::denies('manage-cms')){
            return redirect()->route('admin.broadcasts.edit', $broadcast);
        }

        $validator = Validator::make($request->all(), [
            'title'             => ['required', 'string'],
            'subject'           => ['required', 'string'],
            'mail_template'     => ['required', 'string'],
            'status'            => ['required', 'integer'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('admin.broadcasts.edit', $broadcast);
        }
        
        $data = $request->all();
        $broadcast->title = $data['title'];
        $broadcast->subject = $data['subject'];
        $broadcast->content = $data['mail_template'];
        $broadcast->status = $data['status'];
 
        if(!$broadcast->save()) {
            $request->session()->flash('error', 'There is an error modifying information!');
            return redirect()->route('admin.broadcasts.edit', $broadcast);
        }

        $request->session()->flash('success', 'You have modified information!');
        return redirect()->route('admin.broadcasts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Broadcast  $broadcast
     * @return \Illuminate\Http\Response
     */
    public function destroy(Broadcast $broadcast)
    {
        if (Gate::denies('manage-cms')) {
            return redirect()->route('admin.broadcasts.index');
        }

        $broadcast->delete();
        return redirect()->route('admin.broadcasts.index');
    }
}
