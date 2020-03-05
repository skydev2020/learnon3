@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Monthly Expenses</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.expenses.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="e_name" class="col-form-label font-weight-bold">{{ __('Expense Name:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="e_name" type="text" class="form-control" name="e_name" value="{{ $data['old']['e_name'] }}"
                                autocomplete="e_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="amount" class="col-form-label font-weight-bold">{{ __('Amount:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "amount" id = "amount" class = "form-control"
                                value="{{ $data['old']['amount'] }}" autocomplete="amount" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="expense_date" class="col-form-label font-weight-bold">{{ __('Expense Date:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="expense_date" type="date" class="form-control" name="expense_date"
                                value="{{ $data['old']['expense_date'] }}" autocomplete="expense_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group col-3 d-flex float-left justify-content-end">
                            <button type = "submit" class="btn btn-primary"  name="action" value="search">
                                    {{ __('Search') }}
                                </button>
                        </div>

                        <div class="form-group col-2 d-flex float-left justify-content-end">
                            <a href = "{{ route('admin.expenses.create') }}"> <button class="btn btn-primary">
                                    {{ __('ADD') }}
                                </button>
                                </a>
                        </div>

                        <div class="form-group col-2 d-flex float-left justify-content-end">
                            <button class="btn btn-primary" id="btn_export" onclick="exportToExcel('expenses')">
                            {{ __('Export') }}</button>
                        </div>
                    </form>
                    
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.expenses.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row float-left col-4 ">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                <label for="start_date" class="col-form-label font-weight-bold">{{ __('Start Date:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="start_date" type="date" class="form-control" name="start_date"
                                value="{{ $data['old']['start_date'] }}" autocomplete="start_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row float-left col-4">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                <label for="end_date" class="col-form-label font-weight-bold">{{ __('End Date:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="end_date" type="date" class="form-control" name="end_date"
                                value="{{ $data['old']['end_date'] }}" autocomplete="end_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary" name="action" value="date_search">
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

                    <table class="table table-bordered table-striped" id = "expenses">
                        <thead>
                        <tr>
                            <th scope="col">Expense Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Expense Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['expenses'] as $expense)
                            <tr>
                                <td scope="col">{{$expense->name}}</td>
                                <td scope="col">{{$expense->amount}}</td>
                                <td scope="col">{{date('d/m/Y', strtotime($expense->date))}}</td>
                                <td scope="col">
                                    @can('manage-payments')
                                        [<a href="{{route('admin.expenses.edit', $expense)}}">Edit</a>]
                                    @endcan
                                    @can('manage-payments')
                                    <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST" class="float-left">
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