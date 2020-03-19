@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Upload CSV - Income and Expense</div>
                <div class="card-body">
                <form method="post" action="{{ route('admin.csvupload.store') }}" enctype = "multipart/form-data">
                        @csrf
                        {{method_field('POST')}}

                        <div class = "form-group row">
                            <div class = "col-1 offset-10 d-flex">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>

                            <div class = "col-1 d-flex">
                                <a href = "{{ route('admin.defaultwages.index') }}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="income_file" class="col-form-label font-weight-bold">Income CSV File:</label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <input type = "file" id = "income_file" name = "income_file"
                                    class = "form-control-file">
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="expense_file" class="col-form-label font-weight-bold">Expense CSV File:</label>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <input type = "file" id = "expense_file" name = "expense_file"
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