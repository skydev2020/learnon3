@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px;"> Report Card for Students/Parents</i>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('tutor.reportcards.index') }}">
                        @csrf
                        {{method_field('GET')}}
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="t_name" class="col-form-label font-weight-bold">{{ __('Tutor Name:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="t_name" type="text" class="form-control" name="t_name" value="{{ $data['old']['t_name'] }}"
                                autocomplete="t_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="grade" class="col-form-label font-weight-bold">{{ __('Grade:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="grade" type="text" class="form-control" name="grade" value="{{ $data['old']['grade'] }}"
                                autocomplete="grade" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="subjects" class="col-form-label font-weight-bold">{{ __('Subjects:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="subjects" type="text" class="form-control" name="subjects" value="{{ $data['old']['subjects'] }}"
                                autocomplete="subjects" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="date_received" class="col-form-label font-weight-bold">{{ __('Data Received:') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="date_received" type="date" class="form-control" name="date_received"
                                value="{{ $data['old']['date_received'] }}" autocomplete="date_received" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-1 offset-5">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Subjects</th>
                            <th scope="col">Date Received</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['reports'] as $report)
                            <tr>
                                <td scope="col">{{$report->tutors()->first()['fname']. ' ' . 
                                $report->tutors()->first()['lname']}}</td>
                                <td scope="col">{{$report->grades()->first()['name']}}</td>
                                <td scope="col">{{$report->subjects}}</td>
                                <td scope="col">{{date('m/d/Y', strtotime($report->created_at))}}</td>
                                <td scope="col">
                                    @can('manage-student-reports')
                                    [<a href="{{route('student.progressreports.show', $report)}}">View Report Card</a>]
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