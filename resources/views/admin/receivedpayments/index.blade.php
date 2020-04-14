@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class = "far fa-newspaper" style="font-size:24px;"> Payments Received</i>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.receivedpayments.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <label for="id" class="col-md-4 col-form-label text-md-right">{{ __('Order ID') }}</label>
                            <div class="col-md-6">
                                <input id="id" type="text" class="form-control" name="id" value="{{ $data['old']['id'] }}"
                                autocomplete="id" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s_name" class="col-md-4 col-form-label text-md-right">{{ __('Student Name') }}</label>
                            <div class="col-md-6">
                                <input id="s_name" type="text" class="form-control" name="s_name" value="{{ $data['old']['s_name'] }}"
                                autocomplete="s_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status_id" class="col-md-4 col-form-label text-md-right">{{ __('Status:') }}</label>
                            <div class="col-md-6">
                                <select name = "status_id" id = "status_id" class = "form-control">
                                    <option></option>
                                    <option <?= $data['old']['status_id'] == "0" ? "selected" : "" ?> >
                                    {{__('Missing Orders')}}</option>
                                    @foreach ($data['statuses'] as $status)
                                        <option <?=$data['old']['status_id']==$status->id ? "selected":""?>>
                                        {{ $status->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_added" class="col-md-4 col-form-label text-md-right">{{ __('Date Added:') }}</label>
                            <div class="col-md-6">
                                <input id="date_added" type="date" class="form-control" name="date_added"
                                value="{{ $data['old']['date_added'] }}" autocomplete="date_added" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">

                    <table class="table table-bordered table-striped" id = "mytable">
                        <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Method</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Total</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['orders'] as $order)
                            <tr>
                                <td scope="col">{{$order->id}}</td>
                                <td scope="col">{{$order->users()->first()['fname'] . ' ' .
                                $order->users()->first()['lname'].' ('.$order->user_id.')'}}</td>
                                <td scope="col"><?= $order->package_id == 0 ? "Invoice" : "Package" ?></td>
                                <td scope="col">{{$order->payment_method}}</td>
                                <td scope="col"><?= $order->statuses()->first() == NULL ? '' :
                                    $order->statuses()->first()['name']?></td>
                                <td scope="col">{{date('d/m/Y', strtotime($order->created_at)) }}</td>
                                <td scope="col">{{'$' . number_format($order->total * $order->value, 2)}}</td>
                                <td scope="col">
                                    @can('manage-payments')
                                        [<a href="{{route('admin.receivedpayments.edit', $order)}}">Edit</a>]
                                    @endcan
                                    @can('manage-payments')
                                    <form action="{{ route('admin.receivedpayments.destroy', $order) }}" method="POST" class="float-left">
                                    @csrf
                                        {{method_field('DELETE')}}
                                        [<a href="javascript:;" onclick="parentNode.submit();">Delete</a>]
                                    </form>
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

<script type = "text/javascript">
    function exportToExcel(tableID){
        var tab_text="<table border='2px'><tr bgcolor='#87AFC6' style='height: 75px; text-align: center; width: 250px'>";
        var textRange; var j=0;
        tab = document.getElementById(tableID); // id of table

        for(j = 0 ; j < tab.rows.length ; j++)
        {

            tab_text=tab_text;

            tab_text=tab_text+tab.rows[j].innerHTML.toUpperCase()+"</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text= tab_text+"</table>";
        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
        tab_text= tab_text.replace(/<img[^>]*>/gi,""); //remove if u want images in your table
        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); //remove input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer

        {
            txtArea1.document.open("txt/html","replace");
            txtArea1.document.write( 'sep=,\r\n' + tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa=txtArea1.document.execCommand("SaveAs",true,"sudhir123.txt");
        }

        else {
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
        }

        return (sa);
    }
</script>

@endsection
