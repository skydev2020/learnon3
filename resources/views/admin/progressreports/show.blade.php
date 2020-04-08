@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-address-book" style="font-size:24px"> View Progress Report</i>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Tutor Name:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$progressreport->tutors()->first()['fname'] . ' ' .
                             $progressreport->tutors()->first()['lname']}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Student Name:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$progressreport->students()->first()['fname'] . ' ' .
                             $progressreport->students()->first()['lname']}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Grade:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ $progressreport->grades()->first()['name'] }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Subjects:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ $progressreport->subjects }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">
                            {{ __('Is the Student Prepared For Sessions?:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            <?= $progressreport->student_prepared > 0 ? "Yes" : "No" ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">
                            {{ __('Does the student have questions ready?:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            <?= $progressreport->questions_ready > 0 ? "Yes" : "No" ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">
                            {{ __('Does the Student Pay Attention?:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            <?= $progressreport->pay_attention > 0 ? "Yes" : "No" ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">
                            {{ __("What are student's main weaknesses?:") }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ $progressreport->weaknesses }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">
                            {{ __('Does the student listen to suggestions given?') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            <?= $progressreport->listen_to_suggestions > 0 ? "Yes" : "No" ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">
                            {{ __('What improvements have you seen?') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ $progressreport->improvements }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">
                            {{ __('Any other comment about the sessions & student?') }} </br>
                            <em>(Observations General Notes on Progress, suggestions etc.)</em>
                            </label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ $progressreport->other_comments }}
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-6 offset-md-4">
                            <a href = "{{route('admin.progressreports.index')}}" >
                                <button type = "button" class="btn btn-primary">
                                    {{ __('Back') }}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection