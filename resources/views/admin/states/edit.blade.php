@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-globe" style="font-size:24px"> Province / State</i>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('admin.states.update', $state) }}">
                        @csrf
                        {{method_field('PUT')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="name" class="col-form-label font-weight-bold">{{ __('Province/State Name:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $state->name }}"
                                autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="code" class="col-form-label font-weight-bold">{{ __('Province/State Code:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "code" id = "code" class = "form-control"
                                value="{{ $state->code }}" autocomplete="keyword" autofocus></input>
                            </div>
                        </div>
                        
                        <div class = "form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <a href = "{{ route('admin.states.index') }}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection