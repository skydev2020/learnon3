@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Homework Assignments</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tutor.essays.update', $data['essay']) }}">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group row mb-0">
                            <div class = "col-1 offset-10">
                                <button type = "submit" class = "btn btn-primary">Save</button>
                            </div>
                            <div class = "col-1">
                                <a href = "{{ route('tutor.essays.index') }}">
                                    <button type = "button" class = "btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('Assignment #') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{$data['essay']->assignment_num}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('Topic:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{ $data['essay']->topic }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('Description:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{ $data['essay']->description }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('File Format:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{$data['essay']->format}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('Pay to Tutor:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{'$' . $data['essay']->paid}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('Date Assigned:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{$data['essay']->date_assigned}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "date_completed" class="col-form-label">
                                {{ __("What are student's main weaknesses?") }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <input id = "date_completed" name = "date_completed" class = "form-control" type = "date"
                                 value = "{{ date("Y-m-d", strtotime( $data['essay']->date_completed )) }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "listen_to_suggestions" class="col-form-label">{{ __('Due Date:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{ date("Y-m-d", strtotime( $data['essay']->date_due )) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div for="status" class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label" for = "status">{{ __('Status:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <select id = "status" name = "status" class = "form-control">
                                    @foreach ($data['statuses'] as $status)
                                    <option <?=$status->id == $data['essay']->status_id ? "selected" : "" ?> value = "{{ $status->id }}">
                                    {{$status->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection