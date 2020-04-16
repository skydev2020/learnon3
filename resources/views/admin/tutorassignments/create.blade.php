@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Create an Assignment</i>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.tutorassignments.store')}}" method="POST">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <div class="col-1 offset-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            <div class="col-1">
                                <a href="{{route('admin.tutorassignments.index')}}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end font-weight-bold">
                                <label for="tutor_val" class="col-form-label text-right">
                                    <span class="required">*</span> Select Tutor:
                                </label>
                            </div>

                            <div class="col-2">
                                <select id = "tutor_val" name = "tutor_val" class="form-control">
                                    <option>-Select-</option>
                                    @foreach ($data['tutors'] as $tutor)
                                    <option value = {{$tutor->id}}>{{$tutor->fname . ' ' . $tutor->lname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end font-weight-bold">
                                <label for="student_val" class="col-form-label text-right">
                                    <span class="required">*</span> Select Student:
                                </label>
                            </div>

                            <div class="col-2">
                                <select id = "student_val" name = "student_val" class="form-control">
                                    <option>-Select-</option>
                                    @foreach ($data['students'] as $student)
                                    <option value = {{$student->id}}>{{$student->fname . ' ' . $student->lname}}  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4 d-flex justify-content-end font-weight-bold" >
                                <label for="tpay_value" class="col-form-label text-right">
                                    <span class="required">*</span> Tutor Pay Rate($):
                                </label>
                            </div>
                            <div class="col-2">
                                <input type="text" name="tpay_value" id="tpay_value" class="form-control">
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class = "col-4 d-flex justify-content-end font-weight-bold">
                                <label for="spay_value" class="col-form-label">
                                    <span class="required">*</span> Student Invoice Rate($) per hour:
                                </label>
                            </div>
                            <div class = "col-2">
                                <input  type = "text" name = "spay_value" id = "spay_value" class="form-control">
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class = "col-4 d-flex align-items-center justify-content-end font-weight-bold">
                                <label for="subjects_box" class="col-form-label">Subjects:</label>
                            </div>
                            <div class="col-3">
                                <div class="scrollbox pl-1 pt-1 overflow-auto" name="subjects_box" id="subjects_box">
                                    @foreach ($data['subjects'] as $subject)
                                    <div>
                                        <input value = "{{$subject->id}}", type = "checkbox" name="subjects[]" id="subjects[]">
                                        {{$subject->name}}
                                    </div>
                                    @endforeach
                                </div>
                                <div>
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', 'checked');"><u>Select All</u></a> /
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', false);"><u>Unselect All</u></a>
                                </div>
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class = "col-4 d-flex justify-content-end font-weight-bold">
                                <label for="status" class="col-form-label">Status:</label>
                            </div>
                            <div class="col-2">
                                <select id = "status" name = "status" class="form-control">
                                    <option value="1"> Enabled </option>
                                    <option value="0"> Disabled </option>
                                </select>
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class = "col-4 d-flex align-items-center justify-content-end font-weight-bold">
                                <label class="col-form-label">Status By Tutor:</label>
                            </div>
                            <div class="col-2 d-flex align-items-center"></div>
                        </div>

                        <div class = "form-group row">
                            <div class = "col-4 d-flex align-items-center justify-content-end font-weight-bold">
                                <label class="col-form-label">Status By Student:</label>
                            </div>
                            <div class="col-2 d-flex align-items-center"></div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
