@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style = "text-align:center;">{{ __('Update Assignment') }}</div>
                <div class="card-body">
                    <form action="{{route('admin.tutorassignments.update', $data['assignment'])}}" method="POST">

                        <div class="form-group row">
                            <label for="tutor_val" class="col-md-4 col-form-label text-md-right">{{ __('Select Tutor: ') }}</label>

                            <div class="col-md-5">
                                <select id = "tutor_val" name = "tutor_val">
                                    @foreach ($data['tutors'] as $tutor)
                                        <option value = {{$tutor->id}} <?=$tutor->id == $data['assignment']->tutor_id ? ' selected="selected"' : '';?> >
                                         {{$tutor->fname . ' ' . $tutor->lname}}  </option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="student_val" class="col-md-4 col-form-label text-md-right">{{ __('Select Student:') }}</label>

                            <div class="col-md-5">
                                <select id = "student_val" name = "student_val">
                                    @foreach ($data['students'] as $student)
                                    <option value = {{$student->id}} <?=$student->id == $data['assignment']->student_id ? ' selected="selected"' : '';?> >
                                         {{$student->fname . ' ' . $student->lname}}  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}

                        <div class="row">
                            <div class="col-md-10" style = "display:flex;">
                                <div class="col-md-6 text-md-right" >
                                    <b>Tutor Pay Rate($):</b>
                                </div>
                                <div>
                                    <input type="text" name="tpay_value" id="tpay_value" value={{$data['rates']->first()['basic_tutor']}}>
                                </div>
                            </div>
                        </div>

                        <div class = "form-group row col-md-10">
                            <div class = "col-md-6 text-md-right">
                                <b> Student Invoice Rate($) per hour:</b>
                            </div>
                            <div class = "col-md-4">
                                
                                <input  type = "text" name = "spay_value" id = "spay_value" value = {{$data['rates']->first()['basic_student']}}>
                            </div>
                        </div>
                        <div style = "display:flex;">
                            <div class = "form-group row col-md-4">
                                <b>    Subject(s) Assigned     </b>
                                <textarea name = "subject_value" id="subject_value"> {{ $data['assignment']->subjects }} </textarea>
                            </div>
                            <div style = "display:block;">
                                <div class = "form-group">
                                    <b>    Status     </b>
                                    <select id = "status" name = "status" style = "display:inline;">
                                        <option> Enabled </option>
                                        <option> Disabled </option>
                                    </select>
                                </div>

                                <div class = "form-group">
                                    <b>    Status By Tutor:     </b>
                                    {{ $data['assignment']->status_by_tutor }}
                                </div>

                                <div class = "form-group">
                                    <b>    Status By Student:    </b>
                                    {{ $data['assignment']->status_by_student }}
                                </div>
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
