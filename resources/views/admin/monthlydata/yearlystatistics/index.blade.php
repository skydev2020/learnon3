@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px;">View Monthly Statistics</i>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.yearlystatistics.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <div class="col-5 d-flex justify-content-end align-items-center">
                                <label for="year" class="col-form-label font-weight-bold">{{ __('Filter by month:') }}</label>
                            </div>
                            <div class="col-2">
                                <select id="year" name="year" class = "form-control">
                                    <option value = "0">All Years</option>
                                    <?php for ($i = date('Y'); $i >= 1991; $i --)  {?>
                                    <option <?= (string)$i == $data['old']['year'] ? "selected" : "" ?>> {{ $i }} </option> 
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-6 offset-5">
                                <button type = "submit" class="btn btn-primary" >
                                    {{ __('Search') }}</button>
                            </div>
                            <div class="col-1">
                                <button type = "button" class="btn btn-primary"  onclick = 
                                "exportToExcel('yearly_statistics')">
                                    {{ __('Export') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id = "yearly_statistics">
                        <thead>
                        <tr>
                            <th scope="col">Total Revenue</th>
                            <th scope="col">Hours Tutors</th>
                            <th scope="col">Total Expenses</th>
                            <th scope="col">Total Profit</th>
                            <th scope="col">#Active Students</th>
                            <th scope="col">#Active Tutors</th>
                            <th scope="col">Year</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['results'] as $result)
                            <tr>
                                <td scope="col">{{'£' . $result['total_revenue']}}</td>
                                <td scope="col">{{$result['hours_tutors']}}</td>
                                <td scope="col">{{'£' . $result['total_expense']}}</td>
                                <td scope="col">{{'£' . $result['total_profit']}}</td>
                                <td scope="col">{{$result['active_students']}}</td>
                                <td scope="col">{{$result['active_tutors']}}</td>
                                <td scope="col">{{$result['year']}}</td>
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