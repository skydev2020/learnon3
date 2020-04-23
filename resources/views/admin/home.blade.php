@extends('layouts.app')

@section('content')
<div class="container-fluid home-page">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-home" style="font-size:24px"> Control Panel</i>
                </div>

                <div class="card-body">
                    <div class="d-flex">
                        <div class="col-6">
                            <div class="container-fluid notification-header pt-1 pb-1 text-white">
                                <div class="row">
                                    <div class="col-9">Latest Notifications</div>
                                    <div class="col-3 text-right">
                                        <a class="text-white" href="{{route('admin.notifications.index')}}">
                                            View All
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid pt-3 notification-panel">                            
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Notification From</th>
                                            <th scope="col">Subject</th>
                                            <th scope="col" class="text-center">Date Received</th>
                                            <th scope="col" class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data['notifications'] as $notification)
                                        <tr>
                                            <td scope="col">
                                                @if (isset($notification->username))
                                                    {{$notification->fname . ' ' . $notification->lname}}
                                                @else
                                                    <?= $notification->from_user() == NULL ? '' :
                                                    $notification->from_user()['fname'] . ' ' .
                                                    $notification->from_user()['lname'] . ' [' .
                                                    $notification->from_user()->roles()->first()['name'] . ']'?>
                                                @endif
                                            </td>
                                            <td scope="col">
                                                @if (isset($notification->username))
                                                New Registration
                                                @else
                                                <?php echo html_entity_decode($notification->message); ?>
                                                @endif
                                            </td>
                                            <td scope="col" class="text-center">{{date('d/m/Y', strtotime($notification->created_at))}}</td>
                                            <td scope="col" class="text-right">
                                                @if (isset($notification->username))
                                                    [<a href="{{route('admin.students.edit', $notification)}}"
                                                    >Edit</a>]
                                                @else
                                                    [<a href="{{route('admin.notifications.show', $notification)}}"
                                                    >View</a>]
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="container-fluid overview-header pt-1 pb-1 text-white">
                                <div class="row">
                                    <div class="col-12">Overview</div>
                                </div>
                            </div>
                            <div class="container-fluid pt-3 overview-panel">                            
                                <table class="table table-bordered table-striped">                                  
                                    <tbody>
                                    @foreach ($data['overview'] as $key => $value)
                                        <tr>
                                            <td scope="col">{{$key}}</td>
                                            <td scope="col" class="text-right">{{$value}}</td>
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
    </div>
</div>
@endsection
