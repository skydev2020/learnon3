@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style = "text-align:center;">{{ __('Create New Package') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.packages.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Package Name') }}</label>

                            <div class="col-md-6">
                                <input  class="form-control" name="name" id = "name" value="{{ old('name') }}"
                                autocomplete="name" autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group row" class = "col-md-10">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('description') }}</label>

                            <div class = "col-md-6">
                                <textarea class = "form-control " name="description" id = "description" value="{{ old('name') }}"
                                autofocus> </textarea>
                            </div>
                        </div>

                        <div class="row" style = "display:flex;">
                            <div class="form-group col-md-4">
                                <label for="price_usa" class="col-form-label text-md-right">{{ __('Price USA') }}</label>

                                <div>
                                    <input  class="form-control" name="price_usa" id = "price_usa" value="{{ old('price_usa') }}"
                                    autocomplete="price_usa" autofocus>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_canada" class="col-form-label">{{ __('Price Canada') }}</label>

                                <div>
                                    <input  class="form-control" name="price_canada" id = "price_canada"
                                     value="{{ old('price_canada') }}" autocomplete="price_canada" autofocus>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price_others" class="col-form-label text-md-right">{{ __('Price Others') }}</label>

                                <div>
                                    <input  class="form-control" name="price_others" id = "price_others" value="{{ old('price_others') }}"
                                    autocomplete="price_others" autofocus>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" style = "display:flex;">
                            <div class="col-md-6">
                                <label for = "hours" class = "form-level"> {{ __(' Hours') }} </label>

                                <div >
                                    <input id = "hours" type="text" class = "form-control" name = "hours" 
                                     value="{{ old('hours') }}" autocomplete = "hours" autofocus>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for = "status" class = "form-level"> {{ __(' Status') }} </label>

                                <div >
                                    <select id = "status" name = "status" class = "form-control" style = "display:inline;">
                                        <option> Enabled </option>
                                        <option> Disabled </option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('SAVE') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
