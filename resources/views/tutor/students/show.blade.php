@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Student Details</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label for = "sname" class="col-form-label">{{ __('Student Name:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$data['student']->fname . ' ' . $data['student']->lname}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Email Address:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ $data['student']->email }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Tutor pay rate($):') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ $data['assignment']->base_wage . ' per hour' }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Subject(s) Assigned:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$data['subjects']}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Telephone:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$data['student']->home_phone}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Cellphone:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$data['student']->cell_phone}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __("Address:") }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$data['student']->address}} <br>
                            {{$data['student']->city . ','. $data['student']->state()->first()['code']}} <br>
                            {{"Postal/Zip Code - " . $data['student']->pcode}} <br>
                            {{$data['student']->country()->first()['name']}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Date Assigned:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ date('d/m/Y', strtotime($data['assignment']->assigned_at)) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Status:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$data['assignment']->status_by_tutor}}
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class = "col-1 offset-11">
                            <a href = "{{ route('tutor.students.index') }}">
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