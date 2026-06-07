<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechConnect | Admin Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('backend/css/admin-login.css') }}" rel="stylesheet">
</head>
<body class="admin-login-page">

    <div class="admin-login-wrap">
        <div class="admin-login-card">
            <div class="admin-login-brand">
                <img src="{{ asset('images/logo.png') }}" alt="TechConnect">
                <span>Tech<span class="accent">Connect</span></span>
            </div>

            <h1>Admin Portal</h1>
            <p class="subtitle">Sign in to manage products, orders, and customers.</p>

            @if(session('error'))
                <div class="admin-login-alert" role="alert">{{ session('error') }}</div>
            @endif

            <form id="adminLoginForm" method="POST" action="{{ route('login') }}" data-tc-validate="login" novalidate>
                @csrf

                <div class="form-field @error('email') has-error @enderror">
                    <label for="admin-email">Email Address <span class="req">*</span></label>
                    <input type="email" id="admin-email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="admin@techconnect.com"
                        maxlength="255" autocomplete="email" autofocus
                        @error('email') data-server-error="1" @enderror>
                    <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                    @error('email')
                        <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field @error('password') has-error @enderror">
                    <label for="admin-password">Password <span class="req">*</span></label>
                    <input type="password" id="admin-password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter your password" maxlength="128" autocomplete="current-password"
                        @error('password') data-server-error="1" @enderror>
                    <span class="field-error field-error-live" role="alert" aria-live="polite"></span>
                    @error('password')
                        <span class="field-error field-error-server" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-admin-login">Sign In</button>
            </form>

            <div class="admin-login-footer">
                @if (Route::has('password.request'))
                    <div class="admin-login-forgot">
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>
                @endif
                <p class="admin-login-copy">&copy; {{ date('Y') }} TechConnect. <a href="{{ route('home') }}">Back to store</a></p>
            </div>
        </div>
    </div>

    <script src="{{ asset('frontend/js/form-live-validate.js') }}"></script>
</body>
</html>
