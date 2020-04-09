@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-address-book" style="font-size:24px"> Students</i>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.students.index') }}">
                        @csrf
                        {{method_field('GET')}}
                        <div class="form-group row">
                            <label for="s_name" class="col-4 col-form-label text-md-right">{{ __('Student Name') }}</label>
                            <div class="col-6">
                                <input id="s_name" type="text" class="form-control" name="s_name" value="{{ $data['old']['s_name'] }}"
                                autocomplete="s_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_city" class="col-4 col-form-label text-md-right">{{ __('City') }}</label>
                            <div class="col-6">
                                <input id="s_city" type="text" class="form-control" name="s_city" value="{{ $data['old']['s_city'] }}"
                                autocomplete="s_city" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_sub" class="col-4 col-form-label text-md-right">{{ __('Subjects') }}</label>
                            <div class="col-6">
                                <input id="s_sub" type="text" class="form-control" name="s_sub" value="{{ $data['old']['s_sub'] }}"
                                autocomplete="s_sub" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_status" class="col-4 col-form-label text-md-right">{{ __('Status') }}</label>
                            <div class="col-6">
                                <select style="display: inline-block;" id="s_status_id" name="s_status_id" class = "form-control">
                                    <option></option>
                                    @foreach ($data['student_statuses'] as $key => $value)
                                    <option value="{{ $value->id }}" {{ ( $value->id == $data['old']['s_status_id']) ? 'selected' : '' }}>
                                        {{ $value->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_date" class="col-4 col-form-label text-md-right">{{ __('Date Registered') }}</label>
                            <div class="col-6">
                                <input id="s_date" type="date" class="form-control" name="s_date" value="{{ $data['old']['s_date'] }}"
                                autocomplete="s_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-1 offset-5">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>
                            <div class="col-1 offset-5">
                                <a href = "{{route('admin.students.create')}}">
                                    <button type = "button" class="btn btn-primary" >Add</button>
                                </a>
                            </div>
                        </div>

                        <div class = "form-group row mb-0">
                        
                            <div class = "col-4 offset-8  align-items-center">
                                <input type="checkbox" name = "names" id = "names" value = "yes">
                                <label class="form-check-label" for="names"> Student list </label>
                            
                                <input type="checkbox" name = "emails" id = "emails" value = "yes">
                                <label class="form-check-label" for="emails"> Student emails </label>
                            
                                <input type="checkbox" name = "referrers" id = "referrers" value = "yes">
                                <label class="form-check-label" for="referrers">Where they heard about us?</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button class="btn btn-primary" onclick="exportToExcel('students')">Export</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">

                    <table class="table table-bordered table-striped" id = "students">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">City</th>
                            <th scope="col">Subjects</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tutoring Service</th>
                            <th scope="col">Date Registered</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['students'] as $student)
                            <tr>
                                <th scope="row">{{$student->id}}</th>
                                <td scope="col">{{$student->fname . ' ' . $student->lname}}</td>
                                <td scope="col">{{$student->city}}</td>
                                <td scope="col"><?php
                                    $subjects = "";
                                    foreach ($student->subjects()->get() as $subject)
                                    {
                                        $subjects .= $subject->name . ', ';
                                    }
                                    $subjects = rtrim($subjects, ', ');
                                    echo $subjects;?></td>
                                <td scope="col">{{$student->studentStatus()->first()['title']}}</td>
                                <td scope="col">{{$student->service_method}}</td>
                                <td scope="col">{{date('d/m/Y', strtotime($student->created_at))}}</td>
                                <td scope="col">
                                    @can('manage-students')
                                        [<a href="{{route('admin.students.show', $student->id)}}">View</a>]
                                    @endcan
                                    @can('manage-students')
                                        [<a href="{{route('admin.students.edit', $student->id)}}">Edit</a>]
                                    @endcan
                                    @can('manage-students')
                                        [<a href="{{route('admin.students.invoices', $student)}}">Invoices</a>]
                                    @endcan
                                    @can('manage-students')
                                        [<a href="{{route('admin.students.contract', $student)}}" target="_blank">Contract</a>]
                                    @endcan
                                    @can('manage-students')
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="float-left">
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
<!-- Scripts -->
@section("jssection")
<script src="{{ asset('js/export.js')}}"></script>
@stop