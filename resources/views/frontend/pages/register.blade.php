@extends('frontend.layouts.master')

@section('title','TechConnect | Register Page')

@section('main-content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0);">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Shop Register -->
<section class="shop login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-12">
                <div class="card-style p-4">
                    <div class="login-form">
                        <h2 class="mb-3">Register</h2>
                        <!-- Form -->
                        <form class="form" method="post" action="{{route('register.submit')}}">
                            @csrf
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Your Name<span>*</span></label>
                                        <input type="text" name="name" placeholder="Enter your name" required class="form-control" value="{{old('name')}}">
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Your Email<span>*</span></label>
                                        <input type="email" name="email" placeholder="Enter your email" required class="form-control" value="{{old('email')}}">
                                        @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Your Password<span>*</span></label>
                                        <input type="password" name="password" placeholder="Enter your password" required class="form-control">
                                        @error('password')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Confirm Password<span>*</span></label>
                                        <input type="password" name="password_confirmation" placeholder="Confirm your password" required class="form-control">
                                        @error('password_confirmation')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Register Button -->
                                <div class="col-12 mb-3">
                                    <button class="btn btn-primary w-100" type="submit">Register</button>
                                </div>

                                <!-- Login Link -->
                                <div class="col-12 text-center">
                                    <p class="mt-2">Already have an account? <a href="{{route('login.form')}}" class="text-purple">Login</a></p>
                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Register -->
@endsection

@push('styles')
<style>
/* Card box */
.card-style {
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    transition: all 0.3s ease-in-out;
}

/* Input fields */
.shop.login .form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px 12px;
    transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.shop.login .form-control:focus {
    border-color: var(--purple);
    box-shadow: 0 0 6px rgba(128, 0, 128, 0.3);
    outline: none;
}

/* Buttons */
.btn-primary {
    background: var(--purple);
    border: none;
    color: #fff;
    font-weight: 500;
    border-radius: 8px;
    transition: filter 0.2s ease-in-out;
}

.btn-primary:hover {
    filter: brightness(0.9);
}

/* Login/Register link text */
.text-purple {
    color: var(--purple);
    text-decoration: none;
}

.text-purple:hover {
    color: #4b0082;
}
</style>
@endpush
