@extends('frontend.layouts.master')
@section('main-content')

    <!-- Start User Profile -->
    <section id="user-profile" class="user-profile section">
        <div class="container">
            <div class="row justify-content-center">

                <!-- Profile Form -->
                <div class="col-lg-8 col-md-12 mb-4 mb-lg-0">
                    <div class="box card-style h-100">
                        <div class="title mb-4">
                            <h3>My Profile</h3>
                        </div>
                        <form action="{{ route('user-profile-update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Full Name -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Full Name<span>*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ $profile->name }}"
                                            required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Email<span>*</span></label>
                                        <input type="email" name="email" class="form-control" value="{{ $profile->email }}"
                                            required>
                                    </div>
                                </div>

                                <!-- Contact Number -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="text" name="contact_number" class="form-control"
                                            value="{{ $profile->contact_number ?? '' }}">
                                    </div>
                                </div>

                                <!-- Postal Code -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input type="text" name="postal_code" class="form-control"
                                            value="{{ $profile->postal_code ?? '' }}">
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ $profile->address ?? '' }}">
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="col-12 user-profile-buttons mt-3">
                                    <a href="{{ route('user.delete.account') }}" class="btn btn-danger">Delete Account</a>
                                    <a href="{{ route('user.change.password.form') }}" class="btn btn-warning">Change
                                        Password</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--/ End User Profile -->
@endsection

@push('styles')
    <style>
        /* Buttons */
        .user-profile .btn-primary {
            background: #986EF9;
            color: #fff;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .user-profile .btn-primary:hover {
            background: #8559e0;
        }

        .user-profile .btn-warning {
            background: #2F1B5E;
            color: #fff;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .user-profile .btn-warning:hover {
            background: #27164d;
        }

        .user-profile .btn-danger {
            background: #361E6E;
            color: #fff;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .user-profile .btn-danger:hover {
            background: #2c1859;
        }

        /* Card */
        .card-style {
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        /* Required asterisk */
        .user-profile label span {
            color: red;
        }

        /* Responsive spacing for 2-column layout */
        @media (max-width: 767px) {
            .user-profile .row>.col-md-6 {
                margin-bottom: 1rem;
            }
        }

        /* Buttons container */
        .user-profile-buttons {
            display: flex;
            justify-content: flex-start;
            /* pwede rin: center o space-between */
            gap: 20px;
            /* spacing sa pagitan ng buttons */
            flex-wrap: wrap;
            /* para automatic mag-wrap sa small screens */
        }

        /* Optional: responsive spacing for mobile */
        @media (max-width: 576px) {
            .user-profile-buttons {
                flex-direction: column;
                /* stack buttons vertically sa maliit na screen */
                gap: 10px;
            }
        }
    </style>
@endpush