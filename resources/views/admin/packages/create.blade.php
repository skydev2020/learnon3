@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px"> Packages</i>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.packages.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row mb-0">
                            <div class="col-1 offset-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            <div class="col-1">
                                <a href = "{{ route('admin.packages.index') }}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-3 col-form-label text-right">
                                <span class="required">*</span> Package Name:
                            </label>

                            <div class="col-4">
                                <input  class="form-control" name="name" id = "name"
                                 autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hours" class="col-3 col-form-label text-right">Hours:</label>

                            <div class="col-4">
                                <input  class="form-control" name="hours" id = "hours" value="1"
                                 autocomplete="hours" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="prepaid" class="col-form-label">
                                    <span class="required">*</span> Pre-paid:
                                </label>
                            </div>

                            <div class="col-4 d-flex align-items-center">
                                <label class = "radio-inline">
                                    <input type="radio" name="prepaid" id="prepaid" value="1">&nbsp;Yes
                                </label> &nbsp; &nbsp;
                                <label class = "radio-inline">
                                    <input type="radio" name="prepaid" id="prepaid" value="0">&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="student" class="col-form-label">Assign to student:</label>
                            </div>

                            <div class="col-3 d-flex align-items-center">
                                <select id="student" name="student" class="form-control">
                                    <option></option>
                                    @foreach ($data['students'] as $student)
                                    <option value = "{{$student->id}}">{{$student->fname . ' ' . $student->lname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="grades" class="col-form-label">Grades:</label>
                            </div>

                            <div class="col-2 d-flex flex-column">
                                <div id="subjects_box" class="scrollbox pl-1 pt-1 overflow-auto">
                                    @foreach ($data['grades'] as $grade)
                                    <div>
                                        <input type="checkbox" value = "{{$grade->id}}"
                                        name = "grades[]" id="grades[]">&nbsp;{{$grade->name}}
                                    </div>
                                    @endforeach
                                </div>
                                <div>
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', 'checked');"><u>Select All</u></a> /
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', false);"><u>Unselect All</u></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" class = "col-10">
                            <label for="description" class="col-3 col-form-label text-right">
                                <span class="required">*</span>{{ __(' Description') }}
                            </label>

                            <div class = "col-6">
                                <textarea class = "form-control inputstl" name="description" id="description" autofocus
                                ></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price_usa" class="col-3 col-form-label text-right">{{ __('Price USA') }}</label>

                            <div class = "col-4">
                                <input  class="form-control" name="price_usa" id = "price_usa"
                                autocomplete="price_usa" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price_canada" class="col-3 col-form-label text-right">{{ __('Price Canada') }}</label>

                            <div class = "col-4">
                                <input  class="form-control" name="price_canada" id = "price_canada"
                                autocomplete="price_canada" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price_others" class="col-3 col-form-label text-right">{{ __('Price Others') }}</label>

                            <div class = "col-4">
                                <input  class="form-control" name="price_others" id="price_others"
                                autocomplete="price_others" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "status" class = "col-3 col-form-label text-right">
                                <span class="required">*</span>{{ __(' Status') }}
                            </label>

                            <div class="col-4 d-flex align-items-center">
                                <label class = "radio-inline">
                                    <input type="radio" name="status" id="status" value="1">&nbsp;Enable
                                </label> &nbsp; &nbsp;
                                <label class = "radio-inline">
                                    <input type="radio" name="status" id="status" value="0">&nbsp;Disable
                                </label>
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
