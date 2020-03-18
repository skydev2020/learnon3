@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Send Email</div>
                <div class="card-body">
                    <form action="{{route('admin.notification.send')}}" method="GET">
                        <div class = "form-group row">
                            <div class="col-1 offset-10">
                                <button type = "submit" class="btn btn-primary" >Send</button>
                            </div>
                            <div class="col-1">
                                <a href = "admin.notification.index">
                                    <button type = "button" class="btn btn-primary" >Cacel</button>
                                </a>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for="receivers" class="col-form-label font-weight-bold">
                                    To:</label>
                            </div>

                            <div class="col-6">
                                <select id = "receivers" name = "receivers" class = "form-control"
                                    onchange = "onreceiverchanged()">
                                    <option value = "1">All Users</option>
                                    <option value = "2">User Group</option>
                                    <option value = "3">Users</option>
                                </select>
                            </div>
                        </div> 

                        <div id = "receiver_box">
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for="subject" class="col-form-label font-weight-bold">Subject:</label>
                            </div>

                            <div class = "col-6">
                                <input id="subject" type="text" class="form-control"
                                 name="subject" required autocomplete = "subject" autofocus>
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for="message" class="col-form-label font-weight-bold">
                                    Text:</label>
                            </div>

                            <div class="col-6">
                                <textarea id = "message" name = "message" required
                                autocomplete = "message" autofocus class = "form-control"> </textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Scripts -->
@section("jssection")
<script>
    var users_json = '<?php echo json_encode($data['users'], JSON_HEX_APOS) ?>';
    var users = eval(users_json);

    // var admin_json = '<?php echo json_encode($data['administrator'], JSON_HEX_APOS) ?>';
    // var admin = eval(admin_json);

    var tutors_json = '<?php echo json_encode($data['tutors'], JSON_HEX_APOS) ?>';
    var tutors = eval(tutors_json);

    var students_json = '<?php echo json_encode($data['students'], JSON_HEX_APOS) ?>';
    var students = eval(students_json);
</script>
<script src = "{{asset('js/register/email_send.js')}}"></script>
@stop