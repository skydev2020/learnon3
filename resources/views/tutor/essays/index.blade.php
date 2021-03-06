@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px;"> Homework Assignments</i>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Assignment #</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Current Status</th>
                            <th scope="col">Date Assigned</th>
                            <th scope="col">Date completed</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($essays as $essay)
                            <tr>
                                <td scope="col">{{'A' . $essay->assignment_num}}</td>
                                <td scope="col">{{$essay->topic}}</td>
                                <td scope="col">{{$essay->statuses()->first()['name']}}</td>
                                <td scope="col">{{date('Y-m-d', strtotime($essay->date_assigned))}}</td>
                                <td scope="col">{{date('Y-m-d', strtotime($essay->date_completed))}}</td>
                                <td scope="col">
                                    @can('manage-essay')
                                    [<a href="{{route('tutor.essays.edit', $essay)}}">View/Edit</a>]
                                    @endcan

                                    @can('manage-essay')
                                    [<a href = "{{route('tutor.essays.show', $essay)}}">Upload Assignment</a>]
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