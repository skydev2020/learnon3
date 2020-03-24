<?php

namespace App\Http\Controllers\Tutor;

use App\EssayAssignment;
use App\EssayAssignmentAttachment;
use App\EssayStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EssaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tutor.essays.index')-> with('essays', Auth::User()->tutor_essayAssignments()->get());
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
     * @param  \App\EssayAssignment  $essayAssignment
     * @return \Illuminate\Http\Response
     */
    public function show(EssayAssignment $essay)
    {
        return view('tutor.essays.upload') -> with('essay', $essay);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  \App\EssayAssignment  $essayAssignment
     * @return \Illuminate\Http\Response
     */
    public function edit(EssayAssignment $essay)
    {
        $statuses = EssayStatus::whereIn('id', Array(1, 3, 4))->get();
        $attachment_name = $essay->attachments()->first()['assignment_name'];
        $data = [
            'essay'         => $essay,
            'statuses'      => $statuses,
            'attachment'    => $attachment_name
        ];
        return view('tutor.essays.edit') -> with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EssayAssignment  $essayAssignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EssayAssignment $essay)
    {
        $validator = Validator::make($request->all(), [
            'date_completed'    => ['required', 'date'],
            'status'            => ['required', 'integer']
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('tutor.essays.create');
        }

        $data = $request->all();
        $essay->date_completed = $data['date_completed'];
        $essay->status_id = $data['status'];

        if (!$essay->save())
        {
            $request->session()->flash('error', "There is an error modifying Assignments!");
            return redirect()->route('tutor.essays.edit', $essay);
        }

        $request->session()->flash('success', "You have modified Assignments!");
        return redirect()->route('tutor.essays.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EssayAssignment  $essayAssignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(EssayAssignment $essayAssignment)
    {
        //
    }

    public function upload(Request $request, EssayAssignment $essay)
    {
        $data = $request->all();
        if (empty($data['attachment'])) 
        {
            session()->flash('error', "You have to submit at least one file!");
            return redirect()->route('tutor.essays.show', $essay);
        }

        foreach ($request->file('attachment') as $file)
        {
            if ($file->getSize() > 10000000)
            {
                 session()->flash('error', "File size exceeds 10000000 bytes");
                 continue;
            }

            
            $file_name = preg_replace('/[^a-zA-Z0-9_ \.-]/s', '', str_replace(' ','-',$file->getClientOriginalName()));
            $file_name = rand (1,9999).'-'.strtotime('now').'-'.strtolower($file_name);
            if(!$file->move(base_path('\essay_attachments'), $file_name))
            {
                session()->flash('error', "File Upload Failed!");
                continue;
            }
            $attachment = EssayAssignmentAttachment::create([
                'essay_id'          => $essay->id,
                'assignment_name'   => $file_name
            ]);

            if ($attachment != NULL)
            {
                session()->flash('success', "File Uploaded Successfully");
            } else {
                session()->flash('error', "File Upload Failed");
            }
        }
        return redirect()->route('tutor.essays.index');
    }
}
