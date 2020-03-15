@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">View Monthly Statistics</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.progressreports.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <div class="col-6 d-flex justify-content-end align-items-center">
                                <label for="year" class="col-form-label font-weight-bold">{{ __('Filter by month:') }}</label>
                            </div>
                            <div class="col-3">
                                <select id="year" name="year" class = "form-control">
                                    <?php for ($i = date('Y'); $i >= 1991; $i --) ?>
                                    <option> {{ $i }} </option> 
                                </select>
                            </div>
                            <div class="col-3">
                                <select id="month" name="month" class = "form-control">
                                    <option value = "0"> All Years </option>
                                    <option value = "1" <?= data('M') == 1 ? "selected" : "" ?>>
                                        January </option>
                                    <option value = "2" <?= data('M') == 2 ? "selected" : "" ?>>
                                        February </option>
                                    <option value = "3" <?= data('M') == 3 ? "selected" : "" ?>>
                                        March </option>
                                    <option value = "4" <?= data('M') == 4 ? "selected" : "" ?>>
                                        April </option>
                                    <option value = "5" <?= data('M') == 5 ? "selected" : "" ?>>
                                        May </option>
                                    <option value = "6" <?= data('M') == 6 ? "selected" : "" ?>>
                                        June </option>
                                    <option value = "7" <?= data('M') == 7 ? "selected" : "" ?>>
                                        July </option>
                                    <option value = "8" <?= data('M') == 8 ? "selected" : "" ?>>
                                        August </option>
                                    <option value = "9" <?= data('M') == 9 ? "selected" : "" ?>>
                                        September </option>
                                    <option value = "10" <?= data('M') == 10 ? "selected" : "" ?>>
                                        October </option>
                                    <option value = "11" <?= data('M') == 11 ? "selected" : "" ?>>
                                        November </option>
                                    <option value = "12" <?= data('M') == 12 ? "selected" : "" ?>>
                                        December </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="s_name" class="col-form-label font-weight-bold">{{ __('Student Name:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="s_name" type="text" class="form-control" name="s_name" value="{{ $data['old']['s_name'] }}"
                                autocomplete="s_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="grade" class="col-form-label font-weight-bold">{{ __('Grade:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="grade" type="text" class="form-control" name="grade" value="{{ $data['old']['grade'] }}"
                                autocomplete="grade" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="subjects" class="col-form-label font-weight-bold">{{ __('Subjects:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="subjects" type="text" class="form-control" name="subjects" value="{{ $data['old']['subjects'] }}"
                                autocomplete="subjects" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="date_added" class="col-form-label font-weight-bold">{{ __('Data Received:') }}</label>
                            </div>
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
                <div class="card-body">
                    <div class="col-11 offset-11">
                        <button type = "button" class="btn btn-primary"  onclick = 
                        "exportToExcel('monthly_statistics')">
                            {{ __('Export') }}
                        </button>
                    </div>
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
                        @foreach ($results as $result)
                            <tr>
                                <td scope="col">{{'$ ' . $result['tutoring_revenue']}}</td>
                                <td scope="col">{{'$ ' . $result['assignment_revenue']}}</td>
                                <td scope="col">{{'$ ' . $result['other_revenue']}}</td>
                                <td scope="col">{{'$ ' . $result['total_revenue']}}</td>
                                <td scope="col">{{'$ ' . $result['payroll']}}</td>
                                <td scope="col">{{'$ ' . $result['other_expenses']}}</td>
                                <td scope="col">{{'$ ' . $result['total_expenses']}}</td>
                                <td scope="col">{{'$ ' . $result['total_profit']}}</td>
                                <td scope="col">{{$result['active_students']}}</td>
                                <td scope="col">{{$result['active_tutors']}}</td>
                                <td scope="col">{{$result['active_tutors']}}</td>
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