@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Tutor Assignments') }}</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.tutorassignments.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <label for="t_name" class="col-md-4 col-form-label text-md-right">{{ __('Tutor Name') }}</label>
                            <div class="col-md-6">
                                <input id="t_name" type="text" class="form-control" name="t_name"
                                 value="{{ $data['old']['t_name'] }}" autocomplete="t_name" autofocus>
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
                            <label for="a_date" class="col-md-4 col-form-label text-md-right">{{ __('Date Assigned') }}</label>
                            <div class="col-md-6">
                                <input id="a_date" type="date" class="form-control" name="a_date"
                                 value="{{ $data['old']['a_date'] }}" autocomplete="a_date" autofocus>
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
                            <a href = "{{ route('admin.tutorassignments.create') }}"> <button class="btn btn-primary">
                                {{ __('ADD NEW ASSIGNMENT') }}
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
                            <th scope="col">Subjects</th>
                            <th scope="col">Date Assigned</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['assignments'] as $assignment)
                            <tr>
                                <td scope="col">{{$assignment->tutor()['fname'] . ' ' . $assignment->tutor()['lname']}}</td>
                                <td scope="col">{{$assignment->student()['fname'] . ' ' . $assignment->student()['lname']}}</td>
                                <td scope="col">{{$assignment->subjects}}</td>
                                <td scope="col">{{$assignment->created_at}}</td>
                                <td scope="col">
                                    @can('edit-users')
                                        <a href="{{route('admin.tutorassignments.edit', $assignment->id)}}"><button type="button" class="btn btn-primary float-left">Edit</button></a>
                                    @endcan

                                    @can('delete-users')
                                    <form action="{{ route('admin.tutorassignments.destroy', $assignment) }}" method="POST" class="float-left">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-warning">Delete</button>
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
