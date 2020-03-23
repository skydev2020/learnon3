<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\ProgressReport;
use App\User;
use App\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class ReportCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_data = $this->validate($request, [
            's_name'        => 'nullable|string',
            'grade'         => 'nullable|string',
            'subjects'      => 'nullable|string',
            'date_added'    => 'nullable|date', 
        ]);

        $myuser = Auth::User();
        $reports = $myuser->tutor_reportcards();

        $q = "1=1 ";
        if (isset($request_data['subjects'])) {
            $q .= " and subjects like '%" . $request_data['subjects'] . "%'";
        } else $request_data['subjects'] = "";
        
        if (isset($request_data['date_added'])) {
            $q .= " and created_at like '%" . $request_data['date_added'] . "%'";
        } else $request_data['date_added'] = "";

        $reports = $reports->whereRaw($q);

        if (isset($request_data['s_name'])) {
            $reports = $reports->whereHas('students', function ($student) use ($request_data){
                return $student->where('fname', 'like', "%" . $request_data['s_name'] . "%")
                ->orwhere('lname', 'like', "%" . $request_data['s_name'] . "%");
            });
        } else $request_data['s_name'] = "";

        if (isset($request_data['grade'])) {
            $reports = $reports->whereHas('grades', function ($grade) use ($request_data){
                return $grade->where('name', 'like', "%" . $request_data['grade'] . "%");
            });
        } else $request_data['grade'] = "";
        $reports = $reports -> get();

        $data = [
            'reports'   => $reports,
            'old'       => $request_data
        ];

        if (count($reports) == 0) $request->session()->flash('error', 'No Search Result!');

        return view('tutor.reportcards.index') -> with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $myuser = Auth::User();
        $students = Array();
        foreach($myuser->tutor_assignments()->get() as $assignments)
        {
            $students[] = $assignments->student();
        }
        $students = array_unique($students);

        return view('tutor.reportcards.create') -> with('students', $students);
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
            'sname'                 => ['required', 'integer'],
            'student_prepared'      => ['required', 'integer'],
            'questions_ready'       => ['required', 'integer'],
            'pay_attention'         => ['required', 'integer'],
            'weaknesses'            => ['required', 'string'],
            'listen_to_suggestions' => ['required', 'integer'],
            'improvements'          => ['required', 'string'],
            'other_comments'        => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('tutor.reportcards.create');
        }

        
        $data = $request->all();
        $student = User::where('id', $data['sname'])->first();
        
        $tutor_id = Auth::User()->id;
        $assignments = Assignment::where(function($assignment) use ($student, $tutor_id) {
            return $assignment -> where('tutor_id', $tutor_id)
            -> where('student_id', $student->id);
        })->get();

        $subjects_array = Array();
        foreach ($assignments as $assignment) 
        {
            $subjects = $assignment->subjects()->get();
            foreach ($subjects as $subject) {
                $subjects_array[] = $subject->name;
            }
        }

        $subjects = "";
        foreach ($subjects_array as $subject)
        {
            $subjects .= $subject . ',';
        }
        $subjects = rtrim($subjects ,',');

        $reportcard = ProgressReport::create([
            'tutor_id'                  => $tutor_id,
            'student_id'                => $data['sname'],
            'grade_id'                  => $student->grade_id,
            'subjects'                  => $subjects,
            'student_prepared'          => $data['student_prepared'],
            'questions_ready'           => $data['questions_ready'],
            'pay_attention'             => $data['pay_attention'],
            'weaknesses'                => $data['weaknesses'],
            'listen_to_suggestions'     => $data['listen_to_suggestions'],
            'improvements'              => $data['improvements'],
            'other_comments'            => $data['other_comments']
        ]);
        
        if ($reportcard == NULL)
        {
            $request->session()->flash('error', "There is an error seding Report card.");
            return redirect()->route('tutor.reportcards.create');
        }

        $request->session()->flash('success', "Report card sent successfully.");
        return redirect()->route('tutor.reportcards.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProgressReport  $progressReport
     * @return \Illuminate\Http\Response
     */
    public function show(ProgressReport $progressReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgressReport  $progressReport
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgressReport $reportcard)
    {
        $myuser = Auth::User();
        $students = Array();
        foreach($myuser->tutor_assignments()->get() as $assignments)
        {
            $students[] = $assignments->student();
        }

        $students = array_unique($students);

        $data = [
            'report'    => $reportcard,
            'students'  => $students,
        ];
        return view('tutor.reportcards.edit') -> with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgressReport  $progressReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgressReport $reportcard)
    {
        $validator = Validator::make($request->all(), [
            'sname'                 => ['required', 'integer'],
            'student_prepared'      => ['required', 'integer'],
            'questions_ready'       => ['required', 'integer'],
            'pay_attention'         => ['required', 'integer'],
            'weaknesses'            => ['required', 'string'],
            'listen_to_suggestions' => ['required', 'integer'],
            'improvements'          => ['required', 'string'],
            'other_comments'        => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            $request->session()->flash('error', $validator->messages()->first());
            return redirect()->route('tutor.reportcards.edit', $reportcard);
        }

        $data = $request->all();
        $reportcard['student_id']               = $data['sname'];
        $reportcard['student_prepared']         = $data['student_prepared'];
        $reportcard['questions_ready']          = $data['questions_ready'];
        $reportcard['pay_attention']            = $data['pay_attention'];
        $reportcard['weaknesses']               = $data['weaknesses'];
        $reportcard['listen_to_suggestions']    = $data['listen_to_suggestions'];
        $reportcard['improvements']             = $data['improvements'];
        $reportcard['other_comments']           = $data['other_comments'];
        
        if (!$reportcard -> save())
        {
            $request->session()->flash('error', "There is an error updaing Report card.");
            return redirect()->route('tutor.reportcards.edit', $reportcard);
        }

        $request->session()->flash('success', "Report card updated successfully.");
        return redirect()->route('tutor.reportcards.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgressReport  $progressReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgressReport $reportcard)
    {
        if (Gate::denies('manage-report-cards')) return redirect()->route('tutor.reportcards.index');

        $reportcard->delete();
        return redirect()->route('tutor.reportcards.index');
    }
}
