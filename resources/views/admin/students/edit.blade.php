@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Students</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.students.update', $student) }}">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group row">
                            <div class="col-1 offset-10">
                                <button class = "btn btn-primary" type = "submit">Save</button>
                            </div>
                            <div class="col-1">
                                <a href = "{{route('admin.students.index')}}">
                                    <button class = "btn btn-primary" type = "button">Cancel</button>
                                </a>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "fname" class="col-form-label font-weight-bold">First Name</label>
                            </div>
                            <div class="col-3">
                                <input type = "text" id = "fname" name = "fname" class = "form-control"
                                    value = "{{$student->fname}}" autocomplete= "fname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "lname" class="col-form-label font-weight-bold">Last Name</label>
                            </div>
                            <div class="col-3">
                                <input type = "text" id = "lname" name = "lname" class = "form-control"
                                    value = "{{$student->lname}}" autocomplete= "lname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "email" class="col-form-label font-weight-bold">E-Mail:</label>
                            </div>
                            <div class="col-3">
                                <input type = "email" id = "email" name = "email" class = "form-control"
                                    value = "{{$student->email}}" autocomplete= "email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "password" class="col-form-label text-md-right font-weight-bold">Password:</label>
                            </div>
                            <div class="col-3">
                                <input id="password" type="password" name="password" required autocomplete="new-password"
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
                            <div class="col-3">
                                <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="grade_id" class="col-form-label font-weight-bold">Current Grade / Year</label>
                            </div>

                            <div class="col-2 d-flex align-items-center">
                                <select name="grade_id" id="grade_id" onchange="getSubjects(this.value);" class="form-control">
                                    @foreach($grades as $grade)
                                    <option <?= $student->grade_id == $grade->id ? "selected" : "" ?>
                                    value = {{$grade->id}} > {{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label font-weight-bold">Subjects:</label>
                            </div>

                            <div class="col-2 d-flex flex-column">
                                <div class="scrollbox pl-1 pt-1 overflow-auto" id="subjects_box" name = "subjects_box">
                                    @foreach ($student->subjects()->get() as $subject)
                                    <div>
                                        <input type = "checkbox" checked>{{$subject->name}}
                                    </div>
                                    @endforeach
                                </div>
                                <div>
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', 'checked');"><u>Select All</u></a> /
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', false);"><u>Unselect All</u></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "parent_fname" class="col-form-label font-weight-bold">Parent First Name:</label>
                            </div>
                            <div class="col-3">
                                <input type = "text" id = "parent_fname" name = "parent_fname" class = "form-control"
                                    value = "{{$student->parent_fname}}" autocomplete= "parent_fname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "parent_lname" class="col-form-label font-weight-bold">Parent Last Name:</label>
                            </div>
                            <div class="col-3">
                                <input type = "text" id = "parent_lname" name = "parent_lname" class = "form-control"
                                    value = "{{$student->parent_lname}}" autocomplete= "parent_lname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "home_phone" class="col-form-label font-weight-bold">Telephone:</label>
                            </div>
                            <div class="col-3">
                                <input type = "text" id = "home_phone" name = "home_phone" class = "form-control"
                                    value = "{{$student->home_phone}}" autocomplete= "home_phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "cell_phone" class="col-form-label font-weight-bold">Cell/Work Phone:</label>
                            </div>
                            <div class="col-3">
                                <input type = "text" id = "cell_phone" name = "cell_phone" class = "form-control"
                                    value = "{{$student->cell_phone}}" autocomplete= "cell_phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "address" class="col-form-label font-weight-bold">Address:</label>
                            </div>
                            <div class="col-3 col-form-label">
                                <input type = "text" id = "address" name = "address" class = "form-control"
                                    value = "{{$student->address}}" autocomplete= "address" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "city" class="col-form-label font-weight-bold">City:</label>
                            </div>
                            <div class="col-3">
                                <input type = "text" id = "city" name = "city" class = "form-control"
                                    value = "{{$student->city}}" autocomplete= "city" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "state_id" class="col-form-label font-weight-bold">Region / State:</label>
                            </div>
                            <div class="col-2">
                                <select id = "state_id" name = "state_id" class = "form-control">
                                    @foreach ($states as $state)
                                    <option <?= $state->id == $student->state_id ? "selected" : "" ?>
                                        value = "{{$state->id}}"> {{$state->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "pcode" class="col-form-label font-weight-bold">Postcode:</label>
                            </div>
                            <div class="col-3">
                                <input type = "text" id = "pcode" name = "pcode" class = "form-control"
                                value = "{{$student->pcode}}" autocomplete= "pcode" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "country_id" class="font-weight-bold">Country:</label>
                            </div>
                            <div class="col-2">
                                <select id = "country_id" name = "country_id" class = "form-control">
                                    @foreach ($countries as $country)
                                    <option <?= $country->id == $student->country_id ? "selected" : "" ?>
                                        value = "{{$state->id}}"> {{$country->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "service_method" class="font-weight-bold">Service Method:</label>
                            </div>
                            <div class="col-2">
                                <select id = "service_method" name = "service_method" class = "form-control">
                                    <option <?= $student->service_method == "Online" ? "selected" : "" ?>
                                        value = "Online">Online Video Tutoring</option>
                                    <option <?= $student->service_method == "HOme" ? "selected" : "" ?>
                                        value = "Home">In Person Tutoring</option>
                                    <option <?= $student->service_method == "Both" ? "selected" : "" ?>
                                        value = "Both">Mix of Both</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "other_notes" class="font-weight-bold">Notes:</label>
                            </div>
                            <div class="col-4">
                                <textarea id = "other_notes" name = "other_notes" class = "form-control inputstl"
                                autocomplete= "other_notes" autofocus>{{$student->other_notes}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "major_intersection" class="font-weight-bold">Major Street intersection:</label>
                            </div>
                            <div class="col-3">
                                <input type = "text" id = "major_intersection" name = "major_intersection" class = "form-control"
                                value = "{{$student->major_intersection}}" autocomplete= "major_intersection" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "school" class="font-weight-bold">School name:</label>
                            </div>
                            <div class="col-3">
                                <input type = "text" id = "school" name = "school" class = "form-control"
                                value = "{{$student->school}}" autocomplete= "school" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "referrer_id" class="font-weight-bold">How you heard about us:</label>
                            </div>
                            <div class="col-2">
                                <select id = "referrer_id" name = "referrer_id" class = "form-control">
                                    @foreach ($referrers as $referrer)
                                    <option <?= $referrer->id == $student->referrer_id ? "selected" : "" ?>
                                        value = "{{$referrer->id}}"> {{$referrer->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "student_status_id" class="font-weight-bold">Tutoring Status:</label>
                            </div>
                            <div class="col-2">
                                <select id = "student_status_id" name = "student_status_id" class = "form-control">
                                    @foreach ($student_statuses as $status)
                                    <option <?= $status->id == $student->student_status_id ? "selected" : "" ?>
                                        value = "{{$status->id}}"> {{$status->title}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "approved" class="font-weight-bold">Approved:</label>
                            </div>
                            <div class="col-1">
                                <select id = "approved" name = "approved" class = "form-control">
                                    <option value = "1" <?= $student->approved == 1 ? "selected" : "" ?>
                                        >Enabled</option>
                                    <option value = "0" <?= $student->approved != 1 ? "selected" : "" ?>
                                        >Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 col-form-label d-flex justify-content-end align-items-center">
                                <label for = "status" class="font-weight-bold">Status:</label>
                            </div>
                            <div class="col-1">
                                <select id = "status" name = "status" class = "form-control">
                                    <option value = "1" <?= $student->status == 1 ? "selected" : "" ?>
                                        >Enabled</option>
                                    <option value = "0" <?= $student->status != 1 ? "selected" : "" ?>
                                        >Disabled</option>
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
<script src="{{ asset('js/register/subjects.js')}}"></script>

@stop