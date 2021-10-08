@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                </div>
                @elseif ($message = Session::get('delete'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                </div>
                @endif
    <div class="card-header">{{ __('Change Password') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.update', $users->id) }}">
                @csrf
                {{ method_field('PATCH')}}

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>
                       <div class="col-md-6">
                            <input id="username" type="text" class="form-control" value="{{ $users->email }}" name="email" disabled="">

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('OLD Password') }}</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('current_password') }}" name="current_password" required>

                        @if ($errors->has('current_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('current_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}" name="password" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password_confirmation') }}" name="password_confirmation" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Change') }}
                        </button>
                        <a href="{{ url('home') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
