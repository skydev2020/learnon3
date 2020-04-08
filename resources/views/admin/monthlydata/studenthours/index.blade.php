@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-address-book" style="font-size:24px"> View Student Hours </i>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Student Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td scope="col">{{$student['fname'] . ' ' . $student['lname']
                                . ' ( ' . $student->id . ' )'}}</td>
                                <td scope="col">
                                    @can('manage-cms')
                                        [<a href="{{route('admin.studenthours.show', $student)}}">View Hours</a>]
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