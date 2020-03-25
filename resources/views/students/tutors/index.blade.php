@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">My Tutors</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Subjects</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Assigned</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($assignments as $assignment)
                            <tr>
                                <td scope="col">{{$assignment->tutor()['fname'] . ' ' . $assignment->tutor()['lname']}}</td>
                                <td scope="col"><?php
                                    $subjects = "";
                                    foreach ($assignment->subjects()->get() as $subject)
                                    {
                                        $subjects .= $subject->name . ', ';
                                    }
                                    $subjects = rtrim($subjects, ', ');
                                    echo $subjects;
                                    ?></td>
                                <td scope="col">{{$assignment->status_by_student}}</td>
                                <td scope="col">{{date('Y-m-d', strtotime($assignment->assigned_at))}}</td>
                                <td scope="col">
                                    @can('manage-student-tutors')
                                    [<a href="{{route('student.tutors.show', $assignment)}}">View Details</a>]
                                    @endcan
                                    @can('manage-student-tutors')
                                    <form action="{{ route('student.tutors.update', $assignment) }}" method="POST" class="float-left">
                                        @csrf
                                        {{method_field('PUT')}}
                                        [<a href="javascript:;" onclick="parentNode.submit();">No More Tutoring</a>]
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