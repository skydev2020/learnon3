@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px"> Grades</i>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.grades.store') }}">
                        @csrf
                        {{method_field('POST')}}

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="name" class="col-form-label font-weight-bold">{{ __('Grade Name:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="name" type="text" class="form-control" name="name"
                                autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="subjects" class="col-form-label font-weight-bold">{{ __('Subjects:') }}</label>
                            </div>
                            <div class="col-6 d-flex flex-column">
                                <div class="scrollbox pl-1 pt-1 overflow-auto" id="subjects_box"
                                 style = "height: 400px;" name = "subjects_box">
                                    @foreach ($subjects as $subject)
                                        <div class = <?=$subject->id % 2 == 1 ? 'even' : 'odd'?>>
                                            <input type = "checkbox" name = 'subjects[]' value = "{{$subject->id}}">
                                            {{$subject['name']}}
                                            </input>
                                        </div>
                                    @endforeach
                                </div>
                                <div>
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', 'checked');"><u>Select All</u></a> /
                                    <a style="cursor:pointer;" onclick="$('#subjects_box :checkbox').attr('checked', false);"><u>Unselect All</u></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="price_usa" class="col-form-label font-weight-bold">{{ __('Price USA:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="price_usa" type="text" class="form-control" name="price_usa"
                                autocomplete="price_usa" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="price_alb" class="col-form-label font-weight-bold">{{ __('Price Alb:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="price_alb" type="text" class="form-control" name="price_alb"
                                autocomplete="price_alb" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3 d-flex justify-content-end align-items-center">
                                <label for="price_can" class="col-form-label font-weight-bold">{{ __('Price Canada:') }}</label>
                            </div>
                            <div class="col-6">
                                <input id="price_can" type="text" class="form-control" name="price_can"
                                autocomplete="price_can" autofocus>
                            </div>
                        </div>

                        <div class = "form-group row">
                            <div class = "col-3 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                            <div class = "col-3 d-flex align-items-center">
                                <a href = "{{ route('admin.subjects.index') }}">
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