@extends('backend.layouts.master')
@section('main-content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-dark">Change Password</h5>
                </div>
   
                <div class="card-body">
                    <form method="POST" action="{{ route('change.password') }}">
                        @csrf 
   
                        {{-- Error messages --}}
                        @foreach ($errors->all() as $error)
                            <p class="text-danger small">{{ $error }}</p>
                        @endforeach 
  
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-right fw-semibold">
                                Current Password
                            </label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control rounded" name="current_password" autocomplete="current-password">
                            </div>
                        </div>
  
                        <div class="mb-3 row">
                            <label for="new_password" class="col-md-4 col-form-label text-md-right fw-semibold">
                                New Password
                            </label>
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control rounded" name="new_password" autocomplete="new-password">
                            </div>
                        </div>
  
                        <div class="mb-4 row">
                            <label for="new_confirm_password" class="col-md-4 col-form-label text-md-right fw-semibold">
                                Confirm New Password
                            </label>
                            <div class="col-md-6">
                                <input id="new_confirm_password" type="password" class="form-control rounded" name="new_confirm_password" autocomplete="new-password">
                            </div>
                        </div>
   
                        {{-- Button aligned LEFT --}}
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary px-4 rounded shadow-sm">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('styles')
<style>
    /* Ensure card header/footer spacing */
    .card-header {
        background-color: #fff;
        border-bottom: none;
    }

    /* Lower-left button */
    .card-body .d-flex {
        justify-content: flex-end; /* alin sa left */
        align-items: flex-end;       /* lower part ng form */
        gap: 1rem;                   /* spacing kung multiple buttons */
    }

    /* Optional: make inputs rounded and consistent */
    .form-control.rounded {
        border-radius: 0.5rem;
    }

    /* Error messages smaller and red */
    .text-danger {
        font-size: 0.85rem;
        margin: 0;
    }
</style>
@endpush
