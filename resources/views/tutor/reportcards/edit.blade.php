@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Update Report Card</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tutor.reportcards.update', $data['report']) }}">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group row mb-0">
                            <div class = "col-1 offset-10">
                                <button type = "submit" class = "btn btn-primary">Send</button>
                            </div>
                            <div class = "col-1">
                                <a href = "{{ route('tutor.reportcards.index') }}">
                                    <button type = "button" class = "btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "sname" class="col-form-label">{{ __('Student Name:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <select name = "sname" id = "sname">
                                    @foreach ($data['students'] as $student)
                                        <option <?= $student->id==$data['report']->student_id ? "selected":"" ?>
                                        value = "{{$student->id}}">{{$student->fullname()}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('Grade:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{ $data['report']->grades()->first()['name'] }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">{{ __('Subjects:') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                {{ $data['report']->subjects }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "student_prepared" class="col-form-label">
                                {{ __('Is the Student Prepared For Sessions?') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <label class="radio-inline d-flex align-items-center">
                                    <input type="radio" name="student_prepared" value="1"
                                    <?= $data['report']->student_prepared == 1? "checked" : ""; ?> >&nbsp;Yes
                                </label>&nbsp;&nbsp;
                                <label class="radio-inline d-flex align-items-center">
                                    <input type="radio" name="student_prepared" value="0"
                                    <?= $data['report']->student_prepared == 0 ? "checked" : ""; ?> >&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "questions_ready" class="col-form-label">
                                {{ __('Does the student have questions ready?') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <label class="radio-inline d-flex align-items-center">
                                    <input type="radio" name="questions_ready" value="1"
                                    <?= $data['report']->questions_ready == 1? "checked" : ""; ?> >&nbsp;Yes
                                </label>&nbsp;&nbsp;
                                <label class="radio-inline d-flex align-items-center">
                                    <input type="radio" name="questions_ready" value="0"
                                    <?= $data['report']->questions_ready == 0 ? "checked" : ""; ?> >&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "pay_attention" class="col-form-label">
                                {{ __('Does the Student Pay Attention?') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <label class="radio-inline d-flex align-items-center">
                                    <input type="radio" name="pay_attention" value="1"
                                    <?= $data['report']->pay_attention == 1? "checked" : ""; ?> >&nbsp;Yes
                                </label>&nbsp;&nbsp;
                                <label class="radio-inline d-flex align-items-center">
                                    <input type="radio" name="pay_attention" value="0"
                                    <?= $data['report']->pay_attention == 0 ? "checked" : ""; ?> >&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "weaknesses" class="col-form-label">
                                {{ __("What are student's main weaknesses?") }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <textarea id = "weaknesses" name = "weaknesses" 
                                class = "form-control inputstl">{{ $data['report']->weaknesses }} </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "listen_to_suggestions" class="col-form-label">
                                {{ __('Does the student listen to suggestions given?') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <label class="radio-inline d-flex align-items-center">
                                    <input type="radio" name="listen_to_suggestions" value="1"
                                    <?= $data['report']->listen_to_suggestions == 1? "checked" : ""; ?> >&nbsp;Yes
                                </label>&nbsp;&nbsp;
                                <label class="radio-inline d-flex align-items-center">
                                    <input type="radio" name="listen_to_suggestions" value="0"
                                    <?= $data['report']->listen_to_suggestions == 0 ? "checked" : ""; ?> >&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div for="improvements" class="col-3 d-flex justify-content-end align-items-center">
                                <label class="col-form-label">
                                {{ __('What improvements have you seen?') }}</label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <textarea id = "improvements" name = "improvements" 
                                class = "form-control inputstl">{{ $data['report']->improvements }} </textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for = "other_comments" class="col-form-label">
                                {{ __('Any other comment about the sessions & student?') }} </br>
                                <em>(Observations General Notes on Progress, suggestions etc.)</em>
                                </label>
                            </div>
                            <div class="col-6 d-flex align-items-center font-weight-bold">
                                <textarea id = "other_comments" name = "other_comments" 
                                class = "form-control inputstl">{{ $data['report']->other_comments }} </textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection