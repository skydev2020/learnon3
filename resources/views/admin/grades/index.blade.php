@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Grades</div>
                <div class="card-body">
                    <form action="{{ route('admin.grades.create') }}">
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('ADD NEW GRADE') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Grade Name</th>
                            <th scope="col">Subjects</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($grades as $grade)
                            <tr>
                                <td scope="col">{{$grade->name}}</td>
                                <td scope="col">
                                    @foreach ($grade->subjects()->get() as $subject)
                                        {{$subject['name'] . ','}}
                                    @endforeach
                                </td>
                                <td scope="col">
                                    @can('manage-cms')
                                        [<a href="{{route('admin.grades.edit', $grade)}}">Edit</a>]
                                    @endcan
                                    @can('manage-cms')
                                    <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" class="float-left">
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