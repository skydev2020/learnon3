@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class = "far fa-newspaper" style="font-size:24px;"> Payments Received</i>
                </div>
                <div class="card-body">
                    <ul class = "nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab_order">Order Details</a></li>
                        <li><a data-toggle="tab" href="#tab_product">Packages</a></li>
                        <li><a data-toggle="tab" href="#tab_history">Order History</a></li>
                    </ul>

                    <div class = "tab-content">
                        <div id = "tab_order" class = "tab-pane fade">
                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Order ID:</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    {{'#' . $data['order']->id}}
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                    <label class="col-form-label font-weight-bold">Invoice ID:</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    <?php if ($data['order']->invoice_id == 0) { ?>
                                        <button type="button" class="btn btn-primary">
                                            Generate
                                        </button>
                                    <?php } else { ?>
                                        {{$data['order']->invoice_prefix . '-' . $data['order']->invoice_id}}
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Student:</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    {{$data['order']->users()->first()['fname'] . ' ' . $data['order']->users()->first()['lname']}}
                                </div>
                            </div>

                            
                            
                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">E-Mail:</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    {{$data['order']->users()->first()['email']}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Telephone:</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    {{$data['order']->home_phone}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Date Added:</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                   {{ date('d/m/Y', strtotime($data['order']->created_at)) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Payment Method:</label>
                                </div>

                                <div class="col-6  d-flex align-items-center">
                                    {{ $data['order']->payment_method }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Order Total:</label>
                                </div>

                                <div class="col-6  d-flex align-items-center">
                                    {{ '$' . number_format($data['order']->total * $data['order']->value, 2) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Order Status:</label>
                                </div>

                                <div class="col-6  d-flex align-items-center">
                                    {{ $data['order']->statuses()->first()['name'] }}
                                </div>
                            </div>
                        </div>

                        <div id = "tab_product" class = "tab-pane fade in active">
                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                    <label class="col-form-label font-weight-bold">Packages:</label>
                                </div>

                                <div class="col-6 align-items-center">
                                    <a href = "{{route('admin.packages.create')}}">
                                    {{$data['order']->packages()->first()['name']}} </a>
                                    <br/>
                                    <?php
                                    echo html_entity_decode($data['order']->packages()->first() ['description']);
                                    ?>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                    <label class="col-form-label font-weight-bold">Total Hours:</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    {{$data['order']->total_hours}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Left Hours:</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    {{$data['order']->left_hours}}
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Total:</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    <?= $data['order_total'] != null ? $data['order_total']->text : "" ?>                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Sub_Toal:</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    <?= $data['order_subtotal'] != null ? $data['order_subtotal']->text : "" ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Credit Card Convenience Fee:	</label>
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    <?= $data['order_card'] != null ? $data['order_card']->text : "" ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3 d-flex justify-content-end">
                                    <label class="col-form-label font-weight-bold">Total:</label>
                                </div>

                                <div class="col-6  d-flex align-items-center">
                                    <?= $data['order_total'] != null ? $data['order_total']->text : "" ?> 
                                </div>
                            </div>
                        </div>

                        <div id = "tab_history" class = "tab-pane fade in active">
                            @foreach ($data['order_histories'] as $history)
                                <div>
                                    <div class = "form-group row">
                                        <div class="col-3 d-flex justify-content-end">
                                            <label class="col-form-label font-weight-bold">Date Added:</label>
                                        </div>

                                        <div class="col-6 d-flex align-items-center">
                                            {{ date('d/m/Y', strtotime($history->created_at)) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3 d-flex align-items center justify-content-end">
                                            <label class="col-form-label font-weight-bold">Status:</label>
                                        </div>

                                        <div class="col-6 d-flex align-items-center">
                                            {{ $history->statuses()->first()['name'] }}
                                        </div>
                                    </div>
                                    <div class = "form-group row">
                                        <div class="col-3 d-flex align-items-center justify-content-end">
                                            <label class="col-form-label font-weight-bold">Comment:</label>
                                        </div>

                                        <div class="col-6 d-flex align-items-center">
                                            {{ $history->comment }}
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            @endforeach
                            <form action="{{route('admin.receivedpayments.update', $data['order'])}}" method="POST">

                                @csrf
                                {{method_field('PUT')}}
                                <div class = "form-group row">
                                    <div class="col-3 align-items-center">
                                        <label class="col-form-label font-weight-bold d-flex justify-content-end">Left Hours:</label>
                                        <span class="d-flex justify-content-end">(e.g 12:30, 12.30, 1:45, 1.45)</span>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input id = "left_hours" name = "left_hours" type = "text" 
                                        class="form-control" value = {{$data['order']->left_hours}}>
                                        </input>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" name = "action" value = "update">Update</button>
                                

                                <div class = "form-group row">
                                    <div class="col-3 align-items-center d-flex justify-content-end">
                                        <label for="status_id" class="col-form-label font-weight-bold">Order Status:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <select id = "status_id" name = "status_id" class="form-control">
                                            @foreach($data['statuses'] as $status)
                                                <option <?= $status->id == $data['order']['status_id']?"selected":"" ?>
                                                value = {{$status->id}} >
                                                {{$status->name}} </option>
                                                </option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @csrf
                                {{method_field('PUT')}}

                                <div class = "form-group row">
                                    <div class="col-3 align-items-center d-flex justify-content-end">
                                        <label class="col-form-label font-weight-boldd">Comment:</label>
                                    </div>

                                    <div class="col-6 d-flex align-items-center">
                                        <input id = "comment" name = "comment" type = "text" class="form-control" >
                                        </input>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" name = "action" value = "add history">Add Order History</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
