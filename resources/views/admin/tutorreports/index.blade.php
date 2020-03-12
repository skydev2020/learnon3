@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Information</div>
                <div class="card-body">
                    <div class="col-11 offset-11">
                        <button type = "button" class="btn btn-primary"  onclick = 
                        "exportToExcel('tutor_reports')">
                            {{ __('Export') }}
                        </button>
                    </div>
                    <table class="table table-bordered table-striped" id = "tutor_reports">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tutor Name</th>
                            <th scope="col">E-Mail</th>
                            <th scope="col">Students Tutored</th>
                            <th scope="col">Total Hours Tutored</th>
                            <th scope="col">Avg Per Student(Hours)</th>
                            <th scope="col">Avg Per Student(Duration)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td scope="col">{{$report['Id']}}</td>
                                <td scope="col">{{$report['Tutor Name']}}</td>
                                <td scope="col">{{$report['Email']}}</td>
                                <td scope="col">{{$report['Students Tutored']}}</td>
                                <td scope="col">{{$report['Hours Tutored']}}</td>
                                <td scope="col">{{$report['Avg Hours Per Student']}}</td>
                                <td scope="col">{{$report['Average Duration Per Student']}}</td>
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