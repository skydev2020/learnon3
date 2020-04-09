@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> My Profile</i>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.myprofile.update', $myuser)}}" method="POST">
                        
                        <div class="form-group row">
                            <label for="email" class="col-2 col-form-label text-md-right">E-mail</label>

                            <div class="col-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                 name="email" value="{{$myuser->email }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="fname" class="col-2 col-form-label text-md-right">First Name</label>

                            <div class="col-6">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror"
                                 name="fname" value="{{ $myuser->fname }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname" class="col-2 col-form-label text-md-right">Last Name</label>

                            <div class="col-6">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror"
                                 name="lname" value="{{ $myuser->lname }}" required autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group row">
                            <label for="password" class="col-2 col-form-label text-md-right">Password</label>

                            <div class="col-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                 name="password" value="{{ $myuser->password }}" required autofocus>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-conform" class="col-2 col-form-label text-md-right">{{ __('Confirm') }}</label>
                            <div class="col-6 d-flex align-items-center">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-1 offset-9">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            <div clas="col-1">
                                <a href = "{{route('home')}}">
                                    <button type = "button" class = "btn btn-primary">Cancel</button>
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
