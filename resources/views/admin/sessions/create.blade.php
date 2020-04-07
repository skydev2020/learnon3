@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header user font-weight-bold" >$nbsp;$nbsp;$nbsp;$nbsp;$nbsp;$nbsp;Log Hours</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.sessions.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <label for="assignment_id" class="col-md-4 col-form-label text-md-right">{{ __('Select Tutor: ') }}</label>

                            <div class="col-md-5">
                                <select name = "assignment_id" id = "assignment_id" class = "form-control">
                                <option></option>
                                @foreach ($data['assignments'] as $assignment)
                                    <option value = {{$assignment->id}} >
                                         {{$assignment->tutor()['fname'] . ' ' . $assignment->tutor()['lname']
                                          . ' ( ' . $assignment->base_wage . ' ) => '
                                           . $assignment->student()['fname'] . $assignment->student()['lname']
                                            . ' ( ' . $assignment->base_invoice . ')' }}  </option>

                                @endforeach
                                </select>
                            </div>
                        </div>

                        <<div class="form-group row">
                            <label for="session_date" class="col-md-4 col-form-label text-md-right">{{ __('Date of Session:') }}</label>

                            <div class="col-md-5">
                                <input type = "date" id = "session_date" name = "session_date">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="session_duration" class="col-md-4 col-form-label text-md-right">{{ __('Duration of Session') }}</label>
                            <div class="col-md-6">
                                <select id = "session_duration" name = "session_duration" class = "form-control">
                                    <option></option>
                                    @foreach ($data['session_durations'] as $duration)
                                        <option> {{$duration}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="notes" class="col-md-4 col-form-label text-md-right">
                            {{ __('Notes about session or student progress:') }} </label>

                            <div class="col-md-5">
                                <input type = "text" id = "notes" name = "notes">
                            </div>
                        </div> 

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('SAVE') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
