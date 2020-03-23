@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Payment Records</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class = "offset-10">
                            <a onclick="window.print();">
                                <button type = "button" class="btn btn-primary">Print Record</button>
                            </a>
                        </div>
                        <div class="col-1">
                            <a href = "{{ route('tutor.paymentrecords.index') }}">
                                <button type = "button" class="btn btn-primary">Back</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Sessions Details</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id = "mytable">
                        <thead>
                        <tr>
                            <th scope="col">Assignment#</th>
                            <th scope="col">Duration of Session</th>
                            <th scope="col">Date of Session</th>
                            <th scope="col">Pay Rate for Session</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['all_sessions'] as $session)
                        
                        <tr>
                            <td scope="col">{{$session['student_name']}}</td>
                            <td scope="col">{{$session['session_duration']}}</td>
                            <td scope="col">{{$session['session_date']}}</td>
                            <td scope="col">{{$session['session_amount']}}</td>
                        </tr>

                        @endforeach

                        <tr>
                            <td class="right" colspan="3">Total Amount (Tutoring) $</td>
                            <td class="left">{{ $data['paycheque_info']['session_amount'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Essays Details</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id = "mytable">
                        <thead>
                        <tr>
                            <th scope="col">Assignment#</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Date of Essay</th>
                            <th scope="col">Pay Rate for Essay</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['all_essays'] as $essay)
                        
                        <tr>
                            <td scope="col">{{$essay['student_name']}}</td>
                            <td scope="col">{{$essay['session_duration']}}</td>
                            <td scope="col">{{$essay['session_date']}}</td>
                            <td scope="col">{{$essay['session_amount']}}</td>
                        </tr>

                        @endforeach

                        <tr>
                            <td class="right" colspan="3">Total Amount (Essays) $</td>
                            <td class="left">{{ $data['paycheque_info']['essay_amount'] }}</td>
                        </tr>

                        <tr>
                            <td class="right" colspan="3">{{$data['text_grand_total']}}</td>
                            <td class="left">{{ $data['paycheque_info']['total_paid'] }}</td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection