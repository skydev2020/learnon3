@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class = "far fa-newpaper" style="font-size:24px;">Tutor Paycheques</i>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.paycheques.update', $paycheque)}}" method="POST">
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label class="col-form-label font-weight-bold">Tutor Name:</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                {{$paycheque->users()->first()['fname'].' '.$paycheque->users()->first()['lname']}}
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label font-weight-bold">Address:</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                {{ $paycheque->users()->first()['address'] }} <br>
                                {{ $paycheque->users()->first()['city'] . ', '
                                 . $paycheque->users()->first()->state()->first()['name']}} <br>
                                {{ $paycheque->users()->first()['pcode']}} <br>
                                {{ $paycheque->users()->first()->country()->first()['name']}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="paycheque_num" class="col-form-label font-weight-bold">Paycheque Number:</label>
                            </div>

                            <div class="col-6">
                                <input id="paycheque_num" type="text" class="form-control"
                                 name="paycheque_num" value="{{ $paycheque->paycheque_num }}" required autofocus>
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}
                        
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="num_of_sessions" class="col-form-label font-weight-bold">No. of sessions:</label>
                            </div>

                            <div class="col-6">
                                <input id="num_of_sessions" type="text" class="form-control"
                                 name="num_of_sessions" value="{{ $paycheque->num_of_sessions }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="total_hours" class="col-form-label font-weight-bold">Total Hours:</label>
                            </div>

                            <div class="col-6">
                                <input id="total_hours" type="text" class="form-control"
                                 name="total_hours" value="{{ $paycheque->total_hours }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="num_of_essays" class="col-form-label font-weight-bold">No. of Essays:</label>
                            </div>

                            <div class="col-6">
                                <input id="num_of_essays" type="text" class="form-control"
                                 name="num_of_essays" value="{{ $paycheque->num_of_essays }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="essay_amount" class="col-form-label font-weight-bold">Essays Amount:</label>
                            </div>

                            <div class="col-6">
                                <input id="essay_amount" type="text" class="form-control"
                                 name="essay_amount" value="{{ $paycheque->essay_amount }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="raise_amount" class="col-form-label font-weight-bold">Raise Amount:</label>
                            </div>

                            <div class="col-6">
                                <input id="raise_amount" type="text" class="form-control"
                                 name="raise_amount" value="{{ $paycheque->raise_amount }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="total_amount" class="col-form-label font-weight-bold">Total Amount:</label>
                            </div>

                            <div class="col-6">
                                <input id="total_amount" type="text" class="form-control"
                                 name="total_amount" value="{{ $paycheque->total_amount }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="paid_amount" class="col-form-label font-weight-bold">Paid Amount:</label>
                            </div>

                            <div class="col-6">
                                <input id="paid_amount" type="text" class="form-control"
                                 name="paid_amount" value="{{ $paycheque->paid_amount }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="paycheque_notes" class="col-form-label font-weight-bold">
                                {{ __('Paycheque Notes:') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <textarea id="paycheque_notes" class="form-control inputstl"
                                 name="paycheque_notes" required autocomplete="paycheque_notes" autofocus>{{$paycheque->paycheque_notes}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label class="col-form-label font-weight-bold">Date Sent:</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                {{ date('d/m/Y', strtotime($paycheque->send_date)) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="status" class="col-form-label font-weight-bold">{{ __('paycheque Status:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <select name = "status" id = "status" class = "form-control">
                                    <option <?= $paycheque->status == "Paid" ? "selected" : ""?> >
                                    {{ __('Paid') }} </option>
                                    <option <?= $paycheque->status == "Hold For Approval" ? "selected" : ""?> >
                                    {{ __('Hold For Approval') }} </option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
