@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Activity Log</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">User Name:</th>
                            <th scope="col">User Group</th>
                            <th scope="col">Activity</th>
                            <th scope="col">Date of Activity</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($activitylogs as $activitylog)
                            <tr>
                                <td scope="col">{{$activitylog->users()->first()['fname']. ' ' . 
                                $activitylog->users()->first()['lname']}}</td>
                                <td scope="col">{{$activitylog->users()->first()->roles()
                                ->first()['name']}}</td>
                                <td scope="col">{{$activitylog->activity}}</td>
                                <td scope="col">{{$activitylog->created_at}}</td>
                                <td scope="col">
                                    @can('manage-cms')
                                        [<a href="{{route('admin.activitylogs.show', $activitylog)}}">View</a>]
                                    @endcan
                                    @can('manage-cms')
                                    <form action="{{ route('admin.activitylogs.destroy', $activitylog) }}" method="POST" class="float-left">
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