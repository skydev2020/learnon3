@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie" style="font-size:24px"> Update Tutor Details</i>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.tutors.update', $tutor)}}" method="POST">
                        
                        <div class="form-group row">
                            <label for="email" class="col-2 col-form-label text-right">Email</label>

                            <div class="col-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                 name="email" value="{{$tutor->email }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="fname" class="col-2 col-form-label text-right">First Name</label>

                            <div class="col-6">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror"
                                 name="fname" value="{{ $tutor->fname }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname" class="col-2 col-form-label text-right">Last Name</label>

                            <div class="col-6">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror"
                                 name="lname" value="{{ $tutor->lname }}" required autofocus>

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
                            <label for="roles" class="col-2 col-form-label text-right">Roles</label>

                            <div class="col-6">
                                @foreach($roles as $role)
                                    <div class="form-check">
                                        <input type="checkbox" name="roles[]" value="{{$role->id}}"
                                        @if($tutor->roles->pluck('id')->contains($role->id)) checked @endif>
                                        <label>{{$role->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-2 col-form-label text-right">{{ __('Status') }}</label>
                            <div class="col-3">
                                <select style="display: inline-block;" id="status" name="status" class = "form-control">
                                    <option <?= $tutor->status > 0 ? "selected" : "" ?> value = "1">
                                        Enabled</option>
                                    <option <?= $tutor->status <= 0 ? "selected" : "" ?> value = "0">Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="approved" class="col-2 col-form-label text-right">{{ __('Approved') }}</label>
                            <div class="col-3">
                                <select style="display: inline-block;" id="approved" name="approved" class = "form-control">
                                    <option <?= $tutor->approved > 0 ? "selected" : "" ?> value = "1">
                                        Yes</option>
                                    <option <?= $tutor->approved <= 0 ? "selected" : "" ?> value = "0">
                                        No</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
