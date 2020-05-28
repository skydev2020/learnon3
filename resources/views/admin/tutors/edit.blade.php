@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Update Tutor Details</i>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.tutors.update', $data['tutor'])}}" method="POST">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group row">
                            <div class="offset-3 col-8 col-md-6 text-right">
                                <button type="submit" class="btn btn-primary">Update</button>
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
                                 name="email" value="{{$data['tutor']->email }}" required autocomplete="on" autofocus>

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
                                 name="fname" value="{{ $data['tutor']->fname }}" required autofocus>

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
                                 name="lname" value="{{ $data['tutor']->lname }}" required autofocus>

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
                                <input type="text" value="{{$data['tutor']->home_phone}}" name="home_phone"
                                id="home_phone" class="form-control" autocomplete="on" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="cell_phone" class="col-form-label">Cell/Work Phone:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type="text" value="{{$data['tutor']->cell_phone}}" name="cell_phone"
                                id="cell_phone" class="form-control" autocomplete="on" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="password" class="col-form-label">
                                    <span class="required">*</span> Password:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type="password" name="password" id="password" pattern="^\S{8,}$"
                                class="form-control" autocomplete="on" autofocus title="Must have at least 8 characters">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="password-confirm" class="col-form-label">
                                    <span class="required">*</span> Confirm:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input id="password-confirm" type="password" pattern="^\S{8,}$" class="form-control"
                                name="password_confirmation" autocomplete="on" oninput="checkPwd();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="address" class="col-form-label">
                                    <span class="required">*</span> Home Address:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type="text" value="{{$data['tutor']->address}}" name="address" required
                                id="address" class="form-control" autocomplete="on" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="city" class="col-form-label">
                                    <span class="required">*</span> City:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input type="text" value="{{$data['tutor']->city}}" name="city" required
                                id="city" class="form-control" autocomplete="on" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="state_id" class="col-form-label">
                                    <span class="required">*</span> State/Province:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select name="state_id" id="state_id" class="form-control">
                                    @foreach ($data['states'] as $state)
                                        <option <?= $state->id==$data['tutor']->state_id?'selected':''?>
                                            value="{{$state->id}}">{{$state->name}}</option>
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
                                <input type="text" value="{{$data['tutor']->pcode}}" name="pcode" required
                                id="pcode" class="form-control" autocomplete="on" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="country_id" class="col-form-label">
                                    <span class="required">*</span> Country:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select name="country_id" id="country_id" class="form-control">
                                    @foreach ($data['countries'] as $country)
                                        <option <?= $country->id==$data['tutor']->country_id?'selected':''?>
                                            value="{{$country->id}}">{{$country->name}}</option>
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
                                id="other_notes" autofocus>{{$data['tutor']->other_notes}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="post_secondary_edu" class="col-form-label text-center">
                                    <span class="required">*</span> Post Secondary Education attending / attended:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <textarea name="post_secondary_edu" required class="form-control inputstl" rows="4"
                                id="post_secondary_edu" autofocus>{{$data['tutor']->post_secondary_edu}}</textarea>
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
                                id="subjects_studied" autofocus>{{$data['tutor']->subjects_studied}}</textarea>
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
                                id="tutoring_courses" autofocus>{{$data['tutor']->tutoring_courses}}</textarea>
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
                                id="work_experience" autofocus>{{$data['tutor']->work_experience}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="tutoring_areas" class="col-form-label text-center">
                                    <span class="required">*</span> City/suburbs/area you can tutor:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <textarea name="tutoring_areas" required class="form-control inputstl" rows="4"
                                id="tutoring_areas" autofocus>{{$data['tutor']->tutoring_areas}}</textarea>
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
                                id="references" autofocus>{{$data['tutor']->references}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="gender" class="col-form-label text-center">
                                Please indicate Male or Female:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select name="gender" required class="form-control"
                                id="gender" autofocus>
                                    <option <?= $data['tutor']->gender=="Male" ? 'selected' : ''?>
                                    >Male</option>
                                    <option <?= $data['tutor']->gender=="Female" ? 'selected' : ''?>
                                    >Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="certified_teacher_yes" class="col-form-label text-center">
                                    <span class="required">*</span> Are you a "certified teacher"?
                                </label>
                            </div>
                            <div class="col-8 col-md-6 d-flex align-items-center">
                                <label class="radio-inline mb-0">
                                    <input type="radio" <?=$data['tutor']->certified_teacher>0?'checked':''?>
                                    name="certified_teacher" id="certified_teacher_yes" value="1">&nbsp;Yes
                                </label> &nbsp; &nbsp;
                                <label class="radio-inline mb-0">
                                    <input type="radio" <?=$data['tutor']->certified_teacher<=0?'checked':''?>
                                    name="certified_teacher" id="certified_teacher_no" value="0">&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="criminal_record" class="col-form-label text-center">
                                    <span class="required">*</span> Have you ever had a criminal conviction (disregarding minor traffic violations)?
                                </label>
                            </div>
                            <div class="col-8 col-md-6 d-flex align-items-center">
                                <label class="radio-inline mb-0">
                                    <input type="radio" <?=$data['tutor']->criminal_record>0?'checked':''?>
                                    name="criminal_record_yes" id="criminal_record_yes" value="1">&nbsp;Yes
                                </label> &nbsp; &nbsp;
                                <label class="radio-inline mb-0">
                                    <input type="radio" <?=$data['tutor']->criminal_record<=0?'checked':''?>
                                    name="criminal_record" id="criminal_record_no" value="0">&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end font-weight-bold align-items-center">
                                <label for="criminal_check_yes" class="col-form-label text-center">
                                    <span class="required">*</span> Would you be willing to provide a background criminal check?
                                </label>
                            </div>
                            <div class="col-8 col-md-6 d-flex align-items-center">
                                <label class="radio-inline mb-0">
                                    <input type="radio" <?=$data['tutor']->criminal_check>0?'checked':''?>
                                    name="criminal_check" id="criminal_check_yes" value="1">&nbsp;Yes
                                </label> &nbsp; &nbsp;
                                <label class="radio-inline mb-0">
                                    <input type="radio" <?=$data['tutor']->criminal_check<=0?'checked':''?>
                                    name="criminal_check" id="criminal_check_no" value="0">&nbsp;No
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
                                    <option <?= $data['tutor']->approved > 0 ? "selected" : "" ?> value = "1">
                                        Enabled</option>
                                    <option <?= $data['tutor']->approved <= 0 ? "selected" : "" ?> value = "0">
                                        Disabled</option>
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
                                    <option <?= $data['tutor']->status > 0 ? "selected" : "" ?>
                                         value = "1">Enabled</option>
                                    <option <?= $data['tutor']->status <= 0 ? "selected" : "" ?>
                                         value = "0">Disabled</option>
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
