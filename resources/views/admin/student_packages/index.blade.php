@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px"> Student Packages</i>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id = "mytable">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 180px;" class="text-center">
                                    @if ($data['order']['field'] == 'firstname' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.student_packages.index') }}?field=firstname&dir=desc&{{$data['url']}}" class="asc order">Student Name</a>
                                    @elseif ($data['order']['field'] == 'firstname' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.student_packages.index') }}?field=firstname&dir=asc&{{$data['url']}}" class="desc order">Student Name</a>
                                    @else
                                        <a href="{{route('admin.student_packages.index') }}?field=firstname&dir=asc&{{$data['url']}}" class="order">Student Name</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-center">
                                    @if ($data['order']['field'] == 'package_name' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.student_packages.index') }}?field=package_name&dir=desc&{{$data['url']}}" class="asc order">Package</a>
                                    @elseif ($data['order']['field'] == 'package_name' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.student_packages.index') }}?field=package_name&dir=asc&{{$data['url']}}" class="desc order">Package</a>
                                    @else
                                        <a href="{{route('admin.student_packages.index') }}?field=package_name&dir=asc&{{$data['url']}}" class="order">Package</a>
                                    @endif
                                </th>
                                <th scope="col" style="width: 150px;" class="text-center">
                                    @if ($data['order']['field'] == 'total_hours' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.student_packages.index') }}?field=total_hours&dir=desc&{{$data['url']}}" class="asc order">Total Hours</a>
                                    @elseif ($data['order']['field'] == 'total_hours' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.student_packages.index') }}?field=total_hours&dir=asc&{{$data['url']}}" class="desc order">Total Hours</a>
                                    @else
                                        <a href="{{route('admin.student_packages.index') }}?field=total_hours&dir=asc&{{$data['url']}}" class="order">Total Hours</a>
                                    @endif
                                </th>
                                <th scope="col" style="width: 150px;" class="text-center">                                    
                                    @if ($data['order']['field'] == 'left_hours' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.student_packages.index') }}?field=left_hours&dir=desc&{{$data['url']}}" class="asc order">Left Hours</a>
                                    @elseif ($data['order']['field'] == 'left_hours' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.student_packages.index') }}?field=left_hours&dir=asc&{{$data['url']}}" class="desc order">Left Hours</a>
                                    @else
                                        <a href="{{route('admin.student_packages.index') }}?field=left_hours&dir=asc&{{$data['url']}}" class="order">Left Hours</a>
                                    @endif
                                </th>
                                <th scope="col" style="width: 160px;" class="text-center">                                    
                                    @if ($data['order']['field'] == 'created_at' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.student_packages.index') }}?field=created_at&dir=desc&{{$data['url']}}" class="asc order">Date Purchased</a>
                                    @elseif ($data['order']['field'] == 'created_at' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.student_packages.index') }}?field=created_at&dir=asc&{{$data['url']}}" class="desc order">Date Purchased</a>
                                    @else
                                        <a href="{{route('admin.student_packages.index') }}?field=created_at&dir=asc&{{$data['url']}}" class="order">Date Purchased</a>
                                    @endif
                                </th>
                                <th scope="col" style="width: 140px;" class="text-right" >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['orders'] as $order)
                            <tr>
                                <td scope="col" class="text-center pl-1 pr-1">{{$order['firstname'] . ' ' . $order['lastname']}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$order['package_name']}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$order['total_hours']}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$order['left_hours']}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{date('d/m/Y', strtotime($order['created_at']))}}</td>
                                <td scope="col" class="text-right">
                                    @can('edit-users')
                                        [<a href="{{route('admin.student_packages.show', $order['id'])}}">Send Reminder</a>]
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
