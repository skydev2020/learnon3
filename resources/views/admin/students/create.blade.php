@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Students</i>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.students.store') }}" onsubmit="return submitOnValid()">
                        @csrf
                        {{method_field('POST')}}
                        <div class="form-group row">
                            <div class="offset-3 col-8 col-md-6 text-right">
                                <button class = "btn btn-primary" type = "submit">Save</button>
                                &nbsp;&nbsp;
                                <a href = "{{route('admin.students.index')}}">
                                    <button class = "btn btn-primary" type = "button">Cancel</button>
                                </a>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "email" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> E-Mail:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" onblur="checkMailStatus()">
                                <span style="color: red; display: none;" id="dup_email_prob"><b>Email already Exists !</b></span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "fname" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> First Name
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type = "text" id = "fname" name = "fname" class = "form-control"
                                    autocomplete= "fname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "lname" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Last Name
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type = "text" id = "lname" name = "lname" class = "form-control"
                                    autocomplete= "lname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "password" class="col-form-label text-md-right font-weight-bold">Password:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input id="password" type="password" name="password" required autocomplete="on"
                                class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for="password-confirm" class="col-form-label font-weight-bold">Confirm:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="on">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="grade_id" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Current Grade / Year
                                </label>
                            </div>

                            <div class="col-8 col-md-6 d-flex align-items-center">
                                <select name="grade_id" id="grade_id" onchange="getSubjects(this.value);" class="form-control">
                                    @foreach($grades as $grade)
                                    <option value = {{$grade->id}} > {{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label font-weight-bold">Subjects:</label>
                            </div>

                            <div class="col-8 col-md-6 d-flex flex-column">
                                <div class="scrollbox pl-1 pt-1 overflow-auto" id="subjects_box" name = "subjects_box">

                                </div>
                                <div>
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', 'checked');"><u>Select All</u></a> /
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', false);"><u>Unselect All</u></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "parent_fname" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Parent First Name:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type = "text" id = "parent_fname" name = "parent_fname" class = "form-control"
                                    autocomplete= "parent_fname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "parent_lname" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>Parent Last Name:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type = "text" id = "parent_lname" name = "parent_lname" class = "form-control"
                                    autocomplete= "parent_lname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "home_phone" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Telephone:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type = "text" id = "home_phone" name = "home_phone" class = "form-control"
                                    autocomplete= "home_phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "cell_phone" class="col-form-label font-weight-bold">Cell/Work Phone:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type = "text" id = "cell_phone" name = "cell_phone" class = "form-control"
                                    autocomplete= "cell_phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "address" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Address:
                                </label>
                            </div>
                            <div class="col-8 col-md-6 col-form-label">
                                <input type = "text" id = "address" name = "address" class = "form-control"
                                    autocomplete= "address" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "city" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> City:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type = "text" id = "city" name = "city" class = "form-control"
                                    autocomplete= "city" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "state_id" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>Region / State:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select id = "state_id" name = "state_id" class = "form-control">
                                    @foreach ($states as $state)
                                    <option value = "{{$state->id}}"> {{$state->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "pcode" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Postcode:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type = "text" id = "pcode" name = "pcode" class = "form-control"
                                autocomplete= "pcode" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "country_id" class="font-weight-bold">
                                    <span class="required">*</span> Country:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select id = "country_id" name = "country_id" class = "form-control">
                                    @foreach ($countries as $country)
                                    <option value = "{{$country->id}}"> {{$country->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "service_method" class="font-weight-bold">
                                    <span class="required">*</span> Service Method:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select id = "service_method" name = "service_method" class = "form-control">
                                    <option value = "Online">Online Video Tutoring</option>
                                    <option value = "Home">In Person Tutoring</option>
                                    <option value = "Both">Mix of Both</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "other_notes" class="font-weight-bold">Notes:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <textarea id = "other_notes" name = "other_notes" class = "form-control inputstl"
                                autocomplete= "other_notes" autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "major_intersection" class="font-weight-bold">
                                    <span class="required">*</span> Major Street intersection:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type = "text" id = "major_intersection" name = "major_intersection" class = "form-control"
                                autocomplete= "major_intersection" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "school" class="font-weight-bold">
                                    <span class="required">*</span> School name:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type = "text" id = "school" name = "school" class = "form-control"
                                autocomplete= "school" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "referrer_id" class="font-weight-bold">How you heard about us:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select id = "referrer_id" name = "referrer_id" class = "form-control">
                                    @foreach ($referrers as $referrer)
                                    <option value = "{{$referrer->id}}"> {{$referrer->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "student_status_id" class="font-weight-bold">Tutoring Status:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select id = "student_status_id" name = "student_status_id" class = "form-control">
                                    @foreach ($student_statuses as $status)
                                    <option value = "{{$status->id}}"> {{$status->title}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "approved" class="font-weight-bold">Approved:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select id = "approved" name = "approved" class = "form-control">
                                    <option value = "1">Enabled</option>
                                    <option value = "0">Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "status" class="font-weight-bold">Status:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select id = "status" name = "status" class = "form-control">
                                    <option value = "1" >Enabled</option>
                                    <option value = "0">Disabled</option>
                                </select>
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
    var grades_json = '<?php echo json_encode($grades_array, JSON_HEX_APOS) ?>';
    var grades = eval(grades_json);

</script>
<script src="{{ asset('js/register/register.js')}}"></script>

@stop
