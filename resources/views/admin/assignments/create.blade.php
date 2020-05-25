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
                    <form action="{{route('admin.assignments.store')}}" method="POST">
                        @csrf
                        {{method_field('POST')}}
                        <div class="form-group row">
                            <div class = "offset-3 col-8 col-md-6 text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                                &nbsp;&nbsp;
                                <a href = "{{route('admin.assignments.index')}}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "student_val" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Select Student:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select name="student_val" id="student_val" class="form-control">
                                    <option>-Select-</option>
                                    @foreach ($data['students'] as $student)
                                    <option value = "{{$student->id}}">{{ $student->fname . ' ' . $student->lname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "tutor_val" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Select Tutor:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select name="tutor_val" id="tutor_val" class="form-control">
                                    <option>-Select-</option>
                                    @foreach ($data['tutors'] as $tutor)
                                    <option value = "{{$tutor->id}}">{{ $tutor->fname . ' ' . $tutor->lname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "base_invoice" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Student invoice rate($):
                                </label>
                            </div>
                            <div class="col-8 col-md-6 d-flex">
                                <input type = "text" id = "base_invoice" name = "base_invoice" class = "col-8 form-control"
                                    autocomplete= "base_invoice" autofocus/>
                                <label for = "base_invoice" class="col-form-label">&nbsp; per hour</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "base_wage" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Tutor pay rate($):
                                </label>
                            </div>
                            <div class="col-8 col-md-6 d-flex">
                                <input type = "text" id = "base_wage" name = "base_wage" class = "col-8 form-control"
                                autocomplete= "base_wage" autofocus/>
                                <label for = "base_wage" class="col-form-label">&nbsp; per hour</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "subjects_box" class="col-form-label font-weight-bold">Subject(s) Assigned:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <div class="scrollbox pl-1 pt-1 overflow-auto" id="subjects_box" name = "subjects_box">
                                    @foreach ($data['subjects'] as $subject)
                                    <div>
                                        <input type = "checkbox" value = " {{ $subject -> id }} " name = "subjects[]"
                                        > {{$subject->name}}
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
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "active" class="col-form-label font-weight-bold">Status:</label>
                            </div>
                            <div class="col-8 col-md-6">
                                <select name="active" id="active" class="form-control">
                                    <option value = "1">Enabled</option>
                                    <option value = "0">Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label font-weight-bold">Status By Tutor:</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label font-weight-bold">Status By Student:</label>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
