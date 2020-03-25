@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">View Progress Report</div>
                <div class="card-body">
                    
                        <div class="form-group row mb-0">
                            <div class = "col-1 offset-11">
                                <a href = "{{ route('student.progressreports.index') }}">
                                    <button type = "button" class = "btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('Tutor Name:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{$report->tutors()->first()['fname'] . ' ' . $report->tutors()->first()['lname']}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('Grade:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{ $report->grades()->first()['name'] }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('Subjects:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{ $report->subjects }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "student_prepared" class="col-form-label">
                                {{ __('Is the Student Prepared For Sessions?') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <?= $report->student_prepared == 1? "YES" : "NO"; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "questions_ready" class="col-form-label">
                                {{ __('Does the student have questions ready?') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <?= $report->questions_ready == 1? "YES" : "NO"; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "pay_attention" class="col-form-label">
                                {{ __('Does the Student Pay Attention?') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <?= $report->pay_attention == 1? "YES" : "NO"; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "weaknesses" class="col-form-label">
                                {{ __("What are student's main weaknesses?") }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{ $report->weaknesses }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "listen_to_suggestions" class="col-form-label">
                                {{ __('Does the student listen to suggestions given?') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <?= $report->listen_to_suggestions == 1? "YES" : "NO"; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div for="improvements" class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">
                                {{ __('What improvements have you seen?') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{ $report->improvements }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "other_comments" class="col-form-label">
                                {{ __('Any other comment about the sessions & student?') }} </br>
                                <em>(Observations General Notes on Progress, suggestions etc.)</em>
                                </label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{ $report->other_comments }}
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection