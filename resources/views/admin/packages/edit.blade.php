@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header" style = "text-align:center;">{{ __('Create New Package') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.packages.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label text-right">{{ __('Package Name') }}</label>

                            <div class="col-4">
                                <input  class="form-control" name="name" id = "name" value="{{ old('name') }}"
                                autocomplete="name" autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group row" class = "col-10">
                            <label for="description" class="col-4 col-form-label text-right">{{ __('description') }}</label>

                            <div class = "col-6">
                                <textarea class = "form-control " name="description" id = "description" value="{{ old('name') }}"
                                autofocus> </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price_usa" class="col-4 col-form-label text-right">{{ __('Price USA') }}</label>

                            <div class = "col-4">
                                <input  class="form-control" name="price_usa" id = "price_usa" value="{{ old('price_usa') }}"
                                autocomplete="price_usa" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price_canada" class="col-4 col-form-label text-right">{{ __('Price Canada') }}</label>

                            <div class = "col-4">
                                <input  class="form-control" name="price_canada" id = "price_canada"
                                    value="{{ old('price_canada') }}" autocomplete="price_canada" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price_others" class="col-4 col-form-label text-right">{{ __('Price Others') }}</label>

                            <div class = "col-4">
                                <input  class="form-control" name="price_others" id = "price_others" value="{{ old('price_others') }}"
                                autocomplete="price_others" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "hours" class = "col-4  form-level text-right">
                                    {{ __(' Hours') }} </label>

                            <div class = "col-4">
                                <input id = "hours" type="text" class = "form-control" name = "hours" 
                                    value="{{ old('hours') }}" autocomplete = "hours" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "status" class = "col-4 form-level text-right">
                                    {{ __(' Status') }} </label>

                            <div class = "col-2">
                                <select id = "status" name = "status" class = "form-control" style = "display:inline;">
                                    <option> Enabled </option>
                                    <option> Disabled </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-1 offset-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            <div class="col-1 offset-3">
                                <a href = "{{ route('admin.packages.index') }}">
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
