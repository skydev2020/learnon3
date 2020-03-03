@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Student Invoices</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.invoices.index') }}">
                        @csrf
                        {{method_field('GET')}}
                        <div class="form-group row">
                            <label for="invoice_num" class="col-md-4 col-form-label text-md-right">{{ __('Invoice #') }}</label>
                            <div class="col-md-6">
                                <input id="invoice_num" type="text" class="form-control" name="invoice_num" 
                                value="{{$data['old']['invoice_num']}}" autocomplete="invoice_num" autofocus>
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
                            <label for="date_added" class="col-md-4 col-form-label text-md-right">{{ __('Date Added') }}</label>
                            <div class="col-md-6">
                                <input id="date_added" type="date" class="form-control" name="date_added" value="{{ $data['old']['date_added'] }}"
                                autocomplete="date_added" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                            <div class="col-md-6">
                                <select name = "status" id = "status" class = "form-control">
                                    <option></option>
                                    <option <?=$data['old']['status']== "Reminder Sent" ? "selected" : ""?> >
                                    {{ __('Reminder Sent') }} </option>
                                    <option <?=$data['old']['status']== "Payment Due" ? "selected" : ""?> >
                                    {{ __('Payment Due') }} </option>
                                    <option <?= $data['old']['status'] == "Paid" ? "selected" : ""?> >
                                    {{ __('Paid') }} </option>
                                    <option <?=$data['old']['status']== "Hold For Approval" ? "selected" : ""?> >
                                    {{ __('Hold For Approval') }} </option>
                                    <option <?=$data['old']['status']== "Unpaid" ? "selected" : ""?> >
                                    {{ __('Unpaid') }} </option>
                                </select>
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
                            <th scope="col">Invoice #</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Total Hours</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['invoices'] as $invoice)
                            <tr>
                                <td scope="col">{{$invoice->prefix . '-' . $invoice->num}}</td>
                                <td scope="col">{{$invoice->users()->first()['fname'] . ' ' . 
                                $invoice->users()->first()['lname'].' ('.$invoice->user_id.')'}}</td>
                                <td scope="col">{{$invoice->total_amount}}</td>
                                <td scope="col">{{$invoice->total_hours}}</td>
                                <td scope="col">{{date('d/m/Y', strtotime($invoice->date_added)) }}</td>
                                <td scope="col">{{$invoice->status}}</td>
                                <td scope="col">
                                    @can('edit-users')
                                        [<a href="{{route('admin.invoices.edit', $invoice)}}">Edit</a>]
                                    @endcan
                                    @can('manage-tutors')
                                        [<a href="{{route('admin.invoices.edit', $invoice)}}">View</a>]
                                    @endcan
                                    @can('manage-tutors')
                                    <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST" class="float-left">
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