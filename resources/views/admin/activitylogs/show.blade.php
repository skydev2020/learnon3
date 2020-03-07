@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Activity Log</div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label font-weight-bold">{{ __('User Name:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            {{$activitylog->users()->first()['fname'] . ' ' .
                             $activitylog->users()->first()['lname']}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label font-weight-bold">{{ __('Activity Name:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            {{ $activitylog->activity }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label font-weight-bold">{{ __('Activity Details:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            {{ $activitylog->activity_details }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label font-weight-bold">{{ __('Activity Date:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            {{ date('d/m/Y', strtotime($activitylog->created_at)) }}
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-6 offset-md-4">
                            <a href = "{{route('admin.activitylogs.index')}}" >
                                <button type = "button" class="btn btn-primary">
                                    {{ __('Cancel') }}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection