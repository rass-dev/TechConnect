@extends('frontend.layouts.master')

@section('title', 'TechConnect | Login')

@section('main-content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="bread-inner">
                <ul class="bread-list">
                    <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                    <li class="active"><a href="javascript:void(0);">Login</a></li>
                </ul>
            </div>
        </div>
    </div>

    <section class="auth-page section">
        <div class="container">
            <div class="account-page-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your TechConnect account to continue shopping.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card account-card">
                        <div class="auth-card-head">
                            <h2>Login</h2>
                            <p>Enter your email and password to access your account.</p>
                        </div>

                        @if(session('error'))
                            <div class="account-alert account-alert-error">{{ session('error') }}</div>
                        @endif

                        <form id="loginForm" action="{{ route('login.submit') }}" method="POST" data-tc-validate="login" novalidate>
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-field @error('email') has-error @enderror">
                                        <label for="login-email">Email <span class="req">*</span></label>
                                        <input type="email" id="login-email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" placeholder="Enter your email"
                                            maxlength="255" autocomplete="email"
                                            @error('email') data-server-error="1" @enderror>
                                        <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                                        @error('email')
                                            <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-field @error('password') has-error @enderror">
                                        <label for="login-password">Password <span class="req">*</span></label>
                                        <input type="password" id="login-password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter your password" maxlength="128" autocomplete="current-password"
                                            @error('password') data-server-error="1" @enderror>
                                        <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                                        @error('password')
                                            <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-auth-primary w-100">Sign In</button>
                                </div>
                                <div class="col-12 auth-card-footer">
                                    <p>Don't have an account? <a href="{{ route('register.form') }}">Create one</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/form-live-validate.js') }}"></script>
@endpush
