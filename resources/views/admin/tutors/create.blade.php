@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Add Tutor</i>
                </div>
                <div class="card-body">
                    <form name="tutor_frm" action="{{route('admin.tutors.store')}}" method="POST" onsubmit="return submitOnValid()">
                        @csrf
                        {{method_field('POST')}}
                        <div class="form-group row">
                            <div class="offset-3 col-8 col-md-6 text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                                &nbsp;&nbsp;
                                <a href="{{ route('admin.tutors.index') }}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="email" class="col-form-label">
                                    <span class="required">*</span> Email
                                </label>
                            </div>

                            <div class="col-8 col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                 name="email" required autocomplete="email" autofocus onblur="checkMailStatus()">
                                 <span style="color: red; display: none;" id="dup_email_prob"><b>Email already Exists !</b></span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="fname" class="col-form-label">
                                    <span class="required">*</span> First Name:
                                </label>
                            </div>

                            <div class="col-8 col-md-6">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror"
                                 name="fname" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="fname" class="col-form-label">
                                    <span class="required">*</span> Last Name:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror"
                                 name="lname" required autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="home_phone" class="col-form-label">
                                     Home Phone:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type="text" name="home_phone" id="home_phone"
                                class="form-control" autocomplete="home_phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="cell_phone" class="col-form-label">Cell/Work Phone:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type="text" name="cell_phone" id="cell_phone"
                                class="form-control" autocomplete="cell_phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="password" class="col-form-label">
                                    <span class="required">*</span> Password:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input id="password" type="password" name="password" required pattern="^\S{8,}$" autocomplete="on" oninput="checkPwd();" 
                                class="form-control @error('password') is-invalid @enderror" title="Must have at least 8 characters">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="password-confirm" class="col-form-label">
                                    <span class="required">*</span> Confirm:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input id="password-confirm" type="password" class="form-control" pattern="^\S{8,}$"
                                name="password_confirmation" required autocomplete="on" oninput="checkPwd();"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="address" class="col-form-label">
                                    <span class="required">*</span> Home Address:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type="text" name="address" required id="address"
                                class="form-control" autocomplete="address" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="city" class="col-form-label">
                                    <span class="required">*</span> City:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type="text" name="city" required id="city"
                                class="form-control" autocomplete="city" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="state_id" class="col-form-label">
                                    <span class="required">*</span> State/Province:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select name="state_id" id="state_id" class="form-control" required>
                                    <option value="">--Select A Province / State--</option>
                                    @foreach ($data['states'] as $state)
                                    <option value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="pcode" class="col-form-label">
                                    <span class="required">*</span> Postal/Zip Code:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type="text" name="pcode" required id="pcode"
                                class="form-control" autocomplete="pcode" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="country_id" class="col-form-label">
                                    <span class="required">*</span> Country:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select name="country_id" id="country_id" class="form-control" required>
                                    <option value="">--Select Country--</option>
                                    @foreach ($data['countries'] as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="other_notes" class="col-form-label">
                                    <span class="required">*</span> Other Notes:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <textarea name="other_notes" required class="form-control inputstl" rows="4"
                                id="other_notes" autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="post_secondary_edu" class="col-form-label">
                                    <span class="required">*</span> Post Secondary Education attending / attended:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <textarea name="post_secondary_edu" required class="form-control inputstl" rows="4"
                                id="post_secondary_edu" autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="subjects_studied" class="col-form-label text-center">
                                    <span class="required">*</span> Subjects studied/major area of concentration (please indicate grades and grade point averages):
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <textarea name="subjects_studied" required class="form-control inputstl" rows="4"
                                id="subjects_studied" autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="tutoring_courses" class="col-form-label text-center">
                                    <span class="required">*</span> Courses you can tutor for each grade level (list each course, please be as detailed as possible):
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <textarea name="tutoring_courses" required class="form-control inputstl" rows="4"
                                id="tutoring_courses" autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="work_experience" class="col-form-label text-center">
                                    <span class="required">*</span> Please provide past job/work experience:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <textarea name="work_experience" required class="form-control inputstl" rows="4"
                                id="work_experience" autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="tutoring_areas" class="col-form-label">
                                    <span class="required">*</span> City/suburbs/area you can tutor:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <textarea name="tutoring_areas" required class="form-control inputstl" rows="4"
                                id="tutoring_areas" autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="references" class="col-form-label text-center">
                                    <span class="required">*</span> Please provide 3 references (name, phone and email, and how they know you):
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <textarea name="references" required class="form-control inputstl" rows="4"
                                id="references" autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="gender" class="col-form-label">
                                Please indicate Male or Female:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select name="gender" required class="form-control"
                                id="gender" autofocus>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="certified_teacher_yes" class="col-form-label">
                                    <span class="required">*</span> Are you a "certified teacher"?
                                </label>
                            </div>
                            <div class="col-8 col-md-6 d-flex align-items-center">
                                <label class="radio-inline mb-0">
                                    <input type="radio" name="certified_teacher" required id="certified_teacher_yes" value="1">&nbsp;Yes
                                </label> &nbsp; &nbsp;
                                <label class="radio-inline mb-0">
                                    <input type="radio" name="certified_teacher" required id="certified_teacher_no" value="0">&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="criminal_record_yes" class="col-form-label  text-center">
                                    <span class="required">*</span> Have you ever had a criminal conviction (disregarding minor traffic violations)?
                                </label>
                            </div>
                            <div class="col-8 col-md-6 d-flex align-items-center">
                                <label class="radio-inline mb-0">
                                    <input type="radio" name="criminal_record" required id="criminal_record_yes" value="1">&nbsp;Yes
                                </label> &nbsp; &nbsp;
                                <label class="radio-inline mb-0">
                                    <input type="radio" name="criminal_record" required id="criminal_record_no" value="0">&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="criminal_check_yes" class="col-form-label">
                                    <span class="required">*</span> Would you be willing to provide a background criminal check?
                                </label>
                            </div>
                            <div class="col-8 col-md-6 d-flex align-items-center">
                                <label class="radio-inline">
                                    <input type="radio" name="criminal_check" required id="criminal_check_yes" value="1">&nbsp;Yes
                                </label> &nbsp; &nbsp;
                                <label class="radio-inline">
                                    <input type="radio" name="criminal_check" required id="criminal_check_no" value="0">&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="approved" class="col-form-label text-right">
                                    {{ __('Approved') }}
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select style="display: inline-block;" id="approved" name="approved" class = "form-control">
                                    <option value = "1">Enabled</option>
                                    <option value = "0">Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="status" class="col-form-label text-right">
                                    {{ __('Status') }}
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select style="display: inline-block;" id="status" name="status" class = "form-control">
                                    <option value = "1">Enabled</option>
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
<script src="{{ asset('js/admin/tutor_register.js')}}"></script>
@stop