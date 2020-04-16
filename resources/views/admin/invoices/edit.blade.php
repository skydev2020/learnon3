@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class = "fa fa-info-circle" style="font-size:24px;">Student Invoices</i>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.invoices.update', $invoice)}}" method="POST">
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="s_name" class="col-form-label font-weight-bold">Student Name:</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <a href = " {{route ( 'admin.users.edit', $invoice->user_id ) }} ">
                                {{$invoice->users()->first()['fname'].' '.$invoice->users()->first()['lname']}}
                                </a>{{' ( '. $invoice->user_id . ' )'}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label class="col-form-label font-weight-bold">Invoice Number:</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                {{ $invoice->prefix . '-' . $invoice->num}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="invoice_date" class="col-form-label font-weight-bold">Invoice Date:</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="invoice_date" type="date" class="form-control"
                                 name="invoice_date" value="{{ $invoice->invoice_date }}" autofocus>
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="num_of_sessions" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> No. of sessions:</label>
                            </div>

                            <div class="col-6">
                                <input id="num_of_sessions" type="text" class="form-control"
                                 name="num_of_sessions" value="{{ $invoice->num_of_sessions }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="total_hours" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Total Hours:</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="total_hours" type="text" class="form-control"
                                 name="total_hours" value="{{ $invoice->total_hours }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="hour_charged" class="col-form-label font-weight-bold">Hour Charged:</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                {{$invoice->hour_charged}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="total_amount" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Total Amount:</label>
                            </div>

                            <div class="col-6">
                                <input id="total_amount" type="text" class="form-control"
                                 name="total_amount" value="{{ $invoice->total_amount }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="paid_amount" class="col-form-label font-weight-bold">Paid Amount:</label>
                            </div>

                            <div class="col-6">
                                <input id="paid_amount" type="text" class="form-control"
                                 name="paid_amount" value="{{ $invoice->paid_amount }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="invoice_notes" class="col-form-label font-weight-bold">
                                {{ __('Invoice Notes:') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <textarea id="invoice_notes" class="form-control inputstl"
                                 name="invoice_notes" autocomplete="invoice_notes" autofocus>{{$invoice->invoice_notes}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label class="col-form-label font-weight-bold">Date Sent:</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                {{ $invoice->send_date }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end">
                                <label for="status" class="col-form-label font-weight-bold">{{ __('Invoice Status:') }}</label>
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
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="invoice_mail" class="col-form-label font-weight-bold">
                                {{ __('Invoice Mail:') }}</label>
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                <textarea id="invoice_mail" class="form-control inputstl"
                                 name="invoice_mail" autocomplete="invoice_mail" autofocus>
                                 <?php echo html_entity_decode($invoice->invoice_format); ?></textarea>
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <a href = "{{ route('admin.invoices.index') }}">
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
<!-- Scripts -->
@section("jssection")
<script type="text/javascript">
    window.addEventListener('load', function() {
        CKEDITOR.replace('invoice_mail', {
            uiColor:    '#CCEAEE',
            width:      '100%'
        });
    });
</script>

@stop
