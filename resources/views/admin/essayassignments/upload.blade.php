@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Homework Assignments</div>
                <div class="card-body">
                <form method="post" action="{{ route('admin.essayassignments.upload_csv') }}" enctype = "multipart/form-data">
                        @csrf
                        {{method_field('POST')}}

                        <div class = "form-group row">
                            <div class = "col-1 offset-10 d-flex">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                            <div class = "col-1 d-flex">
                                <a href = "{{ route('admin.essayassignments.index') }}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="file1" class="col-form-label font-weight-bold">Upload Assignment File In CSV Format:</label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <input type = "file" id = "file1" name = "file1" class = "form-control-file">
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="file2" class="col-form-label font-weight-bold">Upload Assignment File In CSV Format:</label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <input type = "file" id = "file2" name = "file2" class = "form-control-file">
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="file3" class="col-form-label font-weight-bold">Upload Assignment File In CSV Format:</label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <input type = "file" id = "file3" name = "file3" class = "form-control-file">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection