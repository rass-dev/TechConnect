@extends('frontend.layouts.master')

@section('title', 'TechConnect | My Profile')

@section('main-content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="bread-inner">
                <ul class="bread-list">
                    <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                    <li class="active"><a href="javascript:void(0);">My Profile</a></li>
                </ul>
            </div>
        </div>
    </div>

    <section id="user-profile" class="account-page section">
        <div class="container">
            <div class="account-page-header">
                <h1>My Profile</h1>
                <p>Manage your account details and delivery information.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="account-card">
                        @if(session('success'))
                            <div class="account-alert account-alert-success">{{ session('success') }}</div>
                        @endif

                        <form id="profileForm" action="{{ route('user-profile-update') }}" method="POST" data-tc-validate="profile" novalidate>
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-field @error('name') has-error @enderror">
                                        <label for="profile-name">Full Name <span class="req">*</span></label>
                                        <input type="text" id="profile-name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $profile->name) }}" maxlength="80"
                                            autocomplete="name"
                                            @error('name') data-server-error="1" @enderror>
                                        <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                                        @error('name')
                                            <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-field @error('email') has-error @enderror">
                                        <label for="profile-email">Email <span class="req">*</span></label>
                                        <input type="email" id="profile-email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $profile->email) }}" maxlength="255"
                                            autocomplete="email"
                                            @error('email') data-server-error="1" @enderror>
                                        <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                                        @error('email')
                                            <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-field @error('contact_number') has-error @enderror">
                                        <label for="profile-contact">Contact Number</label>
                                        <input type="text" id="profile-contact" name="contact_number"
                                            class="form-control @error('contact_number') is-invalid @enderror"
                                            value="{{ old('contact_number', $profile->contact_number ?? '') }}"
                                            placeholder="09XX XXX XXXX" maxlength="20"
                                            autocomplete="tel"
                                            @error('contact_number') data-server-error="1" @enderror>
                                        <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                                        @error('contact_number')
                                            <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-field @error('postal_code') has-error @enderror">
                                        <label for="profile-postal">Postal Code</label>
                                        <input type="text" id="profile-postal" name="postal_code"
                                            class="form-control @error('postal_code') is-invalid @enderror"
                                            value="{{ old('postal_code', $profile->postal_code ?? '') }}" maxlength="10"
                                            autocomplete="postal-code"
                                            @error('postal_code') data-server-error="1" @enderror>
                                        <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                                        @error('postal_code')
                                            <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-field @error('address') has-error @enderror">
                                        <label for="profile-address">Address</label>
                                        <input type="text" id="profile-address" name="address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address', $profile->address ?? '') }}"
                                            placeholder="Street, City, Province" maxlength="255"
                                            autocomplete="street-address"
                                            @error('address') data-server-error="1" @enderror>
                                        <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                                        @error('address')
                                            <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 account-actions">
                                    <button type="submit" class="btn-account-primary">Save Changes</button>
                                    <a href="{{ route('user.change.password.form') }}" class="btn-account-secondary">Change Password</a>
                                    <a href="{{ route('user.delete.account') }}" class="btn-account-danger">Delete Account</a>
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
