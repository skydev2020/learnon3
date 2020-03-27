@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Log Hours</div>
                <div class="card-body">
                <form method="POST" action="{{ route('tutor.sessions.store') }}">
                        @csrf
                        {{method_field('POST')}}
                        <div class="form-group row mb-0">
                            <div class="col-1 offset-10">
                                <button type = "submit" class="btn btn-primary">
                                    {{ __('Save') }}
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
                                    <option></option>
                                    @foreach ($data['students'] as $student)
                                    <option value = "{{$student->id}}">{{$student->fname . ' ' . $student->lname}}</option>
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
                                autocomplete="session_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="session_duration" class="col-form-label font-weight-bold">Duration of Session:</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select name = "session_duration" id = "session_duration" class = "form-control">
                                    <option></option>
                                    @foreach ($data['durations'] as $key => $value)
                                    <option value = "{{$key}}"> {{$value}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="session_notes" class="col-form-label font-weight-bold">{{ __('Notes about session or student progress:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <textarea name = "session_notes" id = "session_notes" class = "form-control inputstl"
                                autocomplete="session_notes" autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="method" class="col-form-label font-weight-bold">{{ __('Select Tutoring Method:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select name = "method" id = "method" class = "form-control">
                                    <option>Home</option>
                                    <option>Online</option>
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
