@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style = "text-align:center;">{{ __('Edit An Assignment') }}</div>
                <div class="card-body">
                    <form action="{{route('admin.assignments.update', $assignment)}}" method="POST">

                        <div class="form-group row">
                            <label for="tutor_val" class="col-md-4 col-form-label text-md-right">{{ __('Select Tutor') }}</label>

                            <div class="col-md-5">
                                <select id = "tutor_val" name = "tutor_val">
                                    @foreach ($tutors as $tutor)
                                        <option value = {{$tutor->id}} <?=$tutor->id == $assignment->tutor_id ? ' selected="selected"' : '';?> >
                                         {{$tutor->fname . ' ' . $tutor->lname}}  </option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="student_val" class="col-md-4 col-form-label text-md-right">{{ __('Select Student') }}</label>

                            <div class="col-md-5">
                                <select id = "student_val" name = "student_val">
                                    @foreach ($students as $student)
                                    <option value = {{$student->id}} <?=$student->id == $assignment->student_id ? ' selected="selected"' : '';?> >
                                         {{$student->fname . ' ' . $student->lname}}  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}

                        <div class="row">
                            <div class="col-md-10" style = "display:flex;">
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <b>Tutor Pay Rate($) per hour</b>
                                        <?php
                                        use App\Rate;
                                        $rates = Rate::all(); ?>
                                        <input type="text"    name="tpay_value" id="tpay_value" value={{$rates->first()['basic_tutor']}}>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <b>From (Hr)</b>
                                        <input type="text" readonly value="1" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <b>To (Hr)</b>
                                        <input type="text" readonly value="5" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10" style = "display:flex;">
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <input type="text" readonly  value="21" />
                                    </div>  
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <input type="text" readonly value="6" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <input type="text" readonly value="15" />
                                    </div>
                                </div>
                            </div>
                        </div>   


                        <div class="row">
                            <div class="col-md-10" style = "display:flex;">
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <input type="text" readonly  value="23" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <input type="text" readonly value="16" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <input type="text" readonly value="21" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10" style = "display:flex;">
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <input type="text"  readonly value="25" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <input type="text"  value="21" />
                                    </div>
                                </div>

                                    <div class="col-md-3">
                                    <div class="form-group ">
                                        <input type="text" readonly value="50" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class = "form-group row col-md-10">
                            <div class = "col-md-6" style = "text-align:center;">
                                <b> Student Invoice Rate($) per hour </b>
                            </div>
                            <div class = "col-md-4" style = "text-align:center;">
                                
                                <input  type = "text" name = "spay_value" id = "spay_value" value = {{$rates->first()['basic_student']}}>
                            </div>
                        </div>
                        <div style = "display:flex;">
                            <div class = "form-group row col-md-4">
                                <b>    Subject(s) Assigned     </b>
                                <textarea name = "subject_value" id="subject_value"> {{ $assignment->subjects }} </textarea>
                            </div>

                            <div class = "form-group">
                                <b>    Status     </b>
                                <select id = "status" name = "status" style = "display:inline;">
                                    <option> Enabled </option>
                                    <option> Disabled </option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </form>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
