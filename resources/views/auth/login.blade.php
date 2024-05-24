@extends('auth.layout')

@section('title')
Login | {{ @$setting->site_name ? @$setting->site_name : config('app.name') }}
@endsection
@section('content')

<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Login -->
            <div class="card p-2">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                        @if (@$setting->site_logo)
                            <img src="{{ url('/storage/uploads/site-logo/' . @$setting->site_logo) }}"
                                 alt="logo" class="logo">
                        @else
                            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="logo">
                        @endif
                </div>
                <!-- /Logo -->

                <div class="card-body mt-2">
                    <h4 class="mb-2"> Ditya International Private Limited.</h4>
                    <p class="mb-4">Please sign-in to your account and start the adventure</p>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $error }}</strong>
                            </div>
                        @endforeach
                    @endif

                    <form id="formAuthentication1" action="{{ route('user.authenticate') }}" method="POST">
                            @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input
                                type="text"
                                class="form-control"
                                id="email"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Enter your email or username"
                                autofocus />
                            <label for="email">Email or Username</label>
                        </div>
                        <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="password"
                                            id="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <label for="password">Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                            <a href="{{ route('auth.showForgetPasswordForm') }}" class="float-end mb-1">
                                <span>Forgot Password?</span>
                            </a>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>


                </div>
            </div>
            <!-- /Login -->
            <img
                alt="mask"
                src="{{ asset('assets/img/illustrations/auth-basic-login-mask-light.png') }}"
                class="authentication-image d-none d-lg-block"/>
        </div>
    </div>
</div>

@endsection
