@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Add User</h5>
        <div class="card-body">
            <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="col-form-label">Name</label>
                    <input id="name" type="text" name="name" placeholder="Enter name" value="{{ old('name') }}"
                        class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="col-form-label">Email</label>
                    <input id="email" type="email" name="email" placeholder="Enter email" value="{{ old('email') }}"
                        class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="col-form-label">Password</label>
                    <input id="password" type="password" name="password" placeholder="Enter password" class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="form-group">
                    <label for="photo" class="col-form-label">Photo</label>
                    <input id="photo" type="file" name="photo" class="form-control" accept="image/*"
                        onchange="previewImage(event)">
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div style="margin-top:15px;">
                        <img id="photo-preview" style="max-height:150px;" />
                    </div>
                </div>

<!-- Role -->
@auth
    @if(auth()->user()->role === 'superadmin')
        @php
            $roles = ['superadmin', 'admin', 'user'];
        @endphp
        <div class="form-group">
            <label for="role" class="col-form-label">Role</label>
            <select name="role" class="form-control">
                <option value="">-----Select Role-----</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ old('role', $user->role ?? '') == $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    @elseif(auth()->user()->role === 'admin')
        <!-- Hidden input, always "user" -->
        <input type="hidden" name="role" value="user">
    @endif
@endauth



                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="col-form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('photo-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush