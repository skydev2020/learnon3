@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Tutor Details</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Tutor Name:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$assignment->tutor()['fname'] . ' ' . $assignment->tutor()['lname']}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Email Address:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ $assignment->tutor()['email'] }}
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Subject(s) Assigned:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            <?php
                                $subjects = "";
                                foreach ($assignment->subjects()->get() as $subject)
                                {
                                    $subjects .= $subject->name . ', ';
                                }
                                $subjects = rtrim($subjects, ', ');
                                echo $subjects;?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Telephone:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$assignment->tutor()['home_phone']}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Cellphone:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$assignment->tutor()['cell_phone']}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __("Address:") }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$assignment->tutor()['address']}} <br>
                            {{$assignment->tutor()['city'] . ','. $assignment->tutor()->state()->first()['code']}} <br>
                            {{"Postal/Zip Code - " . $assignment->tutor()['pcode']}} <br>
                            {{$assignment->tutor()->country()->first()['name']}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Date Assigned:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ date('d/m/Y', strtotime($assignment->assigned_at)) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Status:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$assignment->status_by_student}}
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class = "col-1 offset-11">
                            <a href = "{{ route('student.tutors.index') }}">
                                <button type = "button" class = "btn btn-primary">Back</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection