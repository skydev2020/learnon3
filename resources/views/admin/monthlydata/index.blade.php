@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fab fa-slideshare" style="font-size:24px"> Report Card for Students/Parents</i>
                </div>

                <div class="card-body">
                    <div class="col-8 offset-1">
                        <a href = "{{ route('admin.studenthours.index') }}"> <font size = '+2'> View Student Hours </a>
                    </div>
                        
                    <div class="col-8 offset-1">
                        <a href = "{{ route('admin.tutorhours.index') }}"> <font size = '+2'> View Tutor Hours </a>
                    </div>

                    <div class="col-8 offset-1">
                        <a href = "{{ route('admin.monthlystatistics.index') }}"> <font size = '+2'> View Monthly Statistics </a>
                    </div>

                    <div class="col-8 offset-1">
                        <a href = "{{ route('admin.yearlystatistics.index') }}"> <font size = '+2'> View Yearly Statistics </a>
                    </div>

                    <div class="col-8 offset-1">
                        <a href = ""> <font size = '+2'> Export Payroll CSV (Monthly) </a>
                    </div>
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