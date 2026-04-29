@extends('frontend.layouts.master')

@section('title', 'TechConnect | Login')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shop Login -->
    <section class="shop login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <!-- Login Box -->
                    <div class="card-style p-4">
                        <div class="login-form">
                            <h2 class="mb-4">Login</h2>
                            <!-- Form -->
                            <form class="form" method="post" action="{{route('login.submit')}}">
                                @csrf
                                <div class="row">
                                    <!-- Email -->
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="email">Your Email<span>*</span></label>
                                            <input id="email" type="email" name="email" placeholder="Enter your email"
                                                required class="form-control" value="{{old('email')}}">
                                            @error('email')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Password -->
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="password">Your Password<span>*</span></label>
                                            <input id="password" type="password" name="password"
                                                placeholder="Enter your password" required class="form-control">
                                            @error('password')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Login Button -->
                                    <div class="col-12 mb-3">
                                        <button class="btn btn-primary w-100" type="submit">Login</button>
                                    </div>

                                    <!-- Register Link -->
                                    <div class="col-12 text-center">
                                        <p class="mt-2">Don't have an account? <a href="{{route('register.form')}}"
                                                class="text-purple">Register</a></p>
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
    <!--/ End Login -->
@endsection

@push('styles')
    <style>
.shop.login.section {
    padding-top: 40px !important;   /* space sa taas */
    padding-bottom: 10px !important; /* mas maliit na space sa baba */
}

.card-style {
    background: #fff;
    border-radius: 12px;
    padding: 15px 10px;   /* bawas loob (top-bottom 15px, left-right 20px) */
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
} 
.shop.login .container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

        .lost-pass.ms-auto {
            margin-right: -20px;
            /* push sa right */
        }


        .form-login-rem-forg {
            margin-left: 20px;
            /* bawasan space mula sa left */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-check-input {
            margin-top: 0;
            /* alisin default spacing */
        }

        .form-check-label {
            margin-bottom: 0;
            font-size: 14px;
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

        .btn-primary:active {
            filter: brightness(0.85);
        }


        .lost-pass {
            font-size: 14px;
            color: var(--purple);
            text-decoration: underline;
        }

        .lost-pass:hover {
            color: #4b0082;
            /* slightly darker purple */
        }

        /* Register link */
        .text-purple {
            color: var(--purple);
            text-decoration: none;
        }

        .text-purple:hover {
            color: #4b0082;
        }
    </style>
@endpush