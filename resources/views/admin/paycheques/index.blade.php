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
                            <label for="date_added" class="col-md-4 col-form-label text-md-right">{{ __('Date Added:') }}</label>
                            <div class="col-md-6">
                                <input id="date_added" type="date" class="form-control" name="date_added"
                                value="{{ $data['old']['date_added'] }}" autocomplete="date_added" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status:') }}</label>
                            <div class="col-md-6">
                                <select name = "status" id = "status" class = "form-control">
                                    <option></option>
                                    <option <?= $data['old']['status'] == "Paid" ? "selected" : "" ?> >
                                    {{__('Paid')}}</option>
                                    <option <?= $data['old']['status'] == "Hold For Approval" ? "selected" : "" ?> >
                                    {{__('Hold For Approval')}}</option>
                                </select>
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
                            <th scope="col">Tutor Name</th>
                            <th scope="col">Total Sessions</th>
                            <th scope="col">Total Hours</th>
                            <th scope="col">Raise Amount</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['paycheques'] as $paycheque)
                            <tr>
                                <td scope="col">{{$paycheque->users()->first()['fname'] . ' ' . 
                                $paycheque->users()->first()['lname'].' ('.$paycheque->user_id.')'}}</td>
                                <td scope="col">{{$paycheque->num_of_sessions}}</td>
                                <td scope="col">{{$paycheque->total_hours}}</td>
                                <td scope="col">{{$paycheque->raise_amount}}</td>
                                <td scope="col">{{$paycheque->total_amount}}</td>
                                <td scope="col">{{date('d/m/Y', strtotime($paycheque->created_at)) }}</td>
                                <td scope="col">{{$paycheque->status}}</td>
                                <td scope="col">
                                    @can('manage-payments')
                                        [<a href="{{route('admin.paycheques.edit', $paycheque)}}">Edit/View</a>]
                                    @endcan
                                    @can('manage-payments')
                                    <form action="{{ route('admin.paycheques.destroy', $paycheque) }}" method="POST" class="float-left">
                                    @csrf
                                        {{method_field('DELETE')}}
                                        [<a href="javascript:;" onclick="parentNode.submit();">Delete</a>]
                                    </form>
                                    @endcan
                                    @can('manage-payments')
                                    <form action="{{ route('admin.paycheques.markaspaid', $paycheque) }}"
                                    method = "POST" class="float-left">
                                    @csrf
                                        {{method_field('PUT')}}
                                        [<a href="javascript:;" onclick = "parentNode.submit();">Mark As Paid</a>]
                                    </form>
                                    @endcan
                                    @can('manage-payments')
                                    <form action="{{ route('admin.paycheques.lock', $paycheque) }}"
                                    method = "POST" class="float-left">
                                    @csrf
                                        {{method_field('PUT')}}
                                        [<a href="javascript:;" onclick = "parentNode.submit();">Lock Paycheque</a>]
                                    </form>
                                    @endcan
                                    @can('manage-payments')
                                    <form action="{{ route('admin.paycheques.unlock', $paycheque) }}"
                                    method = "POST" class="float-left">
                                    @csrf
                                        {{method_field('PUT')}}
                                        [<a href="javascript:;" onclick = "parentNode.submit();">Unlock Paycheque</a>]
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
