@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Rejected Tutors</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.rejectedtutors.index') }}">
                        @csrf
                        {{method_field('GET')}}
                        <div class="form-group row">
                            <label for="t_name" class="col-md-4 col-form-label text-md-right">{{ __('Tutor Name') }}</label>
                            <div class="col-md-6">
                                <input id="t_name" type="text" class="form-control" name="t_name" value="{{ $data['old']['t_name'] }}"
                                autocomplete="t_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ $data['old']['email'] }}"
                                autocomplete="email" autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="t_date" class="col-md-4 col-form-label text-md-right">{{ __('Date Added') }}</label>
                            <div class="col-md-6">
                                <input id="t_date" type="date" class="form-control" name="t_date" value="{{ $data['old']['t_date'] }}"
                                autocomplete="t_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
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
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['tutors'] as $tutor)
                            <tr>
                                <td scope="col">{{$tutor->fname . ' ' . $tutor->lname}}</td>
                                <td scope="col">{{$tutor->email}}</td>
                                <td scope="col">{{date('d/m/Y', strtotime($tutor->created_at)) }}</td>
                                <td scope="col">
                                    @can('edit-users')
                                        [<a href="{{route('admin.rejectedtutors.edit', $tutor->id)}}">Edit</a>]
                                    @endcan
                                    @can('manage-tutors')
                                        [<a href="{{route('admin.rejectedtutors.show', $tutor)}}">Contract</a>]
                                    @endcan
                                    @can('manage-tutors')
                                    <form action="{{ route('admin.rejectedtutors.destroy', $tutor) }}" method="POST" class="float-left">
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
