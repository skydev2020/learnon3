@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Mail Log</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.maillogs.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <label for="mail_to" class="col-md-4 col-form-label text-md-right">{{ __('Search mail to') }}</label>
                            <div class="col-md-4">
                                <input id="mail_to" type="text" class="form-control" name="mail_to" value="{{ $data['old']['mail_to'] }}"
                                autocomplete="mail_to" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-4 offset-5">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}
                                </button>
                            </div>

                            <div class="col-3">
                                <button type = "button" class="btn btn-primary"
                                onclick="exportToExcel('maillogs')">{{ __('Export') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id = "maillogs">
                        <thead>
                        <tr>
                            <th scope="col">Mail To</th>
                            <th scope="col">Mail From</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Date Send</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['maillogs'] as $maillog)
                            <tr>
                                <td scope="col">{{$maillog->mail_to}}</td>
                                <td scope="col">{{$maillog->mail_from}}</td>
                                <td scope="col">{{$maillog->subject}}</td>
                                <td scope="col">{{date('m/d/Y', strtotime($maillog->created_at ))}}</td>
                                <td scope="col">
                                    @can('manage-cms')
                                        [<a href="{{route('admin.maillogs.show', $maillog)}}">View</a>]
                                    @endcan
                                    @can('manage-cms')
                                    <form action="{{ route('admin.maillogs.destroy', $maillog) }}" method="POST" class="float-left">
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
@endsection
<!-- Scripts -->
@section("jssection")
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
@stop