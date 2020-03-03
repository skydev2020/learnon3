@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Student Invoices</div>
                <div class="card-body">
                    <form action="{{route('admin.studentinvoices.update', $invoice)}}" method="POST">
                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="s_name" class="col-form-label font-weight-bold">Student Name:</label>
                            </div>

                            <div class="col-md-6">
                                <a href = " {{route ( 'admin.users.edit', $invoice->student_id ) }} ">
                                {{$invoice->students()->first()['fname'].' '.$invoice->students()->first()['lname']}}
                                </a>{{' ( '. $invoice->studnet_id . ' )'}}
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label class="col-form-label font-weight-bold">Invoice Number:</label>
                            </div>

                            <div class="col-md-6">
                                {{ $invoice->prefix . '-' . $invoice->num}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="invoice_date" class="col-form-label font-weight-bold">Invoice Date:</label>
                            </div>

                            <div class="col-md-6">
                                <input id="invoice_date" type="date" class="form-control"
                                 name="invoice_date" value="{{ $invoice->invoice_date }}" required autofocus>
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}
                        
                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="num_of_sessions" class="col-form-label font-weight-bold">No. of sessions:</label>
                            </div>

                            <div class="col-md-6">
                                <input id="num_of_sessions" type="text" class="form-control"
                                 name="num_of_sessions" value="{{ $invoice->num_of_sessions }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="total_hours" class="col-form-label font-weight-bold">Total Hours:</label>
                            </div>

                            <div class="col-md-6">
                                <input id="total_hours" type="text" class="form-control"
                                 name="total_hours" value="{{ $invoice->total_hours }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="total_amount" class="col-form-label font-weight-bold">Total Amount:</label>
                            </div>

                            <div class="col-md-6">
                                <input id="total_amount" type="text" class="form-control"
                                 name="total_amount" value="{{ $invoice->total_amount }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="paid_amount" class="col-form-label font-weight-bold">Paid Amount:</label>
                            </div>

                            <div class="col-md-6">
                                <input id="paid_amount" type="text" class="form-control"
                                 name="paid_amount" value="{{ $invoice->paid_amount }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="invoice_notes" class="col-form-label font-weight-bold">
                                {{ __('Invoice Notes:') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <textarea id="invoice_notes" class="form-control inputstl"
                                 name="invoice_notes" required autocomplete="invoice_notes" autofocus>
                                 {{$invoice->invoice_notes}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label class="col-form-label font-weight-bold">Date Sent:</label>
                            </div>

                            <div class="col-md-6 ">
                                {{ $invoice->send_date }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="status" class="col-form-label font-weight-bold">{{ __('Invoice STatus') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <select name = "status" id = "status" class = "form-control">
                                    <option></option>
                                    <option <?= $invoice->status == "Reminder Sent" ? "selected" : ""?> >
                                    {{ __('Reminder Sent') }} </option>
                                    <option <?= $invoice->status == "Payment Due" ? "selected" : ""?> >
                                    {{ __('Payment Due') }} </option>
                                    <option <?= $invoice->status == "Paid" ? "selected" : ""?> >
                                    {{ __('Paid') }} </option>
                                    <option <?= $invoice->status == "Hold For Approval" ? "selected" : ""?> >
                                    {{ __('Hold For Approval') }} </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="invoice_mail" class="col-form-label font-weight-bold">{{ __('Invoice Mail:') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                
                               
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                        <span>{{$invoice->invoice_format}}</span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
