@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Tutor Paycheques</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.paycheques.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <label for="t_name" class="col-md-4 col-form-label text-md-right">{{ __('Tutor Name') }}</label>
                            <div class="col-md-6">
                                <input id="t_name" type="text" class="form-control" name="t_name" value="{{ $data['old']['t_name'] }}"
                                autocomplete="t_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="num_of_sessions" class="col-md-4 col-form-label text-md-right">{{ __('Total Sessions') }}</label>
                            <div class="col-md-6">
                                <input id="num_of_sessions" type="text" class="form-control" name="num_of_sessions" value="{{ $data['old']['num_of_sessions'] }}"
                                autocomplete="num_of_sessions" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_hours" class="col-md-4 col-form-label text-md-right">{{ __('Total Hours') }}</label>
                            <div class="col-md-6">
                                <input id="total_hours" type="text" class="form-control" name="total_hours" value="{{ $data['old']['total_hours'] }}"
                                autocomplete="total_hours" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_hours" class="col-md-4 col-form-label text-md-right">{{ __('Total Hours') }}</label>
                            <div class="col-md-6">
                                <input id="total_hours" type="text" class="form-control" name="total_hours" value="{{ $data['old']['total_hours'] }}"
                                autocomplete="total_hours" autofocus>
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
