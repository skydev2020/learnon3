@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px;"> Information</i>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('admin.informations.update', $data['information']) }}">
                        @csrf
                        {{method_field('PUT')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="title" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Information Title:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ $data['information']->title }}"
                                autocomplete="title" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="description" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Description:') }}</label>
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                <textarea id = "description" name = "description" class="form-control inputstl"
                                required autocomplete="description" autofocus>
                                <?php echo html_entity_decode($data['information']->description); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="keyword" class="col-form-label font-weight-bold">{{ __('SEO Keyword:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <input type = "text" name = "keyword" id = "keyword" class = "form-control"
                                value="<?= $data['urlalias'] != NULL ? $data['urlalias'] ->keyword : "" ?>" autocomplete="keyword" autofocus></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="status" class="col-form-label font-weight-bold">{{ __('Status:') }}</label>
                            </div>
                            <div class="col-6 d-flex">
                                <select name = "status" id = "status" class = "form-control" >
                                <option value="1" <?= $data['information']->status == 1 ? "selected" : "" ?> >Enabled</option>
                                <option value="0" <?= $data['information']->status == 0 ? "selected" : "" ?> >Disabled</option>
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
