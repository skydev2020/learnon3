@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style = "text-align:center;">{{ __('Create An Assignment') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.assignments.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <label for="tutor_val" class="col-md-4 col-form-label text-md-right">{{ __('Select Tutor') }}</label>

                            <div class="col-md-5">
                                <select id = "tutor_val" name = "tutor_val">
                                    @foreach ($tutors as $tutor)
                                        <option value = {{$tutor->id}}> {{$tutor->fname . ' ' . $tutor->lname}}  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="student_val" class="col-md-4 col-form-label text-md-right">{{ __('Select Student') }}</label>

                            <div class="col-md-5">
                                <select id = "student_val" name = "student_val">
                                    @foreach ($students as $student)
                                        <option value = {{$student->id}}> {{$student->fname .  ' ' . $student->lname}}  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10" style = "display:flex;">
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <b>Tutor Pay Rate($) per hour</b>
                                        <input type="text"    name="tpay_value" id="tpay_value" value="20">
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
                                <input  type = "text" name = "spay_value" id = "spay_value" vlue = "42">
                            </div>
                        </div>
                        <div style = "display:flex;">
                            <div class = "form-group row col-md-4">
                                <b>    Subject(s) Assigned     </b>
                                <textarea name = "subject_value" id="subject_value"></textarea>
                            </div>

                            <div class = "form-group">
                                <b>    Status     </b>
                                <select id = "status" name = "status" style = "display:inline;">
                                    <option> Enabled </option>
                                    <option> Disabled </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('SAVE') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
