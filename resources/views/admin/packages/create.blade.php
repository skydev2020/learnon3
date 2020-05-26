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
                        <div class="form-group row">
                            <div class="offset-3 col-8 col-md-6 text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                                &nbsp;&nbsp;
                                <a href = "{{ route('admin.packages.index') }}">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                </a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for="name" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Package Name:
                                </label>
                            </div>                            
                            <div class="col-8 col-md-6">
                                <input  class="form-control" name="name" id = "name" required
                                 autocomplete="on" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <label for = "hours" class="col-form-label font-weight-bold">
                                     Hours:
                                </label>
                            </div>
                            <div class="col-8 col-md-6">
                                <input class="form-control" name="hours" id = "hours" value="1"
                                 autocomplete="hours" autofocus type="number" step="0.01" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="prepaid" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Pre-paid:
                                </label>
                            </div>
                            <div class="col-8 col-md-6 d-flex align-items-center">
                                <label class = "radio-inline mb-0">
                                    <input type="radio" name="prepaid" id="prepaid" value="1" required>&nbsp;Yes
                                </label> &nbsp; &nbsp;
                                <label class = "radio-inline mb-0">
                                    <input type="radio" name="prepaid" id="prepaid" value="0" required>&nbsp;No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="student" class="col-form-label font-weight-bold">Assign to student:</label>
                            </div>

                            <div class="col-8 col-md-6 d-flex align-items-center">
                                <select id="student" name="student" class="form-control">
                                    <option value="0"></option>
                                    @foreach ($data['students'] as $student)
                                    <option value = "{{$student->id}}">{{$student->fname . ' ' . $student->lname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="grades" class="col-form-label font-weight-bold">
                                    <span class="required">*</span> Grades:
                                </label>
                            </div>
                            <div class="col-8 col-md-6 d-flex flex-column">
                                <div id="grades_box" class="scrollbox pl-1 pt-1 overflow-auto">
                                    <?php $i=0; ?>
                                    @foreach ($data['grades'] as $grade)
                                    <div class="<?php echo $i%2 == 0  ? "even" : "odd"; ?>">
                                        <input type="checkbox" value = "{{$grade->id}}"
                                        name = "grades[]">&nbsp;{{$grade->name}}
                                    </div>
                                    <?php $i++; ?>
                                    @endforeach
                                </div>
                                <div>
                                    <a style="cursor:pointer;" onclick="$('#grades_box :checkbox').attr('checked', 'checked');"><u>Select All</u></a> /
                                    <a style="cursor:pointer;" onclick="$('#grades_box :checkbox').attr('checked', false);"><u>Unselect All</u></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">                                
                                <label for="description" class="col-form-label font-weight-bold">
                                    {{ __(' Description') }}
                                </label>
                            </div>
                            <div class = "col-8 col-md-6">
                                <textarea class = "form-control inputstl" required name="description" required id="description" autofocus
                                ></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">                                
                                <label for="price_usa" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Price USA') }}
                                </label>                                
                            </div>
                            <div class = "col-8 col-md-6">
                                <input class="form-control" name="price_usa" id = "price_usa" required
                                autocomplete="on" autofocus type="number" step="0.01" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="price_canada" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Price Canada') }}
                                </label>                                
                            </div>
                            <div class = "col-8 col-md-6">
                                <input class="form-control" name="price_canada" id = "price_canada" required
                                autocomplete="on" autofocus type="number" step="0.01" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="price_others" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Price Others') }}
                                </label>                                
                            </div>
                            <div class="col-8 col-md-6">
                                <input class="form-control" name="price_others" id="price_others" required
                                autocomplete="on" autofocus type="number" step="0.01" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="status" class="col-form-label font-weight-bold">
                                    <span class="required">*</span>{{ __(' Status') }}
                                </label>                                
                            </div>
                            <div class="col-8 col-md-6 d-flex align-items-center">
                                <label class = "radio-inline mb-0">
                                    <input type="radio" name="status" id="status" value="1" required>&nbsp;Enable
                                </label> &nbsp; &nbsp;
                                <label class = "radio-inline mb-0">
                                    <input type="radio" name="status" id="status" value="0" required>&nbsp;Disable
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
