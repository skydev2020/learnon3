@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px;"> Coupon</i>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.coupons.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="c_name" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Coupon Name:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="c_name" type="text" class="form-control" name="c_name" autocomplete="c_name"
                                 autofocus required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="description" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Coupon Description:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <textarea id="description" class="form-control" name="description" autocomplete="description"
                                 autofocus required></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="code" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Code:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "code" id = "code" class = "form-control"
                                 autocomplete="code" autofocus required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="c_type" class="col-form-label font-weight-bold">{{ __('Type:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select name = "c_type" id = "c_type" class = "form-control">
                                    <option value = "P">Percentage</option>
                                    <option value = "F">Fixed Amount</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="discount" class="col-form-label font-weight-bold">{{ __('Discount:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "discount" id = "discount" class = "form-control"
                                 autocomplete="discount" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="date_start" class="col-form-label font-weight-bold">{{ __('Date Start:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "date" name = "date_start" id = "date_start" class = "form-control"
                                value="{{ date('Y-m-d') }}" autocomplete="date_start" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="date_end" class="col-form-label font-weight-bold">{{ __('Date End:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "date" name = "date_end" id = "date_end" class = "form-control"
                                value="{{ date('Y-m-d') }}" autocomplete="date_end" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 align-items-center">
                                <label for="uses_total" class="col-form-label font-weight-bold">{{ __('Uses Per Coupon:') }}</label>
                                <span class="d-flex justify-content-end">The maximum number of times the coupon can be used by any student. Leave blank for unlimited</span>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <input type = "text" name = "uses_total" id = "uses_total" class = "form-control"
                                value="1" autocomplete="uses_total" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 align-items-center">
                                <label for="uses_customer" class="col-form-label font-weight-bold">{{ __('Uses Per Student:') }}</label>
                                <span class="d-flex justify-content-end">The maximum number of times the coupon can be used by a single student. Leave blank for unlimited</span>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <input type = "text" name = "uses_customer" id = "uses_customer" class = "form-control"
                                value="1" autocomplete="uses_customer" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="status" class="col-form-label font-weight-bold">{{ __('Status:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select name = "status" id = "status" class = "form-control" >
                                <option value="1" >Enabled</option>
                                <option value="0" >Disabled</option>
                                </select>
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
