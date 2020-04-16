@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-address-book" style="font-size:24px;"> Other Income</i>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('admin.otherincomes.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="i_name" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Income Name:') }}
                                </label>
                            </div>
                            <div class="col-6">
                                <input id="i_name" type="text" class="form-control" name="i_name"
                                autocomplete="i_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="income_date" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Income Date:') }}
                                </label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="income_date" type="date" class="form-control" name="income_date"
                                autocomplete="income_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="amount" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Amount: $') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "amount" id = "amount" class = "form-control"
                                 autocomplete="amount" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="notes" class="col-form-label font-weight-bold">{{ __('Notes:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <textarea name = "notes" id = "notes" class = "form-control inputstl"
                                 autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary">
                                    {{ __('Save') }}
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
