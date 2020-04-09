@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-file-text" style="font-size:24px"> Error Log</i>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.errorlogs.clear') }}">
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-11">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Clear Log') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <textarea class = "flex form-control inputstl" rows="28">{{$data}}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection