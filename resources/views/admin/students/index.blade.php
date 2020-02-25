@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Students</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.students.show', $students[0]) }}">
                        @csrf
                        {{method_field('GET')}}
                        <div class="form-group row">
                            <label for="s_name" class="col-md-4 col-form-label text-md-right">{{ __('Student Name') }}</label>
                            <div class="col-md-6">
                                <input id="s_name" type="text" class="form-control" name="s_name" value="{{ old('s_name') }}"
                                autocomplete="s_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
                            <div class="col-md-6">
                                <input id="s_city" type="text" class="form-control" name="s_city" value="{{ old('s_city') }}"
                                autocomplete="s_city" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_sub" class="col-md-4 col-form-label text-md-right">{{ __('Subjects') }}</label>
                            <div class="col-md-6">
                                <input id="s_sub" type="text" class="form-control" name="s_sub" value="{{ old('s_sub') }}"
                                autocomplete="s_sub" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                            <div class="col-md-6">
                                <select style="display: inline-block;" id="s_status" class = "form-control">
                                    <option></option>
                                    <option>Need Tutoring</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_date" class="col-md-4 col-form-label text-md-right">{{ __('Date Registered') }}</label>
                            <div class="col-md-6">
                                <input id="s_date" type="date" class="form-control" name="s_date" value="{{ old('s_date') }}"
                                autocomplete="s_date" autofocus>
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

                </div>
            </div>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">City</th>
                            <th scope="col">Subjects</th>
                            <th scope="col">Date Registered</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <th scope="row">{{$student->id}}</th>
                                <td scope="col">{{$student->fname . ' ' . $student->lname}}</td>
                                <td scope="col">{{$student->email}}</td>
                                <td scope="col">{{$student->city}}</td>
                                <td scope="col">{{$student->subjects}}</td>
                                <td scope="col">{{$student->created_at}}</td>
                                <td scope="col">
                                    @can('edit-users')
                                        <a href="{{route('admin.users.edit', $student->id)}}"><button type="button" class="btn btn-primary float-left">Edit</button></a>
                                    @endcan
                                    @can('delete-users')
                                    <form action="{{ route('admin.users.destroy', $student) }}" method="POST" class="float-left">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-warning">Delete</button>
                                    </form>
                                    @endcan
                                    @can('edit-users')
                                        <a href="{{route('admin.students.edit', $student)}}" target="_blank"><button type="button" class="btn btn-primary float-left">Contract</button></a>
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
