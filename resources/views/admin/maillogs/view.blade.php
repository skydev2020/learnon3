@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-info-circle" style="font-size:24px;"> Mail Log</i>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label font-weight-bold">{{ __('Date Send:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            {{ date('m/d/Y', strtotime($maillog->created_at)) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label font-weight-bold">{{ __('Mail To:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            {{ $maillog->mail_to }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label font-weight-bold">{{ __('Mail From:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            {{ $maillog->mail_from }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <label class="col-form-label font-weight-bold">{{ __('Subject:') }}</label>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            {{ $maillog->subject }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3 d-flex justify-content-end">
                            <label for="mail_template" class="col-form-label font-weight-bold">{{ __('Message:') }}</label>
                        </div>
                        <div class="col-8 d-flex align-items-center">
                            <?php echo html_entity_decode($maillog->message); ?>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-6 offset-md-4">
                            <a href = "{{route('admin.maillogs.index')}}" >
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