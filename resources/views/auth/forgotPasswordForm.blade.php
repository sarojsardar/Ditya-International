@extends('auth.layout')

@section('title')
Login | {{ @$setting->site_name ? @$setting->site_name : config('app.name') }}
@endsection
@section('content')
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Logo -->
            <div class="card p-2">
                <!-- Forgot Password -->
                <div class="app-brand justify-content-center mt-5">
                    @if (@$setting->site_logo)
                        <img src="{{ url('/storage/public/uploads/site-logo/' . @$setting->site_logo) }}"
                             alt="logo" class="logo">
                    @else
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="logo">
                    @endif
                </div>
                <!-- /Logo -->
                <div class="card-body mt-2">
                    <h4 class="mb-2">Forgot Password? 🔒</h4>
                    <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
                    <form id="formAuthentication" class="mb-3" action="{{ route('auth.submitForgetPasswordForm') }}" method="POST">
                            @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input
                                type="text"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Enter your email"
                                autofocus />
                            <label>Email</label>
                        </div>
                        <button class="btn btn-primary d-grid w-100">Send Reset Link</button>
                    </form>
                    <div class="text-center">
                        <a href="{{route('user.login')}}" class="d-flex align-items-center justify-content-center">
                            <i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px"></i>
                            Back to login
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Forgot Password -->
            <img
                alt="mask"
                src="{{ asset('assets-file/img/illustrations/auth-basic-login-mask-light.png') }}"
                class="authentication-image d-none d-lg-block"
                data-app-light-img="illustrations/auth-basic-login-mask-light.png"
                data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
        </div>
    </div>
</div>
@endsection
