@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card rounded-0">
                <div class="card-header">Authentication</div>

                @include('components.alerts.warning')

                <div class="card-body">
                    <form method="POST" action="{{ route('otp.authenticate') }}" autocomplete="off">
                        @csrf

                        <div class="row mb-3">
                            <span class="text text-success">Check your email for OTP code.</span>
                            <small style="font-size: 12px; color: #8b8b8b;">* Did not receive the OTP code? Please note that the code may take a few seconds or even hours to arrive, depending on server traffic. If you're still waiting for your OTP, don't worry - it should be with you soon. Alternatively, if you'd like to get in touch with us, please send an email to celebritymensbarbershopdavao@gmail.com and we'll be happy to assist you with your OTP.</small>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="otp" placeholder="######">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary rounded-0">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
