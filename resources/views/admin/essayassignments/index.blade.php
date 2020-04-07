@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header information font-weight-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Homework Assignments</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.essayassignments.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <label for="a_id" class="col-4 col-form-label text-right">{{ __('Assignment #') }}</label>
                            <div class="col-6">
                                <input id="a_id" type="text" class="form-control" name="a_id"
                                 value="{{ $data['old']['a_id'] }}" autocomplete="a_id" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_name" class="col-4 col-form-label text-right">{{ __('Student Name') }}</label>
                            <div class="col-6">
                                <input id="s_name" type="text" class="form-control" name="s_name"
                                value="{{ $data['old']['s_name'] }}" autocomplete="s_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="t_name" class="col-4 col-form-label text-right">{{ __('Tutor Name') }}</label>
                            <div class="col-6">
                                <input id="t_name" type="text" class="form-control" name="t_name"
                                 value="{{ $data['old']['t_name'] }}" autocomplete="t_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="topic" class="col-4 col-form-label text-right">{{ __('Topic') }}</label>
                            <div class="col-6">
                                <input id="topic" type="text" class="form-control" name="topic"
                                 value="{{ $data['old']['topic'] }}" autocomplete="topic" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-4 col-form-label text-right">Current Status</label>
                            <div class="col-6">
                                <select class = "form-control" name = "status" id = "status">
                                    <option></option>
                                    @foreach ($data['statuses'] as $essaystatus)
                                    <option value = {{$essaystatus->id}} <?= $essaystatus->id == $data['old']['status'] ? "selected" : ""?>>
                                        {{ $essaystatus->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price_owed" class="col-4 col-form-label text-right">{{ __('Price Paid') }}</label>
                            <div class="col-6">
                                <input id="price_owed" type="text" class="form-control" name="price_owed"
                                 value="{{ $data['old']['price_owed'] }}" autocomplete="price_owed" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="paid_to_tutor" class="col-4 col-form-label text-right">{{ __('Paid to Tutor') }}</label>
                            <div class="col-6">
                                <input id="paid_to_tutor" type="text" class="form-control" name="paid_to_tutor"
                                 value="{{ $data['old']['paid_to_tutor'] }}" autocomplete="status" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="a_date_from" class="col-4 col-form-label text-right">{{ __('Date Assigned') }}</label>
                            <div class="col-3">
                                Date From
                                <input id="a_date_from" type="date" class="form-control" name="a_date_from"
                                 value="{{ $data['old']['a_date_from'] }}" autofocus>
                            </div>
                            <div class="col-3">
                                Date To
                                <input id="a_date_to" type="date" class="form-control" name="a_date_to"
                                 value="{{ $data['old']['a_date_to'] }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="c_date_from" class="col-4 col-form-label text-right">{{ __('Date Completed') }}</label>
                            <div class="col-3">
                                Date From
                                <input id="c_date_from" type="date" class="form-control" name="c_date_from"
                                 value="{{ $data['old']['c_date_from'] }}" autofocus>
                            </div>
                            <div class="col-3">
                                Date To
                                <input id="c_date_to" type="date" class="form-control" name="c_date_to"
                                 value="{{ $data['old']['c_date_to'] }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-6 offset-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>

                    <div class="form-group row mb-0">
                        <div class="col-2 offset-4">
                            <a href = "{{ route('admin.essayassignments.create') }}">
                                <button class="btn btn-primary">
                                {{ __('ADD NEW ASSIGNMENT') }}
                            </button>
                            </a>
                        </div>
                        <div class = "col-1 offset-5">
                            <a href = "{{ route('admin.essayassignments.upload') }}">
                                <button class="btn btn-primary" type = "button">Batch Upload</button>
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
                            <th scope="col">Assignment #</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Current Status</th>
                            <th scope="col">Price Paid</th>
                            <th scope="col">Pait to Tutor</th>
                            <th scope="col">Date Assigned</th>
                            <th scope="col">Date Complete</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['essay_assignments'] as $essay_assignment)
                            <tr>
                                <td scope="col">{{'A' . $essay_assignment->assignment_num}}</td>
                                <td scope="col">{{$essay_assignment->students()->first()['fname'] . ' ' . $essay_assignment->students()->first()['lname']}}</td>
                                <td scope="col">{{$essay_assignment->tutors()->first()['fname'] . ' ' . $essay_assignment->tutors()->first()['lname']}}</td>
                                <td scope="col">{{$essay_assignment->topic}}</td>
                                <td scope="col">{{$essay_assignment->statuses()->first()['name']}}</td>
                                <td scope="col">{{$essay_assignment->owed}}</td>
                                <td scope="col">{{$essay_assignment->paid}}</td>
                                <td scope="col">{{date('m/d/Y', strtotime($essay_assignment->date_assigned))}}</td>
                                <td scope="col">{{$essay_assignment->date_completed}}</td>
                                <td scope="col">
                                    @can('manage-tutors')
                                        [<a href="{{route('admin.essayassignments.edit', $essay_assignment->id)}}">Edit</a>]
                                    @endcan

                                    @can('manage-tutors')
                                    <form action="{{ route('admin.essayassignments.destroy', $essay_assignment) }}"
                                     method="post" class = "float-left">
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
