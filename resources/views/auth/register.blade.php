@extends('layouts.app')

@section('content')
<div class="vw-100 vh-100 overflow-hidden">
    <div class="login-overlay vh-100 vw-100"></div>
    <div class="vh-100 row justify-content-center" style="background-color: #000000;">
        <div class="login-img d-none d-lg-block col-lg-6" style="background-image: url(' {{ asset('assets/img/login cover.png') }} ')">
            <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                <div class="img-wrapper" style="width: 250px; margin: 0 auto; position: relative; z-index: 1;">
                    <a href="{{ route('landingpage') }}" style="width: 500px"><img style="width: 100%;" src="{{ $details->logo_url ?? 'assets/img/cmblogo.jpg' }}" alt=""></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 my-auto">
            <div class="row">
                <div class="col-md-8 mr-auto">
                    <div class="card bg-transparent" id="cmbloginquery" style=" box-shadow: 0 1rem 2rem hsl(0 0% 0% / 20%); background: #ffffff !important; border: 1px solid hidden; border-radius: 10px;">
                        <div class="card-header border-0 bg-transparent" style="text-align: center;">
                            <a href="{{ route('landingpage') }}"><img style="width: 100px; margin-left: 15px;" src="{{ $details->logo_url ?? 'assets/img/Color logo - no background.png' }}"> </a>
                            <h3 class="m-0 p-3 fw-bold">Make an account</h3>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row mb-2 px-3">
                                    <label for="name" class="col-md-12 col-form-label">{{ __('Name') }}</label>

                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="John Doe">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong><small>{{ $message }}</small></strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2 px-3">
                                    <label for="email" class="col-md-12 col-form-label">{{ __('Email Address') }}</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="example@example.com">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong><small>{{ $message }}</small></strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2 px-3">
                                    <label for="contact_no" class="col-md-12 col-form-label">{{ __('Contact #') }}</label>
                                    <div class="col-md-12">
                                        <input id="contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no') }}" pattern="^(09|\+639)\d{9}$" autofocus placeholder="+63 or 09">
                                        @error('contact_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong><small>{{ $message }}</small></strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2 px-3">
                                    <label for="password" class="col-md-12 col-form-label">{{ __('Password') }}</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Example_123">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong><small>{{ $message }}</small></strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 px-3">
                                    <label for="password-confirm" class="col-md-12 col-form-label">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-12">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Example_123">
                                    </div>
                                    <small class="text text-success" style="color: #8b8b8b !important; font-size: 10px;"> *If you encounter an OTP error, go back to the Home Page and contact us via the Contact section.
                                    </small>
                                </div>

                                <div class="d-flex justify-content-between mb-0 px-3">
                                    <button type="submit" class="btn btn-login">
                                        {{ __('Register') }}
                                    </button>
                                    <a href="{{ route('login') }}" type="button" class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-right" viewBox="0 0 16 16">
                                          <path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z"/>
                                        </svg>
                                        Login
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
