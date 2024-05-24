
@extends('auth.layout')

@section('title')
Password Reset Form | {{ @$setting->site_name ? @$setting->site_name : config('app.name') }}
@endsection
@section('content')

  <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5 mb-4">
                        @if (@$setting->site_logo)
                            <img src="{{ url('/storage/public/uploads/site-logo/' . @$setting->site_logo) }}"
                                 alt="logo" class="logo">
                        @else
                            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="logo">
                        @endif
                    </div>
                    <!-- /Logo -->
                    <!-- Reset Password -->
                    <div class="card-body">
                        <h4 class="mb-2">Reset Password 🔒</h4>
                        <p class="mb-4">Your new password must be different from previously used passwords</p>
                        <form id="formAuthentication" class="mb-3" action="{{route('auth.submitResetPasswordForm')}}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

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

                            <div class="mb-3 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="password"
                                            id="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <label for="password">New Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="password"
                                            id="confirm-password"
                                            class="form-control"
                                            name="confirm-password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <label for="confirm-password">Confirm Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100 mb-3">Set new password</button>
                            <div class="text-center">
                                <a href="auth-login-basic.html" class="d-flex align-items-center justify-content-center">
                                    <i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px"></i>
                                    Back to login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Reset Password -->
                <img
                    alt="mask"
                    src="{{ asset('assets-file/img/illustrations/auth-basic-login-mask-light.png') }}"
                    class="authentication-image d-none d-lg-block"
                    data-app-light-img="illustrations/auth-basic-login-mask-light.png"
                    data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
            </div>
        </div>
    </div>

<section class="auth-page">
    <div class="auth-body-content">
        <div class="auth-card">
            <h3>{{ @$setting->site_name ? @$setting->site_name : config('app.name') }}</h3>
            <div class="auth-card-body">
                <div class="auth-card-head">
                    @if (@$setting->site_logo)
                        <img src="{{ url('/storage/public/uploads/site-logo/' . @$setting->site_logo) }}"
                            alt="logo" class="logo">
                    @else
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="logo">
                    @endif
                    <h3>Please Reset Password Here</h3>
                </div>
                <form action="{{route('auth.submitResetPasswordForm')}}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group row">
                        <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                        <div class="col-md-6">
                            <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                        <div class="col-md-6">
                            <input type="password" id="password" class="form-control" name="password" required autofocus>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                        <div class="col-md-6">
                            <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-4 submit-btn">
                        <button type="submit" class="btns">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
