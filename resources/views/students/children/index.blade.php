@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-address-book" style="font-size:24px;"> Add another student to account</i>
                </div>
                <div class="card-body">
                    <div class = "form-group row">
                        <div class = "col-1 offset-11">
                            <a href = "{{route('student.children.create')}}">
                                <button type = "button" class = "btn btn-primary">Add</button>
                            </a>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Student Name</th>
                            <th scope="col">City</th>
                            <th scope="col">Subjects</th>
                            <th scope="col">Tutoring Status</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($children as $user)
                            <tr>
                                <td scope="col">{{$user->fname . ' ' . $user->lname}}</td>
                                <td scope="col">{{$user->city}}</td>
                                <td scope="col"><?php
                                    $subjects = "";
                                    foreach ($user->subjects()->get() as $subject)
                                    {
                                        $subjects .= $subject->name . ', ';
                                    }
                                    $subjects = rtrim($subjects, ', ');
                                    echo $subjects;?></td>
                                <td scope="col">{{$user->studentstatus()->first()['title']}}</td>
                                <td scope="col">{{date('d/m/y', strtotime($user->created_at))}}</td>
                                <td scope="col">
                                    @can('manage-add-student')
                                    [<a href="{{route('student.children.show', $user)}}">Switch Profile</a>]
                                    @endcan
                                    @can('manage-add-student')
                                    <form action="{{ route('student.children.destroy', $user) }}" method="POST" class="float-left">
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