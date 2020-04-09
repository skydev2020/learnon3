@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px;"> Update Session Details</i>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('tutor.sessions.update', $data['session']) }}">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group row mb-0">
                            <div class="col-1 offset-10">
                                <button type = "submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                            <div class="col-1">
                                <a href = "{{route('tutor.sessions.index')}}">
                                    <button type = "button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="student" class="col-form-label font-weight-bold">{{ __('Select a student:') }}</label>
                            </div>
                            <div class="col-6">
                                <select id = "student" name = "student" class = "form-control">
                                    @foreach ($data['students'] as $student)
                                    <option <?= $data['session']->assignments()->first()->student()['id']==$student->id?"selected":"" ?>
                                    value = "{{$student->id}}">{{$student->fname . ' ' . $student->lname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="session_date" class="col-form-label font-weight-bold">Date of Session:</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="session_date" type="date" class="form-control" name="session_date"
                                value="{{ $data['session']->session_date }}" autocomplete="session_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="session_duration" class="col-form-label font-weight-bold">Duration of Session:</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select name = "session_duration" id = "session_duration" class = "form-control">
                                    @foreach ($data['durations'] as $key => $value)
                                    <option <?= $key == $data['session']->session_duration ? "selected" : "" ?>
                                    value = "{{$key}}"> {{$value}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="session_notes" class="col-form-label font-weight-bold">{{ __('Notes:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <textarea name = "session_notes" id = "session_notes" class = "form-control inputstl"
                                autocomplete="session_notes" autofocus>{{ $data['session']->session_notes }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
