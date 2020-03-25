@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">TUTORING INVOICE</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class = "offset-10">
                            <a onclick="window.print();">
                                <button type = "button" class="btn btn-primary">Print Invoice</button>
                            </a>
                        </div>
                        <div class="col-1">
                            <a href = "{{ route('student.invoices.index') }}">
                                <button type = "button" class="btn btn-primary">Back</button>
                            </a>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('INVOICE #:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$data['invoice']->prefix . '-' . $data['invoice']->num}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('DATE ISSUED:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{ date('M d, Y', strtotime($data['invoice']->send_date)) }}
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">TUTORING SERVICES FOR MONTH OF:</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$data['invoice'] -> invoice_date}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">{{ __('Bill To:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            {{$data['invoice']->users()->first()['parent_fname'].' '.$data['invoice']->users()->first()['parent_lname']}}
                            <br>
                            {{$data['invoice']->users()->first()['fname'].' '.$data['invoice']->users()->first()['lname']}}
                            <br>
                            {{$data['invoice']->users()->first()['address']}}
                            <br>
                            {{$data['invoice']->users()->first()['city'].', '.$data['invoice']->users()->first()->state()->first()['code']}}
                            <br>
                            {{$data['invoice']->users()->first()['pcode']}}
                        </div>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">TUTOR</th>
                            <th scope="col">DATE</th>
                            <th scope="col">DURATION</th>
                            <th scope="col">DURATION CHARGED</th>
                            <th scope="col">SESSION RATE</th>
                            <th scope="col">TOTAL</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['invoice_details'] as $info)
                            <tr>
                                <td scope="col">{{$info['tutor_name']}}</td>
                                <td scope="col">{{$info['date']}}</td>
                                <td scope="col">{{$info['duration']}}</td>
                                <td scope="col">{{$info['min_charge_time']}}</td>
                                <td scope="col">{{$info['rate']}}</td>
                                <td scope="col">{{$info['total']}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td scope="col"></td>
                                <td scope="col"></td>
                                <td scope="col"></td>
                                <td scope="col"></td>
                                <td scope="col"><strong>TOTAL</strong></td>
                                <td scope="col">{{'$ ' . $data['invoice']->total_amount}}</td>
                            </tr>
                        </tbody>
                    </table>

                        <div class = "offset-1">
                            <h3>PAY ONLINE <a href="">HERE</a></h3>
                        </div>
                        <div class = "offset-1">
                            <br><br>
                            <h2>Make Cheques Payable to:  </h2>
            
                            <p> {{$data['config_name']}}<br />
                                {{$data['config_address']}}<br /><br />
                                *Please print and attach invoice to cheque.
                            </p>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection