@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">My Sessions</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('tutor.sessions.index') }}">
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
                                <label for="session_date" class="col-form-label font-weight-bold">Date of Session</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="session_date" type="date" class="form-control" name="session_date"
                                value="{{ $data['old']['session_date'] }}" autocomplete="session_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="session_duration" class="col-form-label font-weight-bold">Date of Session</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select id="session_duration" class="form-control" name="session_duration">
                                    <option value = ""></option>
                                    @foreach ($data['durations'] as $key => $value)
                                    <option <?= $key == $data['old']['session_duration'] ? "selected" : "" ?>
                                    value = "{{$key}}" >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="session_notes" class="col-form-label font-weight-bold">Session Notes</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="session_notes" type="text" class="form-control" name="session_notes"
                                value="{{ $data['old']['session_notes'] }}" autocomplete="session_notes" autofocus>
                            </div>
                        </div>

                        <div class = "form-group row mb-0">
                            <div class="col-1 offset-10">
                                <button type = "submit" class="btn btn-primary">{{ __('Search') }}</button>
                            </div>

                            <div class="col-1">
                                <a href = "{{ route('tutor.sessions.create') }}">
                                    <button type = "button" class="btn btn-primary">Log Hours</button>
                                </a>
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
                            <th scope="col">Date of Session</th>
                            <th scope="col">Duration of Session</th>
                            <th scope="col">Session Notes</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['sessions'] as $session)
                            <tr>
                                <td scope="col">{{$session->assignments()->first()->student()['fname']
                                . ' ' . $session->assignments()->first()->student()['lname']}}</td>
                                <td scope="col">{{date('d/m/Y', strtotime($session->session_date))}}</td>
                                <td scope="col">{{$data['durations'][$session->session_duration]}}</td>
                                <td scope="col">{{$session['session_notes']}}</td>
                                <td scope="col">
                                    @can('manage-sessions')
                                        [<a href="{{route('tutor.sessions.edit', $session)}}">Edit</a>]
                                    @endcan
                                    @can('manage-sessions')
                                    <form action="{{ route('tutor.sessions.destroy', $session) }}" method="POST" class="float-left">
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