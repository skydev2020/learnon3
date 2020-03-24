@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">My Students</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('tutor.students.index') }}">
                        @csrf
                        {{method_field('GET')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="s_name" class="col-form-label font-weight-bold">Student Name</label>
                            </div>
                            <div class="col-6">
                                <input id="s_name" type="text" class="form-control" name="s_name" 
                                value="{{ $data['old']['s_name'] }}" autocomplete="s_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="status" class="col-form-label font-weight-bold">Date of Session</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select id="status" class="form-control" name="status">
                                    <option value = ""></option>
                                    <option <?= $data['old']['status'] == "Active" ? "selected" : "" ?>
                                    value = "Active" >Active</option>
                                    <option <?= $data['old']['status'] == "Stop Tutoring" ? "selected" : "" ?>
                                        value = "Stop Tutoring" >Stop Tutoring</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="assigned_at" class="col-form-label font-weight-bold">Date Assigned</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="assigned_at" type="date" class="form-control" name="assigned_at"
                                value="{{ $data['old']['assigned_at'] }}" autocomplete="assigned_at" autofocus>
                            </div>
                        </div>

                        <div class = "form-group row mb-0">
                            <div class="col-4 offset-5">
                                <button type = "submit" class="btn btn-primary">{{ __('Search') }}</button>
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
                            <th scope="col">Student Name</th>
                            <th scope="col">Subjects</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Assigned</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['assignments'] as $assignment)
                            <tr>
                                <td scope="col">{{$assignment->student()['fname']
                                . ' ' . $assignment->student()['lname']}}</td>
                                <td scope="col">{{$data['subjects'][$assignment->id]}}</td>
                                <td scope="col">{{$assignment->status_by_tutor}}</td>
                                <td scope="col">{{ date('d/m/Y', strtotime($assignment->assigned_at)) }}</td>
                                <td scope="col">
                                    @can('manage-tutor-students')
                                        [<a href="{{route('tutor.sessions.create')}}">Log Hours</a>]
                                    @endcan
                                    @can('manage-tutor-students')
                                        [<a href="{{route('tutor.students.show', $assignment->student())}}">View Student Info</a>]
                                    @endcan
                                    @can('manage-tutor-students')
                                    <form action="{{ route('tutor.students.change_status', $assignment) }}" method="POST" class="float-left">
                                    @csrf
                                        {{method_field('PUT')}}
                                        [<a href="javascript:;" onclick="parentNode.submit();">
                                        <?= $assignment->status_by_tutor=="Active" ? "Stop Tuoring" : "Start Tutoring" ?></a>]
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