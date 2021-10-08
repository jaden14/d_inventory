@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: #eadbc8; border: none; margin-top: 5%;">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <center>
                        <div class="form-group">
                            <h1>Inventory System</h1>
                            <div class="col-md-8">
                            <div class="dropdown-divider" style="border-top: 1px solid #212529"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="col-md-8">
                                <button type="submit" style="background-color: #442900;" class="btn form-control">
                                    <span style="color: white;">{{ __('Login') }}</span>
                                </button>
                            </div>
                        </div>
                    </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
