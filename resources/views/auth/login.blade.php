<!DOCTYPE html>
<html lang="en">

<head>
  <title>TechConnect | Login</title>
  @include('backend.layouts.head')

</head>

<body class="bg-gradient-primary d-flex align-items-center justify-content-center min-vh-100">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center w-100">
      <div class="col-xl-6 col-lg-8 col-md-9"> <!-- mas malaki na width -->

        <div class="card o-hidden border-0 shadow-lg">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-12"> <!-- buong lapad ng card -->
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Admin Login</h1>
                  </div>
                  <form class="user" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                      <input type="email"
                        class="form-control form-control-user @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" id="exampleInputEmail"
                        placeholder="Enter Email Address..." required autocomplete="email" autofocus>
                      @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <input type="password"
                        class="form-control form-control-user @error('password') is-invalid @enderror"
                        id="exampleInputPassword" placeholder="Password" name="password" required
                        autocomplete="current-password">
                      @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                      @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                  <hr>
                  <!-- <div class="text-center">
                    @if (Route::has('password.request'))
                      <a class="btn btn-link small" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                      </a>
                    @endif
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</body>


</html>