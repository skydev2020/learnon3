@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header user font-weight-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Manage Sessions</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.sessions.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <label for="t_name" class="col-md-4 col-form-label text-md-right">{{ __('Tutor Name') }}</label>
                            <div class="col-md-6">
                                <input id="t_name" type="text" class="form-control" name="t_name"
                                value="  " autocomplete="t_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_name" class="col-md-4 col-form-label text-md-right">{{ __('Student Name') }}</label>
                            <div class="col-md-6">
                                <input id="s_name" type="text" class="form-control" name="s_name"
                                value="{{ $data['old']['s_name'] }}" autocomplete="s_name" autofocus>
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
                            <label for="date_submission" class="col-md-4 col-form-label text-md-right">{{ __('Date of Submission') }}</label>
                            <div class="col-md-6">
                                <input type = "date" class = "form-control" name = "date_submission"
                                 id = "date_submission" value = "{{ $data['old']['date_submission'] }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="session_date" class="col-md-4 col-form-label text-md-right">{{ __('Date of Session') }}</label>
                            <div class="col-md-6">
                                <input id="session_date" type="date" class="form-control" name="session_date"
                                 value="{{ $data['old']['session_date'] }}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href = "{{ route('admin.sessions.create') }}"> <button class="btn btn-primary">
                                {{ __('Log Hours') }}
                            </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Duration of Session</th>
                            <th scope="col">Date of Submission</th>
                            <th scope="col">Date of Session</th>
                            <th scope="col">Session Method</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['sessions'] as $session)
                            <tr>
                            <td scope="col">{{$session->assignments()->first()->tutor()['fname'] . ' '
                                 . $session->assignments()->first()->tutor()['lname']}}</td>
                                <td scope="col">{{$session->assignments()->first()->student()['fname'] . ' '
                                 . $session->assignments()->first()->student()['lname']}}</td>
                                <td scope="col">{{$data['session_durations'][$session->session_duration]}}</td>
                                <td scope="col">{{$session->date_submission}}</td>
                                <td scope="col">{{$session->session_date}}</td>
                                <td scope="col">{{$session->method}}</td>
                                <td scope="col">
                                    @can('edit-users')
                                        [<a href="{{route('admin.sessions.edit', $session->id)}}">Edit</a>]
                                        [<a href="{{route('admin.sessions.edit', $session->id)}}">Lock</a>]
                                        [<a href="{{route('admin.sessions.edit', $session->id)}}">Unlock</a>]
                                    @endcan

                                    @can('delete-users')
                                    <form action="{{ route('admin.sessions.destroy', $session) }}" method="post">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        [<a href="javascript:;" onclick="parentNode.submit();">Delete</a>]
      
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
