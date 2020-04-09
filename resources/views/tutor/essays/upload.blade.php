@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px;"> Homework Assignments</i>
                </div>
                <div class="card-body">
                <form method="post" action="{{ route('tutor.essays.upload', $essay) }}" enctype = "multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}

                        <div class = "form-group row">
                            <div class = "col-1 offset-10 d-flex">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                            <div class = "col-1 d-flex">
                                <a href = "{{ route('tutor.essays.index') }}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="income_file" class="col-form-label font-weight-bold">Assignment #</label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                {{$essay->assignment_num}}
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="attachment1" class="col-form-label font-weight-bold">Attachment 1:</label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <input type = "file" id = "attachment[]" name = "attachment[]"
                                    class = "form-control-file">
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="attachment2" class="col-form-label font-weight-bold">Attachment 2:</label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <input type = "file" id = "attachment[]" name = "attachment[]"
                                    class = "form-control-file">
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="attachment3" class="col-form-label font-weight-bold">Attachment 3:</label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <input type = "file" id = "attachment[]" name = "attachment[]"
                                    class = "form-control-file">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection