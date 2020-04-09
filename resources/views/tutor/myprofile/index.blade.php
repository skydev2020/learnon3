@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px;"> My Account Information</i>
                </div>
                <div class="card-body">
                    <form action="{{route('tutor.myprofile.update', $data['myuser'])}}" method="POST">
                        <div class="form-group row">
                            <label for="fname" class="col-4 col-form-label text-right">First Name:</label>

                            <div class="col-6">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror"
                                 name="fname" value="{{ $data['myuser']->fname }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lname" class="col-4 col-form-label text-right">Last Name:</label>

                            <div class="col-6">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror"
                                 name="lname" value="{{ $data['myuser']->lname }}" required autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="home_phone" class="col-4 col-form-label text-right">Home Phone:</label>

                            <div class="col-6">
                                <input id="home_phone" type="text" class="form-control @error('home_phone') is-invalid @enderror"
                                 name="home_phone" value="{{ $data['myuser']->home_phone }}" required autofocus>

                                @error('home_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cell_phone" class="col-4 col-form-label text-right">Cell/Work Phone:</label>

                            <div class="col-6">
                                <input id="cell_phone" type="text" class="form-control @error('cell_phone') is-invalid @enderror"
                                 name="cell_phone" value="{{ $data['myuser']->cell_phone }}" required autofocus>

                                @error('cell_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group row">
                            <label for="password" class="col-4 col-form-label text-right">Password:</label>

                            <div class="col-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                 name="password" value="{{ $data['myuser']->password }}" required autofocus>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-conform" class="col-4 col-form-label text-right">{{ __('Confirm:') }}</label>
                            <div class="col-6 d-flex align-items-center">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password" value="{{ $data['myuser']->password }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-4 col-form-label text-right">Home Address:</label>

                            <div class="col-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                 name="address" value="{{$data['myuser']->address }}" required autocomplete="address" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-4 col-form-label text-right">City:</label>

                            <div class="col-6">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                                 name="city" value="{{$data['myuser']->city }}" required autocomplete="city" autofocus>

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state_id" class="col-4 col-form-label text-right">Province/State:</label>
                            <div class="col-6 d-flex align-items-center">
                                <select name="state_id" id="state_id">
                                    @foreach($data['states'] as $state)
                                        <option value = {{$state->id}} <?=$state->id==$data['myuser']->state_id?"selected":""?>>
                                             {{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pcode" class="col-4 col-form-label text-right">Postal/Zip Code:</label>

                            <div class="col-6">
                                <input id="pcode" type="text" class="form-control @error('pcode') is-invalid @enderror"
                                 name="pcode" value="{{$data['myuser']->pcode }}" required autocomplete="pcode" autofocus>

                                @error('pcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country_id" class="col-4 col-form-label text-right">Country:</label>
                            <div class="col-6 d-flex align-items-center">
                                <select name="country_id" id="country_id">
                                    @foreach($data['countries'] as $country)
                                        <option value = {{$country->id}} <?=$country->id==$data['myuser']->country_id?"selected":""?>>
                                             {{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group row">
                            <label for="email" class="col-4 col-form-label text-right">E-mail:</label>

                            <div class="col-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                 name="email" value="{{$data['myuser']->email }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="other_notes" class="col-4 col-form-label text-right">Other Notes:</label>

                            <div class="col-6">
                                <textarea id="other_notes" class="form-control inputstl @error('other_notes') is-invalid @enderror"
                                 name="other_notes" required autocomplete="other_notes" autofocus>{{$data['myuser']->other_notes}}</textarea>

                                @error('other_notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="post_secondary_edu" class="col-4 col-form-label text-right">
                                Post Secondary Education attending/attended:</label>

                            <div class="col-6">
                                <textarea id="post_secondary_edu" class="form-control inputstl @error('post_secondary_edu') is-invalid @enderror"
                                 name="post_secondary_edu" required autocomplete="post_secondary_edu" autofocus>{{$data['myuser']->post_secondary_edu}}</textarea>

                                @error('post_secondary_edu')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="subjects_studied" class="col-4 col-form-label text-right">
                                Subjects studied/major area of concentration (please indicate grades and grade point averages):</label>

                            <div class="col-6">
                                <textarea id="subjects_studied" class="form-control inputstl @error('subjects_studied') is-invalid @enderror"
                                 name="subjects_studied" required autocomplete="subjects_studied" autofocus>{{$data['myuser']->subjects_studied}}</textarea>

                                @error('subjects_studied')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="tutoring_courses" class="col-4 col-form-label text-right">
                                Courses you can tutor for each grade level (list each course, please be as detailed as possible):</label>

                            <div class="col-6">
                                <textarea id="tutoring_courses" class="form-control inputstl @error('tutoring_courses') is-invalid @enderror"
                                 name="tutoring_courses" required autocomplete="tutoring_courses" autofocus>{{$data['myuser']->tutoring_courses}}</textarea>

                                @error('tutoring_courses')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="work_experience" class="col-4 col-form-label text-right">
                                Please provide past job/work experience:</label>

                            <div class="col-6">
                                <textarea id="work_experience" class="form-control inputstl @error('work_experience') is-invalid @enderror"
                                 name="work_experience" required autocomplete="work_experience" autofocus>{{$data['myuser']->work_experience}}</textarea>

                                @error('work_experience')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tutoring_areas" class="col-4 col-form-label text-right">
                                City/suburbs/area you can tutor:</label>

                            <div class="col-6">
                                <textarea id="tutoring_areas" class="form-control inputstl @error('tutoring_areas') is-invalid @enderror"
                                 name="tutoring_areas" required autocomplete="tutoring_areas" autofocus>{{$data['myuser']->tutoring_areas}}</textarea>

                                @error('tutoring_areas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "gender"  class="col-4 col-form-label text-right">Please indicate Male/Female</label>
                            <div class="col-6">
                                <select name="gender" id = "gender" style="display: block;" class="form-control" required>
                                    <option value="Male" <?=$data['myuser']->gender=="Male"?"selected":""?>>Male</option>
                                    <option value="Female" <?=$data['myuser']->gender=="Female"?"selected":""?>>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "certified"  class="col-4 col-form-label text-right">Are you a "certified teacher"?&nbsp; &nbsp;</label>
                            {{-- <div class="col-6"> --}}
                                <label class="radio-inline d-flex align-items-center">
                                    <input type="radio" name="certified" value="Yes"
                                    <?=$data['myuser']->certified_teacher=="Yes"?"checked":""?>>&nbsp;Yes
                                </label>&nbsp;&nbsp;
                                <label class="radio-inline d-flex align-items-center">
                                    <input type="radio" name="certified" value="No"
                                    <?=$data['myuser']->certified_teacher=="No"?"checked":""?>>&nbsp;No
                                </label>
                            {{-- </div> --}}
                        </div>

                        <div class="form-group row">
                            <label for = "cr_radio" class="col-4 col-form-label text-right">
                                Have you ever had a criminal conviction (disregarding minor traffic violations)?&nbsp; &nbsp;
                            </label>
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cr_radio" value="Yes"
                                <?=$data['myuser']->criminal_record=='Yes'?'checked':''?>>&nbsp;Yes
                            </label>&nbsp;&nbsp;
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cr_radio" value="No"
                                <?=$data['myuser']->criminal_record=='No'?'checked':''?>>&nbsp;No
                            </label>
                        </div>

                        <div class="form-group row">
                            <label for = "cc_radio" class="col-4 col-form-label text-right">
                            Would you be willing to provide a background criminal check? &nbsp; &nbsp;</label>
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cc_radio" value="Yes"
                                <?=$data['myuser']->criminal_check=='Yes'?'checked':''?>>&nbsp;Yes
                            </label>&nbsp;&nbsp;
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cc_radio" value="No"
                                <?=$data['myuser']->criminal_check=='No'?'checked':''?>>&nbsp;No
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection