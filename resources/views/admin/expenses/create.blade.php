@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-address-book" style="font-size:24px;">Add an Expense</i>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('admin.expenses.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="e_name" class="col-form-label font-weight-bold">{{ __('Expense Name:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="e_name" type="text" class="form-control" name="e_name"
                                autocomplete="e_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="expense_date" class="col-form-label font-weight-bold">{{ __('Expense Date:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="expense_date" type="date" class="form-control" name="expense_date"
                                autocomplete="expense_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="amount" class="col-form-label font-weight-bold">{{ __('Amount: $') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "amount" id = "amount" class = "form-control" autocomplete="amount" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="notes" class="col-form-label font-weight-bold">{{ __('Notes:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "notes" id = "notes" class = "form-control" autocomplete="notes" autofocus></input>
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
