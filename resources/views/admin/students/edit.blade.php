@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Students</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.students.update', $state) }}">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group row">
                            <div class="col-2 offset-11">
                                <a href = "{{route('admin.students.index')}}">
                                    <button class = "btn btn-primary" type = "button">Cancel</button>
                                </a>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for = "fname" class="col-3 col-form-label text-md-right">First Name</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input type = "text" id = "fname" name = "fname" class = "form-control"
                                    value = "{{$student->fname}}" autocomplete= "fname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "lname" class="col-3 col-form-label text-md-right">Last Name</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input type = "text" id = "lname" name = "lname" class = "form-control"
                                    value = "{{$student->lname}}" autocomplete= "lname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "email" class="col-3 col-form-label text-md-right">E-Mail:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input type = "email" id = "email" name = "email" class = "form-control"
                                    value = "{{$student->email}}" autocomplete= "email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "password" class="col-3 col-form-label text-md-right">Password:</label>
                            <div class="col-6 col-form-label font-weight-bold">
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
                            <label for="password-confirm" class="col-3 col-form-label text-md-right">Confirm:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                <label class="col-form-label font-weight-bold">Subjects:</label>
                            </div>

                            <div class="col-6 d-flex flex-column">
                                <div class="scrollbox pl-1 pt-1" id="subjects_box" name = "subjects_box">
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
                            <label for = "parent_fname" class="col-3 col-form-label text-md-right">Parent First Name:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input type = "text" id = "parent_fname" name = "parent_fname" class = "form-control"
                                    value = "{{$student->parent_fname}}" autocomplete= "parent_fname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "parent_lname" class="col-3 col-form-label text-md-right">Parent Last Name:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input type = "text" id = "parent_lname" name = "parent_lname" class = "form-control"
                                    value = "{{$student->parent_lname}}" autocomplete= "parent_lname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "home_phone" class="col-3 col-form-label text-md-right">Telephone:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input type = "text" id = "home_phone" name = "home_phone" class = "form-control"
                                    value = "{{$student->home_phone}}" autocomplete= "home_phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "cell_phone" class="col-3 col-form-label text-md-right">Cell/Work Phone:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input type = "text" id = "cell_phone" name = "cell_phone" class = "form-control"
                                    value = "{{$student->cell_phone}}" autocomplete= "cell_phone" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "address" class="col-3 col-form-label text-md-right">Address:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input type = "text" id = "address" name = "address" class = "form-control"
                                    value = "{{$student->address}}" autocomplete= "address" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "city" class="col-3 col-form-label text-md-right">City:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input type = "text" id = "city" name = "city" class = "form-control"
                                    value = "{{$student->city}}" autocomplete= "city" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "state_id" class="col-3 col-form-label text-md-right">Region / State:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <select id = "state_id" name = "state_id">
                                    @foreach ($states as $state)
                                    <option <?= $state->id == $student->state_id ? "selected" : "" ?>
                                        value = "{{$state->id}}">$state->name</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "pcode" class="col-3 col-form-label text-md-right">Postcode:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <input type = "text" id = "pcode" name = "pcode" class = "form-control"
                                value = "{{$student->pcode}}" autocomplete= "pcode" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "country_id" class="col-3 col-form-label text-md-right">Country:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <select id = "country_id" name = "country_id">
                                    @foreach ($countries as $country)
                                    <option <?= $country->id == $student->country_id ? "selected" : "" ?>
                                        value = "{{$state->id}}">$country->name</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "service_method" class="col-3 col-form-label text-md-right">Service Method:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                                <select id = "service_method" name = "service_method">
                                    <option <?= $student->service_method == "Online" ? "selected" : "" ?>
                                        value = "Online">Online Video Tutoring</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 col-form-label text-md-right">Notes:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                            {{ $data['student']->other_notes }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 col-form-label text-md-right">Major Street intersection:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                            {{ $data['student']->major_intersection }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 col-form-label text-md-right">School name:</label>
                            <div class="col-6 col-form-label font-weight-bold">
                            {{ $data['student']->school }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 d-flex justify-content-end align-items-center">How you heard about us:</label>
                            <div class="col-6 d-flex align-items-center font-weight-bold ">
                                <select>
                                    @foreach ($data['referrers'] as $referrer)
                                    <option <?= $referrer->id == $data['student']->referrer_id ? "selected" : ""?>>
                                        {{$referrer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 d-flex justify-content-end align-items-center">Tutoring Status:</label>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <select>
                                    @foreach ($data['student_statuses'] as $status)
                                    <option <?= $status->id == $data['student']->student_status_id ? "selected" : ""?>>
                                        {{$status->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 d-flex justify-content-end align-items-center">Approved:</label>
                            <div class="col-6 d-flex align-items-center font-weight-bold ">
                                <select>
                                    <option>Enabled</option>
                                    <option <?= $data['student']->approved != 1 ? "selected" : "" ?>>Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 d-flex justify-content-end align-items-center">Status:</label>
                            <div class="col-6 d-flex align-items-center font-weight-bold ">
                                <select>
                                    <option>Enabled</option>
                                    <option <?= $data['student']->status_id != 1 ? "selected" : "" ?>>Disabled</option>
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