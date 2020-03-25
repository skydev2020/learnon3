@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Packages</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Package Name</th>
                            <th scope="col">Hours</th>
                            <th scope="col">Price</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['packages'] as $package)
                            <tr>
                                <td scope="col">{{$package->name}}</td>
                                <td scope="col">{{$package->hours}}</td>
                                <td scope="col">{{$data['prices'][$package->id]}}</td>
                                <td scope="col">
                                    @can('manage-discount-package')
                                    [<a href="javascript:void(0)" onclick="alert('*** Buying Packages Online is Currently not Working ***')">Buy</a>]
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <h2>*** Buying Packages Online is Currently not Working ***</h2>
                    <h3>To Pay For a Package You Can:-</h3>
                    <h4>1. Send an email transfer to:- info@LearnOn.ca</h4>
                    <h4>2. Send a cheque to:- </h4>
                    <div class = "px-5 ml-5">
                        <h5>LearnOn! Tutorial</h5>
                        <h5>#432 North Service Road West</h5>
                        <h5>OakVille,ON  L6M 2Y1</h5>
                        <h5>Canada</h6>
                    </div>
                    <h4>3. To pay with credit card:- http://www.learnon.ca/pay_invoice</h4> <h5>Enter The Student's Name In The Invoice Box</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection