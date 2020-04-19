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
                                <input id="t_name" type="text" class="form-control" name="t_name" value="{{ $data['old']['t_name'] }}"
                                autocomplete="t_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-4 col-form-label text-right">{{ __('Email') }}</label>
                            <div class="col-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ $data['old']['email'] }}"
                                autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-4 col-form-label text-right">{{ __('Status') }}</label>
                            <div class="col-6">
                                <select style="display: inline-block;" id="status" name="status" class = "form-control">
                                    <option></option>
                                    <option>Enabled</option>
                                    <option>Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="approved" class="col-4 col-form-label text-right">{{ __('Approved') }}</label>
                            <div class="col-6">
                                <select style="display: inline-block;" id="approved" name="approved" class = "form-control">
                                    <option></option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="t_date" class="col-4 col-form-label text-right">{{ __('Date Registered') }}</label>
                            <div class="col-6">
                                <input id="t_date" type="date" class="form-control" name="t_date" value="{{ $data['old']['t_date'] }}"
                                autocomplete="t_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-1 offset-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>
                            <div class="col-1 offset-4 text-right">
                                <a href="{{route('admin.tutors.create')}}">
                                    <button type = "button" class="btn btn-primary">Add</button>
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Approved</th>
                            <th scope="col">Date Added</th>
                            <th scope="col" class="text-right">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['tutors'] as $tutor)
                            <tr>
                                <th scope="row" class="font-weight-normal">{{$tutor->id}}</th>
                                <td scope="col">{{$tutor->fname . ' ' . $tutor->lname}}</td>
                                <td scope="col">{{$tutor->email}}</td>
                                <td scope="col" value = {{$tutor->status}}> <?=$tutor->status == 1? 'Enabled' : 'Disabled';?> </td>
                                <td scope="col"> <?=$tutor->approved == 1? 'Yes' : 'NO'; ?> </td>
                                <td scope="col">{{$tutor->created_at}}</td>
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
