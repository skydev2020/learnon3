@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Students</i>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-2 offset-11">
                            <a href = "{{route('admin.students.index')}}">
                                <button class = "btn btn-primary" type = "button">Cancel</button>
                            </a>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">First Name</label>
                        <div class="col-6 col-form-label font-weight-bold">
                            {{ __($data['student']->fname) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Last Name</label>
                        <div class="col-6 col-form-label font-weight-bold">
                            {{ __($data['student']->lname) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">E-Mail:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                            {{ __($data['student']->email) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Current Grade / Year:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                            {{ __($data['student']->grades()->first()['name']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label">Subjects:</label>
                        </div>

                        <div class="col-6 d-flex flex-column">
                            <div class="scrollbox pl-1 pt-1 font-weight-bold overflow-auto" id="subjects_box" name = "subjects_box">
                                @foreach ($data['student']->subjects()->get() as $subject)
                                <div>
                                    <input type = "checkbox" checked>{{$subject->name}}
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
                        <label class="col-3 col-form-label text-md-right">Parent First Name:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                            {{  __($data['student']->parent_fname) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Parent Last Name:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                            {{  __($data['student']->parent_lname) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Telephone:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                            {{  __($data['student']->home_phone) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Cell/Work Phone:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                            {{  __($data['student']->cell_phone) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Address:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                            {{  __($data['student']->address) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">City:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                            {{  __($data['student']->city) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Region / State:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                        {{  __($data['student']->state()->first()['name']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Postal Code:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                        {{  __($data['student']->pcode) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Country:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                        {{  __($data['student']->country()->first()['name']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Service Method:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                        {{  $data['student']->service_method }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Notes:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                        {{ $data['student']->other_notes }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">Major Street intersection:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                        {{ $data['student']->major_intersection }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label text-md-right">School name:</label>
                        <div class="col-6 col-form-label font-weight-bold">
                        {{ $data['student']->school }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 d-flex justify-content-end align-items-center">How you heard about us:</label>
                        <div class="col-6 d-flex align-items-center font-weight-bold ">
                            <select>
                                @foreach ($data['referrers'] as $referrer)
                                <option <?= $referrer->id == $data['student']->referrer_id ? "selected" : ""?>>
                                    {{$referrer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 d-flex justify-content-end align-items-center">Tutoring Status:</label>
                        <div class="col-6 d-flex align-items-center font-weight-bold">
                            <select>
                                @foreach ($data['student_statuses'] as $status)
                                <option <?= $status->id == $data['student']->student_status_id ? "selected" : ""?>>
                                    {{$status->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 d-flex justify-content-end align-items-center">Approved:</label>
                        <div class="col-6 d-flex align-items-center font-weight-bold ">
                            <select>
                                <option>Enabled</option>
                                <option <?= $data['student']->approved != 1 ? "selected" : "" ?>>Disabled</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 d-flex justify-content-end align-items-center">Status:</label>
                        <div class="col-6 d-flex align-items-center font-weight-bold ">
                            <select>
                                <option>Enabled</option>
                                <option <?= $data['student']->status_id != 1 ? "selected" : "" ?>>Disabled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
