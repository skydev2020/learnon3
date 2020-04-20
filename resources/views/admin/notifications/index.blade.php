@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px"> Notifications</i>
                </div>

                <div class="card-body">
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-1 offset-11">
                                <a href="#">
                                    <button class="btn btn-primary">Delete</button>
                                </a>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input type="checkbox" class="text-center"
                                        onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                                    </th>
                                    <th scope="col">Notification From</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col" class="text-center">Date Received</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                <tr>
                                    <th scope="row">
                                        <input type="checkbox" name="selected[]" value="{{$notification->id}}"
                                        class="text-center"/>
                                    </th>
                                    <td scope="col"><?= $notification->from_user() == NULL ? '' :
                                    $notification->from_user()['fname'] . ' ' .
                                    $notification->from_user()['lname'] . ' [' .
                                    $notification->from_user()->roles()->first()['name'] . ']'?></td>
                                    <td scope="col">{{$notification->subject}}</td>
                                    <td scope="col" class="text-center">{{date('d/m/Y', strtotime($notification->created_at))}}</td>
                                    <td scope="col" class="text-center">
                                        @can('manage-cms')
                                            [<a href="{{route('admin.notifications.show', $notification)}}"
                                            >View</a>]
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
</div>
@endsection
