@extends('frontend.layouts.master')



@section('title', 'TechConnect | Change Password')



@section('main-content')

    <div class="breadcrumbs">

        <div class="container">

            <div class="bread-inner">

                <ul class="bread-list">

                    <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>

                    <li><a href="{{ route('user-profile') }}">My Profile<i class="ti-arrow-right"></i></a></li>

                    <li class="active"><a href="javascript:void(0);">Change Password</a></li>

                </ul>

            </div>

        </div>

    </div>



    <section class="account-page section">

        <div class="container">

            <div class="account-page-header">

                <h1>Change Password</h1>

                <p>Update your password to keep your account secure.</p>

            </div>



            <div class="row justify-content-center">

                <div class="col-lg-6">

                    <div class="account-card">

                        <form id="passwordChangeForm" action="{{ route('user.change.password') }}" method="POST" data-tc-validate="passwordChange" novalidate>

                            @csrf

                            <div class="form-field @error('current_password') has-error @enderror">

                                <label for="current_password">Current Password <span class="req">*</span></label>

                                <input type="password" id="current_password" name="current_password"

                                    class="form-control @error('current_password') is-invalid @enderror" maxlength="128"

                                    @error('current_password') data-server-error="1" @enderror>

                                <span class="field-error field-error-live" role="alert" aria-live="polite"></span>

                                @error('current_password')

                                    <span class="field-error field-error-server" role="alert">{{ $message }}</span>

                                @enderror

                            </div>



                            <div class="form-field @error('new_password') has-error @enderror">

                                <label for="new_password">New Password <span class="req">*</span></label>

                                <input type="password" id="new_password" name="new_password"

                                    class="form-control @error('new_password') is-invalid @enderror" maxlength="128"

                                    @error('new_password') data-server-error="1" @enderror>

                                <span class="field-password-rule is-neutral" role="status" aria-live="polite">Min. 8 characters with letters, numbers, and a symbol (e.g. !@#$).</span>

                                @error('new_password')

                                    <span class="field-error field-error-server" role="alert">{{ $message }}</span>

                                @enderror

                            </div>



                            <div class="form-field @error('new_confirm_password') has-error @enderror">

                                <label for="new_confirm_password">Confirm New Password <span class="req">*</span></label>

                                <input type="password" id="new_confirm_password" name="new_confirm_password"

                                    class="form-control @error('new_confirm_password') is-invalid @enderror" maxlength="128"

                                    @error('new_confirm_password') data-server-error="1" @enderror>

                                <span class="field-error field-error-live" role="alert" aria-live="polite"></span>

                                @error('new_confirm_password')

                                    <span class="field-error field-error-server" role="alert">{{ $message }}</span>

                                @enderror

                            </div>



                            <div class="account-actions">

                                <button type="submit" class="btn-account-primary">Update Password</button>

                                <a href="{{ route('user-profile') }}" class="btn-account-secondary">Back to Profile</a>

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

