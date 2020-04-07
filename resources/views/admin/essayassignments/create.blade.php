@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header information font-weight-bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Homework Assignments</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.essayassignments.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <label for="assignment_num" class="col-md-4 col-form-label text-md-right">{{ __('Assignment #') }}</label>

                            <div class="col-md-6">
                            <input type="text" name="assignment_num" id="assignment_num" value = {{$data['a_num']}} />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tutor_id" class="col-md-4 col-form-label text-md-right">{{ __('Tutor Name;') }}</label>

                            <div class="col-md-6">
                                <select id = "tutor_id" name = "tutor_id">
                                    @foreach ($data['tutors'] as $tutor)
                                        <option value = {{$tutor->id}}> {{$tutor->fname . ' ' . $tutor->lname}}  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="student_id" class="col-md-4 col-form-label text-md-right">{{ __('Student Name:') }}</label>

                            <div class="col-md-6">
                                <select id = "student_id" name = "student_id">
                                    @foreach ($data['students'] as $student)
                                        <option value = {{$student->id}}> {{$student->fname .  ' ' . $student->lname}}  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="topic" class="col-md-4 col-form-label text-md-right">{{ __('Topic:') }}</label>

                            <div class="col-md-6">
                                <input type = "text" id = "topic" name = "topic" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description:') }}</label>

                            <div class="col-md-6">
                                <textarea id = "description" name = "description"> </textarea>
                            </div>
                        </div>   


                        <div class="form-group row">
                            <label for="file_format" class="col-md-4 col-form-label text-md-right">{{ __('File Format:') }}</label>

                            <div class="col-md-6">
                                <select id = "file_format" name = "file_format">
                                <option value="">Select One</option>
                                <option value="Online Submission">Online Submission</option>
                                <option value=".docx">.docx</option>
                                <option value=".doc">.doc</option>
                                <option value=".txt">.txt</option>
                                <option value=".xlsx">.xslx</option>
                                <option value=".xls">.xls</option>
                                <option value=".pdf">.pdf</option> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price_owed" class="col-md-4 col-form-label text-md-right">{{ __('Price Paid:') }}</label>

                            <div class="col-md-6">
                                <input type = "text" id = "price_owed" name = "price_owed"> </input>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="paid_to_tutor" class="col-md-4 col-form-label text-md-right">{{ __('Pay to Tutor:') }}</label>

                            <div class="col-md-6">
                                <input type = "text" id = "paid_to_tutor" name = "paid_to_tutor"> </input>
                            </div>
                        </div> 
                        
                        <div class="form-group row">
                            <label for="date_assigned" class="col-md-4 col-form-label text-md-right">{{ __('Date Assigned:') }}</label>

                            <div class="col-md-6">
                                <input type = "date" id = "date_assigned" name = "date_assigned"> </input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_completed" class="col-md-4 col-form-label text-md-right">{{ __('Date Completed:') }}</label>

                            <div class="col-md-6">
                                <input type = "date" id = "date_completed" name = "date_completed"> </input>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="date_due" class="col-md-4 col-form-label text-md-right">{{ __('Due Date:') }}</label>

                            <div class="col-md-6">
                                <input type = "date" id = "date_due" name = "date_due"> </input>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="status_id" class="col-md-4 col-form-label text-md-right">{{ __('Status:') }}</label>

                            <div class="col-md-6">
                                <select name = "status_id" id = "status_id">
                                    @foreach ($data['statuses'] as $status)
                                        <option value = {{$status->id}}> {{$status->name}} </option>
                                    @endforeach
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
