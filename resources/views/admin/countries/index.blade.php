@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-globe" style="font-size:24px"> Country</i>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.countries.create') }}">
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('ADD NEW COUNTRY') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Country</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <td scope="col"><?php echo html_entity_decode($country->name); ?></td>
                                <td scope="col">
                                    @can('manage-cms')
                                        [<a href="{{route('admin.countries.edit', $country)}}">Edit</a>]
                                    @endcan
                                    @can('manage-cms')
                                    <form action="{{ route('admin.countries.destroy', $country) }}" method="POST" class="float-left">
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