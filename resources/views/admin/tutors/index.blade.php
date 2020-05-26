@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Tutors</i>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.tutors.index') }}">
                        @csrf
                        {{method_field('GET')}}
                        <div class="form-group row">
                            <label for="t_name" class="col-4 col-form-label text-right">{{ __('Tutor Name') }}</label>
                            <div class="col-6">
                                <input id="t_name" type="text" class="form-control" name="t_name" value="{{ $data['search']['t_name'] }}"
                                autocomplete="t_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-4 col-form-label text-right">{{ __('Email') }}</label>
                            <div class="col-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ $data['search']['email'] }}"
                                autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-4 col-form-label text-right">{{ __('Status') }}</label>
                            <div class="col-6">
                                <select style="display: inline-block;" id="status" name="status" class = "form-control">
                                    <option></option>
                                    <option value="1" {{($data['search']['status'] == '1') ? 'selected' : '' }}>Enabled</option>
                                    <option value="0" {{($data['search']['status'] == '0') ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="approved" class="col-4 col-form-label text-right">{{ __('Approved') }}</label>
                            <div class="col-6">
                                <select style="display: inline-block;" id="approved" name="approved" class = "form-control">
                                    <option></option>
                                    <option value="1" {{($data['search']['approved'] == '1') ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{($data['search']['approved'] == '0') ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="t_date" class="col-4 col-form-label text-right">{{ __('Date Registered') }}</label>
                            <div class="col-6">
                                <input id="t_date" type="date" class="form-control" name="t_date" value="{{ $data['search']['t_date'] }}"
                                autocomplete="t_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-1 offset-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>
                            <div class="col-7 text-right">
                                <a href="{{route('admin.tutors.create')}}">
                                    <button type = "button" class="btn btn-primary">Approve</button>
                                </a>
                                <a href="{{route('admin.tutors.create')}}">
                                    <button type = "button" class="btn btn-primary">Add</button>
                                </a>
                                <a href="javascript:;">                                
                                    <button class="btn btn-primary" id="del_btn">Delete</button>    
                                </a>
                            </div>
                        </div>
                        <div class = "form-group row mb-0">
                            <div class = "col-12 d-flex align-items-center justify-content-end">
                                <input type="checkbox" name = "names" id = "names" value = "yes">
                                <label class="form-check-label" for="names"> Tutor list </label>

                                <input type="checkbox" name = "emails" id = "emails" value = "yes">
                                <label class="form-check-label" for="emails"> Tutor emails </label>

                                <input type="checkbox" name = "referrers" id = "referrers" value = "yes">
                                <label class="form-check-label" for="referrers"> Contract/Agreement </label>
                                <button class="btn btn-primary left_margin" onclick="exportToExcel('tutors')">Export</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="tutors">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center pt-0 pl-1 pr-1" style="width: 20px;">
                                    <input type="checkbox" class="text-center"
                                    onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                                </th>
                                <th scope="col" style="width: 50px;" class="text-center">ID</th>
                                <th scope="col" style="width: 170px;" class="text-center">
                                    @if ($data['order']['field'] == 'fname' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.tutors.index') }}?field=fname&dir=desc&{{$data['url']}}" class="asc order">Tutor Name</a>
                                    @elseif ($data['order']['field'] == 'fname' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.tutors.index') }}?field=fname&dir=asc&{{$data['url']}}" class="desc order">Tutor Name</a>
                                    @else
                                        <a href="{{route('admin.tutors.index') }}?field=fname&dir=asc&{{$data['url']}}" class="order">Tutor Name</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-center">                                    
                                    @if ($data['order']['field'] == 'email' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.tutors.index') }}?field=email&dir=desc&{{$data['url']}}" class="asc order">Email</a>
                                    @elseif ($data['order']['field'] == 'email' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.tutors.index') }}?field=email&dir=asc&{{$data['url']}}" class="desc order">Email</a>
                                    @else
                                        <a href="{{route('admin.tutors.index') }}?field=email&dir=asc&{{$data['url']}}" class="order">Email</a>
                                    @endif
                                </th>
                                <th scope="col" style="width: 140px;" class="text-center">
                                    @if ($data['order']['field'] == 'status' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.tutors.index') }}?field=status&dir=desc&{{$data['url']}}" class="asc order">Status</a>
                                    @elseif ($data['order']['field'] == 'status' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.tutors.index') }}?field=status&dir=asc&{{$data['url']}}" class="desc order">Status</a>
                                    @else
                                        <a href="{{route('admin.tutors.index') }}?field=status&dir=asc&{{$data['url']}}" class="order">Status</a>
                                    @endif
                                </th>
                                <th scope="col" style="width: 100px;" class="text-center">
                                    @if ($data['order']['field'] == 'approved' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.tutors.index') }}?field=approved&dir=desc&{{$data['url']}}" class="asc order">Approved</a>
                                    @elseif ($data['order']['field'] == 'approved' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.tutors.index') }}?field=approved&dir=asc&{{$data['url']}}" class="desc order">Approved</a>
                                    @else
                                        <a href="{{route('admin.tutors.index') }}?field=approved&dir=asc&{{$data['url']}}" class="order">Approved</a>
                                    @endif
                                </th>
                                <th scope="col" style="width: 160px;" class="text-center">
                                    @if ($data['order']['field'] == 'created_at' && $data['order']['dir'] == 'asc')
                                        <a href="{{route('admin.tutors.index') }}?field=created_at&dir=desc&{{$data['url']}}" class="asc order">Date Added</a>
                                    @elseif ($data['order']['field'] == 'created_at' && $data['order']['dir'] == 'desc')
                                        <a href="{{route('admin.tutors.index') }}?field=created_at&dir=asc&{{$data['url']}}" class="desc order">Date Added</a>
                                    @else
                                        <a href="{{route('admin.tutors.index') }}?field=created_at&dir=asc&{{$data['url']}}" class="order">Date Added</a>
                                    @endif
                                </th>
                                <th scope="col" class="text-right" style="width: 390px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['tutors'] as $tutor)
                            <tr>
                                <th scope="row" class="text-center pr-0 pl-0">
                                    <input type="checkbox" name="selected[]" value="{{$tutor->id}}"
                                    class="text-center"/>
                                </th>
                                <th scope="row" class="font-weight-normal pl-1 pr-1 text-center">{{$tutor->id}}</th>
                                <td scope="col" class="text-center pl-1 pr-1">{{$tutor->fname . ' ' . $tutor->lname}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$tutor->email}}</td>
                                <td scope="col" class="text-center pl-1 pr-1"> <?=$tutor->status == 1? 'Enabled' : 'Disabled';?> </td>
                                <td scope="col" class="text-center pl-1 pr-1"> <?=$tutor->approved == 1? 'Yes' : 'No'; ?> </td>
                                <td scope="col" class="text-center pl-1 pr-1">{{date('d/m/Y', strtotime($tutor->created_at))}}</td>
                                <td scope="col" class="text-right">
                                    @can('edit-users')
                                        [<a href="{{route('admin.tutors.edit', $tutor)}}">Edit</a>]
                                    @endcan
                                    @can('manage-tutors')
                                        [<a href="{{route('admin.tutors.show', $tutor)}}" target="_blank">Contract</a>]
                                    @endcan

                                    @can('manage-tutors')
                                    <form action="{{ route('admin.tutors.destroy', $tutor) }}" method="POST" class="float-right">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        [<a href="javascript:;" onclick="parentNode.submit();">View Paycheques</a>]
                                    </form>
                                    @endcan

                                    @can('manage-tutors')
                                    <form action="{{ route('admin.tutors.destroy', $tutor) }}" method="POST" class="float-right">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        [<a href="javascript:;" onclick="parentNode.submit();">View Work</a>]
                                    </form>
                                    @endcan

                                    @can('manage-tutors')
                                    <form action="{{ route('admin.tutors.destroy', $tutor) }}" method="POST" class="float-left">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        [<a href="javascript:;" onclick="del(this)">Delete</a>]
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
