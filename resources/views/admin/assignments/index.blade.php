@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Assigned Students') }}</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.assignments.index') }}">
                        @csrf
                        {{method_field('GET')}}
                        <div class="form-group row">
                            <label for="a_id" class="col-md-4 col-form-label text-md-right">{{ __('ID') }}</label>
                            <div class="col-md-6">
                                <input id="a_id" type="text" class="form-control" name="a_id" value="{{ old('a_id') }}"
                                autocomplete="a_id" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_name" class="col-md-4 col-form-label text-md-right">{{ __('Student Name') }}</label>
                            <div class="col-md-6">
                                <input id="s_name" type="text" class="form-control" name="s_name" value="{{ old('s_name') }}"
                                autocomplete="s_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="t_name" class="col-md-4 col-form-label text-md-right">{{ __('Tutor Name') }}</label>
                            <div class="col-md-6">
                                <input id="t_name" type="text" class="form-control" name="t_name" value="{{ old('t_name') }}"
                                autocomplete="t_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="a_date" class="col-md-4 col-form-label text-md-right">{{ __('Date Registered') }}</label>
                            <div class="col-md-6">
                                <input id="a_date" type="date" class="form-control" name="a_date" value="{{ old('a_date') }}"
                                autocomplete="a_date" autofocus>
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
                            <a href = "{{ route('admin.assignments.create') }}"> <button class="btn btn-primary">
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
                            <th scope="col">ID</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Subjects</th>
                            <th scope="col">Date Assigned</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($assignments as $assignment)
                            <tr>
                                <th scope="row"> {{$assignment->id}}</th>
                                <td scope="col">{{$assignment->student() != null ? $assignment->student()['fname'] . ' ' . $assignment->student()['lname'] : "" }}</td>
                                <td scope="col">{{$assignment->tutor() != null ? $assignment->tutor()['fname'] . ' ' . $assignment->tutor()['lname'] : ""}}</td>
                                <td scope="col">{{$assignment->subjects}}</td>
                                <td scope="col">{{$assignment->created_at}}</td>
                                <td scope="col">
                                    @can('edit-users')
                                        <a href="{{route('admin.assignments.edit', $assignment->id)}}"><button type="button" class="btn btn-primary float-left">Edit</button></a>
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
