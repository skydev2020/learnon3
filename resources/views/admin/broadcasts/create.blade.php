@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px;"> Email Templates</i>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.broadcasts.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="title" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Title:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="title" type="text" class="form-control" name="title"
                                autocomplete="title" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="subject" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Subject:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input id="subject" type="text" class="form-control" name="subject"
                                autocomplete="subject" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="mail_template" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Template:') }}</label>
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                <textarea id="mail_template" class="form-control inputstl"
                                 name="mail_template" required autocomplete="mail_template" autofocus>
                                </textarea>
                            </div>
                        </div>



                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="status" class="col-form-label font-weight-bold">{{ __('Status:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select name = "status" id = "status" class = "form-control" >
                                <option value="1" >Enabled</option>
                                <option value="0" >Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-6 offset-md-4">
                                <button type = "submit" class="btn btn-primary">
                                    {{ __('Save') }}
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
<!-- Scripts -->
@section("jssection")
<script type="text/javascript">
    window.addEventListener('load', function() {
        CKEDITOR.replace('mail_template', {
            uiColor:    '#CCEAEE',
            width:      '100%'
        });
    });
</script>
@stop
