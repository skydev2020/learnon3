@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Users</i>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Roles</th>
                            <th scope="col" class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row" class="font-weight-normal">{{$user->id}}</th>
                                <td scope="col">{{$user->fname . ' ' . $user->lname}}</td>
                                <td scope="col">{{$user->email}}</td>
                                <td scope="col">{{implode(', ', $user->roles()->get()->pluck('name')->toArray())}}</td>
                                <td scope="col" class="text-right">
                                    @can('edit-users')
                                        [<a href="{{route('admin.users.edit', $user->id)}}">Edit</a>]
                                    @endcan
                                    @can('delete-users')
                                        &nbsp;[<a href="#" onclick="return user_del_confirm({{$user->id}})" >Delete</a>]
                                        <form action="{{ route('admin.users.destroy', $user) }}" id="del_form_{{$user->id}}" method="POST" class="float-left d-none">
                                            @csrf
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-warning">Delete</button>
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
<!-- Scripts -->
@section("jssection")
<script>
    function user_del_confirm(id) {
        var r=confirm('Are you sure?');
        if (r == true) {
            $("#del_form_" + id).submit();
        }
    }

</script>
@stop
