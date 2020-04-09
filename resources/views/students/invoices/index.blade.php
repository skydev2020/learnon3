@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px;"> Tutoring Invoices</i>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Invoice Number</th>
                            <th scope="col">Invoice Date</th>
                            <th scope="col">Total Hours</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['invoices'] as $invoice)
                            <tr>
                                <td scope="col">{{$invoice->prefix . '-' . $invoice->num}}</td>
                                <td scope="col">{{date('d/m/Y', strtotime($invoice -> invoice_date))}}</td>
                                <td scope="col">{{$invoice->total_hours}}</td>
                                <td scope="col">{{$invoice->total_amount}}</td>
                                <td scope="col">{{$data['statuses'][$invoice->id]}}</td>
                                <td scope="col">
                                    @can('manage-invoices')
                                    [<a href="{{route('student.invoices.show', $invoice)}}">View Details</a>]
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection