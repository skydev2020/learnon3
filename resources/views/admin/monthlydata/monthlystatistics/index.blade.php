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
                    <form method="GET" action="{{ route('admin.monthlystatistics.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="year" class="col-form-label font-weight-bold">{{ __('Filter by month:') }}</label>
                            </div>
                            <div class="col-3">
                                <select id="year" name="year" class = "form-control">
                                    <?php for ($i = date('Y'); $i >= 1991; $i --)  {?>
                                    <option <?= (string)$i == $data['old']['year'] ? "selected" : "" ?>> {{ $i }} </option> 
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <select id="month" name="month" class = "form-control">
                                    <option value = "0"> All Months </option>
                                    <option value = "01" <?= $data['old']['month'] == "01" ? "selected" : "" ?>>
                                        January </option>
                                    <option value = "02" <?= $data['old']['month'] == "02" ? "selected" : "" ?>>
                                        February </option>
                                    <option value = "03" <?= $data['old']['month'] == "03" ? "selected" : "" ?>>
                                        March </option>
                                    <option value = "04" <?= $data['old']['month'] == "04" ? "selected" : "" ?>>
                                        April </option>
                                    <option value = "05" <?= $data['old']['month'] == "05" ? "selected" : "" ?>>
                                        May </option>
                                    <option value = "06" <?= $data['old']['month'] == "06" ? "selected" : "" ?>>
                                        June </option>
                                    <option value = "07" <?= $data['old']['month'] == "07" ? "selected" : "" ?>>
                                        July </option>
                                    <option value = "08" <?= $data['old']['month'] == "08" ? "selected" : "" ?>>
                                        August </option>
                                    <option value = "09" <?= $data['old']['month'] == "09" ? "selected" : "" ?>>
                                        September </option>
                                    <option value = "10" <?= $data['old']['month'] == "10" ? "selected" : "" ?>>
                                        October </option>
                                    <option value = "11" <?= $data['old']['month'] == "11" ? "selected" : "" ?>>
                                        November </option>
                                    <option value = "12" <?= $data['old']['month'] == "12" ? "selected" : "" ?>>
                                        December </option>
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
                                "exportToExcel('monthly_statistics')">
                                    {{ __('Export') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id = "monthly_statistics">
                        <thead>
                        <tr>
                            <th scope="col">Tutoring Revenue</th>
                            <th scope="col">Assignment Revenue</th>
                            <th scope="col">Other Revenue</th>
                            <th scope="col">Total Revenue</th>
                            <th scope="col">Total Payroll</th>
                            <th scope="col">Other Expenses</th>
                            <th scope="col">Total Expenses</th>
                            <th scope="col">Total Profit</th>
                            <th scope="col">#Active Students</th>
                            <th scope="col">#Active Tutors</th>
                            <th scope="col">Month Year</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['results'] as $result)
                            <tr>
                                <td scope="col">{{'$ ' . $result['tutoring_revenue']}}</td>
                                <td scope="col">{{'$ ' . $result['assignment_revenue']}}</td>
                                <td scope="col">{{'$ ' . $result['other_revenue']}}</td>
                                <td scope="col">{{'$ ' . $result['total_revenue']}}</td>
                                <td scope="col">{{'$ ' . $result['payroll']}}</td>
                                <td scope="col">{{'$ ' . $result['other_expense']}}</td>
                                <td scope="col">{{'$ ' . $result['total_expense']}}</td>
                                <td scope="col">{{'$ ' . $result['total_profit']}}</td>
                                <td scope="col">{{$result['active_students']}}</td>
                                <td scope="col">{{$result['active_tutors']}}</td>
                                <td scope="col">{{$result['month_year']}}</td>
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