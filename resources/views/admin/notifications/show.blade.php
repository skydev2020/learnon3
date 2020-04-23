@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-envelope-open-text" style="font-size:24px"> Notification</i>
                </div>
                <div class="card-body">
                    <div class = "form-group row">
                        <div class="col-1 offset-11">
                            <a href = "{{route('admin.notifications.index')}}">
                                <button type = "button" class="btn btn-primary" >Cancel</button>
                            </a>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class = "col-3 d-flex justify-content-end align-items-center">
                            <label for="receivers" class="col-form-label font-weight-bold">
                                Date Received:</label>
                        </div>

                        <div class="col-6 d-flex align-items-center">
                            {{$notification->created_at}}
                        </div>
                    </div>

                    <div id = "receiver_box">
                    </div>

                    <div class="form-group row">
                        <div class = "col-3 d-flex justify-content-end align-items-center">
                            <label for="subject" class="col-form-label font-weight-bold">
                                Notification From:
                            </label>
                        </div>

                        <div class = "col-6 d-flex align-items-center">
                            <?= $notification->from_user() == NULL ? '' :
                            $notification->from_user()['fname'] . ' ' . $notification->from_user()['lname']
                            . ' [' . $notification->from_user()->roles()->first()['name'] . ']'?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class = "col-3 d-flex justify-content-end align-items-center">
                            <label for="message" class="col-form-label font-weight-bold">
                                Subject:
                            </label>
                        </div>

                        <div class="col-6 d-flex align-items-center">
                            {{$notification->subject}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class = "col-3 d-flex justify-content-end align-items-center">
                            <label for="message" class="col-form-label font-weight-bold">
                                Message:
                            </label>
                        </div>

                        <div class="col-6 d-flex align-items-center">
                            <span><?php echo html_entity_decode($notification->message); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
