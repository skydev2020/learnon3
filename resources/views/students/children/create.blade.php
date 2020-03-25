@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header">Add another student to account</div>
                <div class="card-body">
                    <form action="{{route('student.children.store')}}" method="POST">
                        @csrf
                        {{method_field('POST')}}
                        <div class="form-group row">
                            <label for="email" class="col-4 col-form-label text-right">E-mail:</label>

                            <div class="col-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                 name="email" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-4 col-form-label text-right">Tutoring Status:</label>

                            <div class="col-6">
                                <select id = "status" name = "status" class = "form-control">
                                    @foreach ($statuses as $status)
                                        <option value = "{{$status->id}}">{{$status->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname" class="col-4 col-form-label text-right">Student First Name:</label>

                            <div class="col-6">
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
                            <label for="lname" class="col-4 col-form-label text-right">Student Last Name:</label>

                            <div class="col-6">
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
                            <label for="grade_id" class="col-4 col-form-label text-right">Current Grade/Year:</label>

                            <div class="col-6">
                                <select name="grade_id" id="grade_id" onchange="getSubjects(this.value);">
                                    @foreach($grades as $grade)
                                    <option value = {{$grade->id}} > {{ $grade->name }}</option>
                                    @endforeach
                                </select>

                                @error('grade_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-4 col-form-label text-right">Subjects:</label>

                            <div class="col-6 d-flex flex-column">
                                <div class="scrollbox pl-1 pt-1" id="subjects_box" name = "subjects_box">
                                    
                                </div>
                                <div>
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', 'checked');"><u>Select All</u></a> /
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', false);"><u>Unselect All</u></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parent_fname" class="col-4 col-form-label text-right">Parent First Name:</label>

                            <div class="col-6">
                                <input id="parent_fname" type="text" class="form-control @error('parent_fname') is-invalid @enderror"
                                 name="parent_fname" required autofocus>

                                @error('parent_fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parent_lname" class="col-4 col-form-label text-right">Parent Last Name:</label>

                            <div class="col-6">
                                <input id="parent_lname" type="text" class="form-control @error('parent_lname') is-invalid @enderror"
                                 name="parent_lname" required autofocus>

                                @error('parent_lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="home_phone" class="col-4 col-form-label text-right">Telephone:</label>

                            <div class="col-6">
                                <input id="home_phone" type="text" class="form-control @error('home_phone') is-invalid @enderror"
                                 name="home_phone" required autofocus>

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
                                 name="cell_phone" required autofocus>

                                @error('cell_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-4 col-form-label text-right">Address:</label>

                            <div class="col-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                 name="address" required autocomplete="address" autofocus>

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
                                 name="city" required autocomplete="city" autofocus>

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
                                    <option>--Select A Province--</option>
                                    @foreach($states as $state)
                                        <option value = {{$state->id}} >
                                             {{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pcode" class="col-4 col-form-label text-right">Postal/Zip Code:</label>

                            <div class="col-6">
                                <input id="pcode" type="text" class="form-control @error('pcode') is-invalid @enderror"
                                 name="pcode" required autocomplete="pcode" autofocus>

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
                                    <option>--Select Country--</option>
                                    @foreach($countries as $country)
                                    <option value = {{$country->id}} >{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="other_notes" class="col-4 col-form-label text-right">Notes:</label>

                            <div class="col-6">
                                <textarea id="other_notes" class="form-control inputstl @error('other_notes') is-invalid @enderror"
                                 name="other_notes" required autocomplete="other_notes" autofocus></textarea>

                                @error('other_notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="major_intersection" class="col-4 col-form-label text-right">
                                Major Street intersection:</label>

                            <div class="col-6">
                                <input type = "text" id="major_intersection" class="form-control"
                                 name="major_intersection" required autocomplete="major_intersection" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="school" class="col-4 col-form-label text-right">School Name:</label>

                            <div class="col-6">
                                <input id="school" class="form-control @error('school') is-invalid @enderror" type = "text"
                                 name="school" required autocomplete="school" autofocus>

                                @error('school')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class = "form-group row">
                            <div class = "col-1 offset-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            <div class = "col-6">
                                <a href = "{{route('student.children.index')}}">
                                    <button type = "button" class = "btn btn-primary">Cancel</button>
                                </a>
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
