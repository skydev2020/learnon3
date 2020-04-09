@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Update Tutor Details</i>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.rejectedtutors.update', $tutor)}}" method="POST">
                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="email" class="col-form-label font-weight-bold">Username</label>
                            </div>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                 name="email" value="{{$tutor->email }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="fname" class="col-form-label font-weight-bold">First Name</label>
                            </div>

                            <div class="col-md-6">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror"
                                 name="fname" value="{{ $tutor->fname }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="lname" class="col-form-label font-weight-bold">Last Name</label>
                            </div>

                            <div class="col-md-6">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror"
                                 name="lname" value="{{ $tutor->lname }}" required autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="home_phone" class="col-form-label font-weight-bold">Home Phone:</label>
                            </div>

                            <div class="col-md-6">
                                <input id="home_phone" type="text" class="form-control"
                                 name="home_phone" value="{{ $tutor->home_phone }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="cell_phone" class="col-form-label font-weight-bold">Cell/Work Phone:</label>
                            </div>

                            <div class="col-md-6">
                                <input id="cell_phone" type="text" class="form-control"
                                 name="cell_phone" value="{{ $tutor->cell_phone }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="password" class="col-form-label font-weight-bold">{{ __('Password') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="password-confirm" class="col-form-label font-weight-bold">{{ __('Confirm') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <input id="password-confirm" type="password" 
                                class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="address" class="col-form-label font-weight-bold">
                                {{ __('Home Address:') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="address" type="text" class="form-control"
                                 name="address" value="{{ $tutor->address }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="city" class="col-form-label font-weight-bold">{{ __('City') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                                 name="city" value="{{ $tutor->city }}" required autocomplete="city" autofocus>

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="state_id" class="col-form-label font-weight-bold">{{ __('Province / State') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <select name="state_id" id="state_id">
                                    <?php use App\State;
                                    $states = State::all();
                                    ?>
                                    @foreach($states as $state)
                                        <option value = {{$state->id}} 
                                        <?=$state->id == $tutor->state_id ? "selected" : ""?>>
                                        {{ $state->name }}</option>
                                    @endforeach

                                </select>

                                @error('state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="pcode" class="col-form-label font-weight-bold">{{ __('Pcode') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <input id="pcode" type="text" class="form-control @error('pcode') is-invalid @enderror"
                                 name="pcode" value="{{ $tutor->pcode }}" required autocomplete="pcode" autofocus>

                                @error('pcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end">
                                <label for="country_id" class="col-form-label font-weight-bold">{{ __('Country') }}</label>
                            </div>

                            <div class="col-6 d-flex align-items-center">
                                <select name="country_id" id="country_id">
                                    <?php use App\Country;
                                    $countries = Country::all();
                                    ?>
                                    @foreach($countries as $country)
                                        <option value = {{$country->id}} 
                                        <?=$country->id == $tutor->country_id ? "selected" : ""?>>
                                        {{ $country->name }}</option>
                                    @endforeach

                                </select>

                                @error('country_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <h4 style="text-align: center">{{ __('Other Details') }}</h4>

                        <div class="form-group row col-12">
                            <label for = "other_notes" class="font-weight-bold">{{ __('Other Notes') }}</label>
                            <textarea class="form-control inputstl" id = "other_notes" name = "other_notes"
                            required autocomplete="other_notes" autofocus>{{$tutor->other_notes}}</textarea>
                        </div>


                        <div class="form-group row col-12">
                            <label for = "post_secondary_edu" class="font-weight-bold">{{ __('Post Secondary Education attending/attended') }}</label>
                            <textarea class="form-control inputstl" id = "post_secondary_edu" name = "post_secondary_edu" 
                            required autocomplete="post_secondary_edu" autofocus>{{$tutor->post_secondary_edu}}
                            </textarea>
                        </div>

                        <div class="form-group row col-12">
                            <label for = "area_of_concentration" class="font-weight-bold">
                            {{ __('Subjects studied/major area of concentration (please indicate grades and grade point averages)') }}
                            </label>
                            <textarea class="form-control inputstl" id = "area_of_concentration" name = "area_of_concentration"
                            required autocomplete="area_of_concentration" autofocus>{{$tutor->area_of_concentration}}</textarea>
                        </div>

                        <div class="form-group row col-12">
                            <label for = "tutoring_courses" class="font-weight-bold">
                            {{ __('Courses you can tutor for each grade level (list each course, please be as detailed as possible)') }}
                            </label>
                            <textarea class="form-control inputstl" id = "tutoring_courses" name = "tutoring_courses"
                            required autocomplete="tutoring_courses" autofocus> {{ $tutor->tutoring_courses }} </textarea>
                        </div>

                        <div class="form-group row col-12">
                            <label for = "work_experience" class="font-weight-bold">{{ __('Please provide past job/work experience(N/A for none)') }}</label>
                            <textarea class="form-control inputstl" id = "work_experience" name = "work_experience"
                            required autocomplete="work_experience" autofocus>{{$tutor->work_experience}}</textarea>
                        </div>

                        <div class="form-group row col-12">
                            <label for = "tutoring_areas" class="font-weight-bold">{{ __('City/suburbs/area you can tutor') }}</label>
                            <textarea class="form-control inputstl" id = "tutoring_areas" name = "tutoring_areas"
                            required autocomplete="tutoring_areas" autofocus>{{$tutor->tutoring_areas}}</textarea>
                        </div>

                        <div class="form-group col-md-4 row">
                            <label for = "sex_val" class="font-weight-bold">Please indicate Male/Female</label>
                            <select name="sex_val" style="display: block;" class="form-control" required>
                                <option value="Male" <?= $tutor -> gender == "Male" ? "selected" : "" ?> >
                                Male</option>
                                <option value="Female" <?= $tutor -> gender == "Female" ? "selected" : "" ?> >Female</option>
                            </select>
                        </div>

                        <div class="form-group col-12 row">
                            <label class="font-weight-bold">Are you a certified teacher?&nbsp; &nbsp;</label>
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="certified" value="Yes"
                                <?= $tutor -> certified_teacher == "Yes" ? "checked" : ""; ?> >&nbsp;Yes
                            </label>&nbsp;&nbsp;
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="certified" value="No"
                                <?= $tutor -> certified_teacher != "Yes" ? "checked" : ""; ?> >&nbsp;No
                            </label>
                        </div>

                        <div class="form-group col-12 row">
                            <label class="font-weight-bold">Have you ever had a criminal conviction (disregarding minor traffic violations)?&nbsp; &nbsp; </label>
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cr_radio" value="Yes" checked >&nbsp;Yes
                            </label>&nbsp;&nbsp;
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cr_radio" value="No"
                                <?= $tutor -> criminal_record == "Yes" ? "" : "checked" ?> >&nbsp;No
                            </label>
                        </div>

                        <div class="form-group col-12 row">
                            <label class="font-weight-bold" >Would you be willing to provide a background criminal check? &nbsp; &nbsp;</label>
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cc_radio" value="Yes"
                                <?= $tutor -> criminal_check == "Yes" ? "checked" : "" ?> >&nbsp;Yes
                            </label>&nbsp;&nbsp;
                            <label class="radio-inline d-flex align-items-center">
                                <input type="radio" name="cc_radio" value="No"
                                <?= $tutor -> criminal_check == "Yes" ? "" : "checked" ?> >&nbsp;No
                            </label>
                        </div>

                        <div class="form-group col-12 row">
                            <div class="d-flex justify-content-end">
                                <label for = "approved" class="col-form-label font-weight-bold">{{ __('Approved') }}</label>
                            </div>

                            <div class="col-4 d-flex align-items-center">
                                <select name="approved" style="display: block;" class="form-control" 
                                required id = "approved">
                                    <option value="1" <?= $tutor -> approved == "1" ? "selected" : "" ?> >Enabled</option>
                                    <option value="0" <?= $tutor -> gender == "0" ? "selected" : "" ?> >Disabled</option>
                                </select>    
                            </div>
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
