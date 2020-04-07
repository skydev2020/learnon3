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
                <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}">
                        @csrf
                        {{method_field('PUT')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="c_name" class="col-form-label font-weight-bold">{{ __('Coupon Name:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="c_name" type="text" class="form-control" name="c_name" value="{{ $coupon->name }}"
                                autocomplete="c_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="description" class="col-form-label font-weight-bold">{{ __('Coupon Description:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="description" type="text" class="form-control" name="description"
                                value="{{ $coupon->description }}" autocomplete="description" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="code" class="col-form-label font-weight-bold">{{ __('Code:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "code" id = "code" class = "form-control"
                                value="{{ $coupon->code }}" autocomplete="code" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="c_type" class="col-form-label font-weight-bold">{{ __('Type:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "c_type" id = "c_type" class = "form-control"
                                value="{{ $coupon->type }}" autocomplete="c_type" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="discount" class="col-form-label font-weight-bold">{{ __('Discount:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "discount" id = "discount" class = "form-control"
                                value="{{ $coupon->discount }}" autocomplete="discount" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="date_start" class="col-form-label font-weight-bold">{{ __('Date Start:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "date" name = "date_start" id = "date_start" class = "form-control"
                                value="{{ $coupon->date_start }}" autocomplete="date_start" autofocus></input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="date_end" class="col-form-label font-weight-bold">{{ __('Date End:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "date" name = "date_end" id = "date_end" class = "form-control"
                                value="{{ $coupon->date_end }}" autocomplete="date_end" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 align-items-center">
                                <label for="uses_total" class="col-form-label font-weight-bold">{{ __('Uses Per Coupon:') }}</label>
                                <span class="d-flex justify-content-end">The maximum number of times the coupon can be used by any student. Leave blank for unlimited</span>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <input type = "text" name = "uses_total" id = "uses_total" class = "form-control"
                                value="{{ $coupon->uses_total }}" autocomplete="uses_total" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 align-items-center">
                                <label for="uses_customer" class="col-form-label font-weight-bold">{{ __('Uses Per Student:') }}</label>
                                <span class="d-flex justify-content-end">The maximum number of times the coupon can be used by a single student. Leave blank for unlimited</span>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <input type = "text" name = "uses_customer" id = "uses_customer" class = "form-control"
                                value="{{ $coupon->uses_customer }}" autocomplete="uses_customer" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="status" class="col-form-label font-weight-bold">{{ __('Status:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select name = "status" id = "status" class = "form-control" >
                                <option value="1" <?= $coupon->status == 1 ? "selected" : "" ?> >Enabled</option>
                                <option value="0" <?= $coupon->status == 0 ? "selected" : "" ?> >Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary">
                                    {{ __('Update') }}
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
