@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px;"> Information</i>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.informations.create') }}">
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('ADD NEW INFORMATION') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Information Title</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($informations as $information)
                            <tr>
                                <td scope="col"><?php echo html_entity_decode($information->title); ?></td>
                                <td scope="col">
                                    @can('manage-cms')
                                        [<a href="{{route('admin.informations.edit', $information)}}">Edit</a>]
                                    @endcan
                                    @can('manage-cms')
                                    <form action="{{ route('admin.informations.destroy', $information) }}" method="POST" class="float-left">
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