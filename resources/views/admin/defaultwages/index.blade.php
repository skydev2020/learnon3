@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-address-book" style="font-size:24px;"> Base Invoice Rates</i>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('admin.defaultwages.update', $defaultwage) }}">
                        @csrf
                        {{method_field('PUT')}}

                        <div class = "form-group row">
                            <div class = "col-1 offset-10 d-flex">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                            <div class = "col-1 d-flex">
                                <a href = "{{ route('admin.defaultwages.index') }}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="wage_usa" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Default Wage USA
                                </label>
                            </div>
                            <div class="col-6">
                                <input id="wage_usa" type="text" class="form-control" name="wage_usa"
                                value="{{ $defaultwage->wage_usa }}" autocomplete="wage_usa" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="wage_canada" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Default Wage CANADA
                                </label>
                            </div>
                            <div class="col-6">
                                <input id="wage_canada" type="text" class="form-control" name="wage_canada"
                                value="{{ $defaultwage->wage_canada }}" autocomplete="wage_canada" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="wage_alberta" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Default Wage ALBERTA
                                </label>
                            </div>
                            <div class="col-6">
                                <input id="wage_alberta" type="text" class="form-control" name="wage_alberta"
                                value="{{ $defaultwage->wage_alberta }}" autocomplete="wage_alberta" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="invoice_usa	" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Default Invoice USA
                                </label>
                            </div>
                            <div class="col-6">
                                <input id="invoice_usa" type="text" class="form-control" name="invoice_usa"
                                value="{{ $defaultwage->invoice_usa	}}" autocomplete="invoice_usa" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="invoice_canada" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Default Invoice CANADA
                                </label>
                            </div>
                            <div class="col-6">
                                <input id="invoice_canada" type="text" class="form-control" name="invoice_canada"
                                value="{{ $defaultwage->invoice_canada }}" autocomplete="invoice_canada" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="invoice_alberta" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Default Invoice ALBERTA
                                </label>
                            </div>
                            <div class="col-6">
                                <input id="invoice_alberta" type="text" class="form-control" name="invoice_alberta"
                                value="{{ $defaultwage->invoice_alberta}}" autocomplete="invoice_alberta" autofocus>
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="income_file" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Upload New Rates (CSV)
                                </label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <input type = "file" id = "income_file" name = "income_file"
                                    class = "form-control">
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Download Rates
                                </label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <a href = "{{ route('admin.defaultwages.export') }}">
                                    <button type="button" class="btn btn-primary">Export</button>
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
