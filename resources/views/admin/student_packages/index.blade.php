@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px"> Student Packages</i>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id = "mytable">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 150px;" class="text-center">
                                    Student Name
                                </th>
                                <th scope="col" class="text-center">Package</th>
                                <th scope="col" style="width: 150px;" class="text-center">Total Hours</th>
                                <th scope="col" style="width: 150px;" class="text-center">Left Hours</th>
                                <th scope="col" style="width: 160px;" class="text-center">Date Purchased</th>
                                <th scope="col" style="width: 140px;" class="text-right" >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td scope="col" class="text-center pl-1 pr-1">{{$order->firstname . ' ' . $order->lastname}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$order->package()['name']}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$order->total_hours}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{$order->left_hours}}</td>
                                <td scope="col" class="text-center pl-1 pr-1">{{date('d/m/Y', strtotime($order->created_at))}}</td>
                                <td scope="col" class="text-right">
                                    @can('edit-users')
                                        [<a href="{{route('admin.student_packages.show', $order)}}">Send Reminder</a>]
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
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
