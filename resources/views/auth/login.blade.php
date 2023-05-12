@extends('layouts.app')

@section('content')
<div class="vw-100 vh-100 overflow-hidden">

    <div class="login-overlay vh-100 vw-100"></div>

    <div class="vh-100 row justify-content-center" style="background-color: #000000;">
        
        <div class="login-img d-none d-lg-block col-lg-6" style="background-image: url(' {{ asset('assets/img/login cover.png') }} ')">
            <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                <div class="img-wrapper" style="width: 250px; margin: 0 auto; position: relative; z-index: 1; ">
                    <a href="{{ route('landingpage') }}" style="width: 500px"><img style="width: 100%;" src="{{ $details->logo_url ?? 'assets/img/cmblogo.jpg' }}" alt=""></a>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-6 my-auto">
            <div class="row">
                <div class="col-lg-8 mr-auto">
                    <div class="card bg-transparent" id="cmbloginquery" style="box-shadow: 0 1rem 2rem hsl(0 0% 0% / 20%); background: #ffffff !important; border: 1px solid hidden; border-radius: 10px;" >
                        <div class="card-header border-0 bg-transparent" style="text-align: center;">
                            <a href="{{ route('landingpage') }}"><img style="width: 100px; margin-left: 15px" src="{{ $details->logo_url ?? 'assets/img/Color logo - no background.png' }}"> </a>
                            <h3 class="m-0 p-3 fw-bold">Welcome back! </h3>
                        </div>
                        
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3 px-3">
                                    <label for="email" class="col-md-12 col-form-label">{{ __('Email Address') }}</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 px-3">
                                    <label for="password" class="col-md-12 col-form-label">{{ __('Password') }}</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mb-3 px-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    <a href="{{ route('register') }}"> Create account </a>
                                </div>

                                <div class="row mb-0 px-3">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-login">
                                            {{ __('Login') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}" style=" text-decoration: none;">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                        </div>{{-- //new card --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
