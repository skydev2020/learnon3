@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Information</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.informations.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="title" class="col-form-label font-weight-bold">{{ __('Information Title:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="title" type="text" class="form-control" name="title"
                                autocomplete="title" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="description" class="col-form-label font-weight-bold">{{ __('Description:') }}</label>
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                <textarea id = "description" name = "description" class="form-control inputstl"
                                required autocomplete="description" autofocus></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="keyword" class="col-form-label font-weight-bold">{{ __('SEO Keyword:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "keyword" id = "keyword" class = "form-control"
                                autocomplete="keyword" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="status" class="col-form-label font-weight-bold">{{ __('Status:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select name = "status" id = "status" class = "form-control" >
                                <option value="1">Enabled</option>
                                <option value="0">Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <a href = "{{ route('admin.informations.index') }}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
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
        CKEDITOR.replace('description', {
            uiColor:    '#CCEAEE',
            width:      '100%'
        });
    });
</script>

@stop