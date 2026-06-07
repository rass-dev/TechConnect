@extends('frontend.layouts.master')

@section('title', 'TechConnect | Register')

@section('main-content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="bread-inner">
                <ul class="bread-list">
                    <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                    <li class="active"><a href="javascript:void(0);">Register</a></li>
                </ul>
            </div>
        </div>
    </div>

    <section class="auth-page section">
        <div class="container">
            <div class="account-page-header">
                <h1>Create Account</h1>
                <p>Join TechConnect to shop premium PC components with secure checkout.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="auth-card account-card">
                        <div class="auth-card-head">
                            <h2>Register</h2>
                            <p>Fill in your details to get started.</p>
                        </div>

                        <form id="registerForm" action="{{ route('register.submit') }}" method="POST" data-tc-validate="register" novalidate>
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-field @error('name') has-error @enderror">
                                        <label for="reg-name">Your Name <span class="req">*</span></label>
                                        <input type="text" id="reg-name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" placeholder="Enter your name"
                                            maxlength="80" autocomplete="name"
                                            @error('name') data-server-error="1" @enderror>
                                        <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                                        @error('name')
                                            <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-field @error('email') has-error @enderror">
                                        <label for="reg-email">Your Email <span class="req">*</span></label>
                                        <input type="email" id="reg-email" name="email"
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
                                <div class="col-md-6">
                                    <div class="form-field @error('password') has-error @enderror">
                                        <label for="reg-password">Password <span class="req">*</span></label>
                                        <input type="password" id="reg-password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Create a password" maxlength="128" autocomplete="new-password"
                                            @error('password') data-server-error="1" @enderror>
                                        <span class="field-password-rule is-neutral" role="status" aria-live="polite">Min. 8 characters with letters, numbers, and a symbol (e.g. !@#$).</span>
                                        @error('password')
                                            <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-field @error('password_confirmation') has-error @enderror">
                                        <label for="reg-password-confirm">Confirm Password <span class="req">*</span></label>
                                        <input type="password" id="reg-password-confirm" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Confirm your password" maxlength="128" autocomplete="new-password"
                                            @error('password_confirmation') data-server-error="1" @enderror>
                                        <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                                        @error('password_confirmation')
                                            <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-auth-primary w-100">Create Account</button>
                                </div>
                                <div class="col-12 auth-card-footer">
                                    <p>Already have an account? <a href="{{ route('login.form') }}">Sign in</a></p>
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
