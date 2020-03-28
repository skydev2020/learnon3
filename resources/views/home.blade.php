@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
            @can('manage-student-tutors')
            <div class = "card">
                <div class="card-header">Tutoring Status</div>
                <div class = "card-body">
                    <div class = "form-group row">
                        <div class = "col-3 d-flex">
                            <a href = "{{route('student.tutoringstatuses.stoptutoring')}}">
                                <button type = "button" class = "btn btn-primary">Stop Tutoring</button>
                            </a>
                        </div>
                        <div class = "col-5 d-flex">
                            -Click here to STOP current Tutoring
                        </div> 
                    </div>

                    <div class = "form-group row">
                        <div class = "col-3 d-flex">
                            <a href = "{{route('student.tutoringstatuses.resumetutoring')}}">
                                <button type = "button" class = "btn btn-primary">Resume Tutoring</button>
                            </a>
                        </div>
                        <div class = "col-5 d-flex">
                            -Click here to RESUME current Tutoring
                        </div> 
                    </div>

                    <div class = "form-group row">
                        <div class = "col-3 d-flex">
                            <a href = "{{route('student.tutoringstatuses.stoptutoring')}}">
                                <button type = "button" class = "btn btn-primary">Stop Tutoring</button>
                            </a>
                        </div>
                        <div class = "col-5 d-flex">
                            -Click here to request a change of tutor for your current tutoring.
                        </div> 
                    </div>

                    <div class = "form-group row">
                        <div class = "col-3 d-flex">
                            <a href = "{{route('student.tutoringstatuses.startnewtutoring')}}">
                                <button type = "button" class = "btn btn-primary">Start New Tutoring</button>
                            </a>
                        </div>
                        <div class = "col-5 d-flex">
                            -Click here to REQUEST new tutoring-new subject, new grade, new details.
                        </div> 
                    </div>
                </div>
            </div>
                
            <div class = "card">
                <div class = "card-header">Service Method</div>
                <div class = "card-body">
                    <div class = "form-group row">
                        <div class = "col-3 d-flex">
                            <a href = "{{route('student.tutoringstatuses.onlinetutoring')}}">
                                <button type = "button" class = "btn btn-primary">Online Tutoring</button>
                            </a>
                        </div>
                        <div class = "col-5 d-flex">
                            -Click here to REQUEST tutoring service with Online Tutoring.
                        </div> 
                    </div>

                    <div class = "form-group row">
                        <div class = "col-3 d-flex">
                            <a href = "{{route('student.tutoringstatuses.psersontutoring')}}">
                                <button type = "button" class = "btn btn-primary">In Person Tutoring</button>
                            </a>
                        </div>
                        <div class = "col-5 d-flex">
                            -Click here to REQUEST tutoring service with In Person Tutoring.
                        </div> 
                    </div>

                    <div class = "form-group row">
                        <div class = "col-3 d-flex">
                            <a href = "{{route('student.tutoringstatuses.both')}}">
                                <button type = "button" class = "btn btn-primary">Mix of Both</button>
                            </a>
                        </div>
                        <div class = "col-5 d-flex">
                            -Click here to REQUEST tutoring service with Mix of Both.
                        </div> 
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>

@endsection
