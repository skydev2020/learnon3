@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Tutor Assignments</i>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.tutorassignments.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <label for="t_name" class="col-4 col-form-label text-right">{{ __('Tutor Name') }}</label>
                            <div class="col-6">
                                <input id="t_name" type="text" class="form-control" name="t_name"
                                 value="{{ $data['old']['t_name'] }}" autocomplete="t_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_name" class="col-4 col-form-label text-right">{{ __('Student Name') }}</label>
                            <div class="col-6">
                                <input id="s_name" type="text" class="form-control" name="s_name"
                                 value="{{ $data['old']['s_name'] }}" autocomplete="s_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="a_date" class="col-4 col-form-label text-right">{{ __('Date Assigned') }}</label>
                            <div class="col-6">
                                <input id="a_date" type="date" class="form-control" name="a_date"
                                 value="{{ $data['old']['a_date'] }}" autocomplete="a_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-1 offset-4">
                                <button type = "submit" class="btn btn-primary">Search</button>
                            </div>
                            <div class="col-1 offset-6">
                                <a href = "{{ route('admin.tutorassignments.create') }}">
                                    <button class="btn btn-primary" type="button">Add</button>
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
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Subjects</th>
                            <th scope="col">Date Assigned</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['assignments'] as $assignment)
                            <tr>
                                <td scope="col"><?= $assignment->tutor() == NULL ? '' :
                                $assignment->tutor()['fname'] . ' ' . $assignment->tutor()['lname']?></td>
                                <td scope="col"><?= $assignment->student() == NULL ? '' :
                                $assignment->student()['fname'] . ' ' . $assignment->student()['lname']?></td>
                                <td scope="col"><?php $subjects = "";
                                    foreach ($assignment->subjects()->get() as $subject)
                                    {
                                        $subjects .= $subject->name . ', ';
                                    }
                                    $subjects = rtrim($subjects, ', ');
                                    echo $subjects; ?></td>
                                <td scope="col">{{date('m/d/Y', strtotime($assignment->created_at))}}</td>
                                <td scope="col">
                                    @can('manage-tutors')
                                        [<a href="{{route('admin.tutorassignments.edit', $assignment->id)}}">Edit</a>]
                                    @endcan

                                    @can('manage-tutors')
                                    <form action="{{ route('admin.tutorassignments.destroy', $assignment) }}" method="POST" class="float-left">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        [<a href = "javascript:;" onclick="parentNode.submit();">Delete</a>]
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
