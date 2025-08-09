@extends('layouts.master-without-nav')
@section('title')
OTP Verification
@endsection
@section('content')
<div class="auth-page-wrapper pt-5">
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>
        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <div class="auth-page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Verify Your Email</h5>
                                <p class="text-muted">Please enter the 6-digit code sent to your email.</p>
                            </div>

                            @if (session('status'))
                            <div class="alert alert-success text-center mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif

                            <div class="p-2 mt-4">
                                <form action="{{ route('otp.verify') }}" method="POST">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="otp" class="form-label">OTP Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp" name="otp" placeholder="Enter 6-digit OTP" required>
                                        @error('otp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        {{-- General error for session expiration etc. --}}
                                        @error('email')
                                        <div class="text-danger mt-2">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">Verify & Login</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Didn't receive the code? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline">Try again</a></p>
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
@section('script')
<script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
@endsection