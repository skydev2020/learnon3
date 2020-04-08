@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <i class="fas fa-address-book" style="font-size:24px"> View Tutor Hours</i>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tutors as $tutor)
                            <tr>
                                <td scope="col">{{$tutor['fname'] . ' ' . $tutor['lname']
                                . ' ( ' . $tutor->id . ' )'}}</td>
                                <td scope="col">
                                    @can('manage-cms')
                                        [<a href="{{route('admin.tutorhours.show', $tutor)}}">View Hours</a>]
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