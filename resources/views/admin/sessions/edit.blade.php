@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style = "text-align:center;">{{ __('Update Session Details') }}</div>
                <div class="card-body">
                    <form action="{{route('admin.sessions.update', $data['session'])}}" method="POST">

                        <div class="form-group row">
                            <label for="assignment_id" class="col-md-4 col-form-label text-md-right">{{ __('Select Tutor: ') }}</label>

                            <div class="col-md-5">
                                <select name = "assignment_id" id = "assignment_id" class = "form-control">
                                @foreach ($data['assignments'] as $assignment)
                                    <option value = {{$assignment->id}} <?=$assignment->id == $data['session']->assignment_id
                                         ? ' selected="selected"' : '';?> >
                                         {{$assignment->tutor()['fname'] . ' ' . $assignment->tutor()['lname']
                                          . ' ( ' . $assignment->base_wage . ' ) => '
                                           . $assignment->student()['fname'] . $assignment->student()['lname']
                                            . ' ( ' . $assignment->base_invoice . ')' }}  </option>

                                @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="session_date" class="col-md-4 col-form-label text-md-right">{{ __('Date of Session:') }}</label>

                            <div class="col-md-5">
                                <input type = "date" value = {{ $data['session']->session_date }} id = "session_date"
                                 name = "session_date">
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}

                        <div class="form-group row">
                            <label for="session_duration" class="col-md-4 col-form-label text-md-right">
                            {{ __('Duration of Session:') }} </label>

                            <div class="col-md-5">
                                <input type = "text" value = {{ $data['session']->session_duration }} id = "session_duration"
                                 name = "session_duration">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="notes" class="col-md-4 col-form-label text-md-right">
                            {{ __('Notes about session or student progress:') }} </label>

                            <div class="col-md-5">
                                <input type = "text" value = {{ $data['session']->session_notes }} id = "notes"
                                 name = "notes">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </form>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection