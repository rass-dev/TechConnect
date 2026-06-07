@extends('backend.layouts.master')

@section('main-content')

<div class="tc-form-wrap">
    <div class="tc-form-card">
        <div class="tc-form-header">
            <div class="tc-form-header-left">
                <div class="tc-form-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h5>Add New User</h5>
                    <p>Create a new user account</p>
                </div>
            </div>
            <a href="{{ route('users.index') }}" class="tc-btn-back">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>

        <div class="tc-form-body">
            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="tc-form-grid">

                    {{-- Left column: photo upload --}}
                    <div class="tc-form-photo-col">
                        <div class="tc-photo-upload" onclick="document.getElementById('photo').click()">
                            <img id="photo-preview" src="{{ asset('backend/img/avatar.png') }}" alt="preview">
                            <div class="tc-photo-overlay">
                                <i class="fas fa-camera"></i>
                                <span>Upload Photo</span>
                            </div>
                        </div>
                        <input id="photo" type="file" name="photo" class="d-none" accept="image/*"
                               onchange="previewImage(event)">
                        <p class="tc-photo-hint">Click to upload profile photo<br><small>JPG, PNG, GIF (max 2MB)</small></p>
                        @error('photo')
                            <span class="tc-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Right column: fields --}}
                    <div class="tc-form-fields-col">

                        <div class="tc-field-group">
                            <label class="tc-label" for="name">
                                <i class="fas fa-user"></i> Full Name <span class="tc-required">*</span>
                            </label>
                            <input id="name" type="text" name="name"
                                   placeholder="Enter full name"
                                   value="{{ old('name') }}"
                                   class="tc-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   maxlength="80" required>
                            @error('name')
                                <span class="tc-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="tc-field-group">
                            <label class="tc-label" for="email">
                                <i class="fas fa-envelope"></i> Email Address <span class="tc-required">*</span>
                            </label>
                            <input id="email" type="email" name="email"
                                   placeholder="Enter email address"
                                   value="{{ old('email') }}"
                                   class="tc-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   maxlength="255" required>
                            @error('email')
                                <span class="tc-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="tc-field-group">
                            <label class="tc-label" for="password">
                                <i class="fas fa-lock"></i> Password <span class="tc-required">*</span>
                            </label>
                            <div class="tc-input-pw-wrap">
                                <input id="password" type="password" name="password"
                                       placeholder="Enter password"
                                       class="tc-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       minlength="8" maxlength="128" required>
                                <button type="button" class="tc-pw-toggle" onclick="togglePassword('password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <p class="tc-hint">Min. 8 characters with letters, numbers, and a symbol (e.g. !@#$).</p>
                            @error('password')
                                <span class="tc-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="tc-form-row">
                            {{-- Role --}}
                            @auth
                                @if(auth()->user()->role === 'superadmin')
                                    @php $roles = ['superadmin', 'admin', 'user']; @endphp
                                    <div class="tc-field-group">
                                        <label class="tc-label" for="role">
                                            <i class="fas fa-shield-alt"></i> Role <span class="tc-required">*</span>
                                        </label>
                                        <select name="role" id="role" class="tc-select">
                                            <option value="">— Select Role —</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                                    {{ ucfirst($role) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <span class="tc-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @elseif(auth()->user()->role === 'admin')
                                    <input type="hidden" name="role" value="user">
                                @endif
                            @endauth

                            {{-- Status --}}
                            <div class="tc-field-group">
                                <label class="tc-label" for="status">
                                    <i class="fas fa-toggle-on"></i> Status <span class="tc-required">*</span>
                                </label>
                                <select name="status" id="status" class="tc-select">
                                    <option value="active"   {{ old('status', 'active') == 'active'   ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <span class="tc-field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="tc-form-footer">
                    <button type="reset" class="tc-btn tc-btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    <button type="submit" class="tc-btn tc-btn-primary">
                        <i class="fas fa-check"></i> Create User
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .tc-form-wrap { max-width: 860px; }
    .tc-form-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(110,67,193,.08);
        overflow: hidden;
    }
    .tc-form-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 28px;
        border-bottom: 1px solid #f0edfb;
        background: linear-gradient(135deg, #faf8ff 0%, #fff 100%);
    }
    .tc-form-header-left { display: flex; align-items: center; gap: 14px; }
    .tc-form-icon {
        width: 42px; height: 42px;
        background: linear-gradient(135deg, #6E43C1, #996EF8);
        color: #fff; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
    }
    .tc-form-header h5 { margin: 0; font-size: 16px; font-weight: 700; color: #1F2340; }
    .tc-form-header p  { margin: 0; font-size: 12px; color: #9ca3af; }
    .tc-btn-back {
        display: inline-flex; align-items: center; gap: 6px;
        color: #6b7280; font-size: 13px; font-weight: 500;
        text-decoration: none;
        padding: 7px 14px; border-radius: 8px;
        border: 1px solid #e5e7eb;
        transition: all .2s;
    }
    .tc-btn-back:hover { color: #6E43C1; border-color: #c4b5fd; background: #faf8ff; text-decoration: none; }

    .tc-form-body { padding: 28px; }

    /* Grid layout */
    .tc-form-grid { display: grid; grid-template-columns: 200px 1fr; gap: 32px; align-items: start; }
    @media (max-width: 640px) { .tc-form-grid { grid-template-columns: 1fr; } }

    /* Photo upload */
    .tc-photo-upload {
        position: relative; width: 160px; height: 160px;
        border-radius: 50%; overflow: hidden;
        cursor: pointer; margin: 0 auto;
        border: 3px solid #ede8fb;
        box-shadow: 0 4px 16px rgba(110,67,193,.15);
    }
    .tc-photo-upload img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .tc-photo-overlay {
        position: absolute; inset: 0;
        background: rgba(110,67,193,.7);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 6px; color: #fff;
        opacity: 0; transition: opacity .2s;
        font-size: 12px; font-weight: 600;
    }
    .tc-photo-overlay i { font-size: 22px; }
    .tc-photo-upload:hover .tc-photo-overlay { opacity: 1; }
    .tc-photo-hint { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 10px; line-height: 1.5; }

    /* Form row */
    .tc-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 480px) { .tc-form-row { grid-template-columns: 1fr; } }

    /* Field group */
    .tc-field-group { margin-bottom: 20px; }
    .tc-label {
        display: flex; align-items: center; gap: 6px;
        font-size: 13px; font-weight: 600; color: #374151;
        margin-bottom: 7px;
    }
    .tc-label i { color: #996EF8; font-size: 12px; }
    .tc-required { color: #ef4444; font-size: 14px; }

    .tc-input, .tc-select {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e5e7eb;
        border-radius: 9px;
        font-size: 13px; color: #1F2340;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        appearance: none;
    }
    .tc-input:focus, .tc-select:focus {
        border-color: #996EF8;
        box-shadow: 0 0 0 3px rgba(153,110,248,.12);
    }
    .tc-input.is-invalid, .tc-select.is-invalid { border-color: #ef4444; }
    .tc-select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%236b7280' d='M1 1l5 5 5-5'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; cursor: pointer; }

    /* Password toggle */
    .tc-input-pw-wrap { position: relative; }
    .tc-input-pw-wrap .tc-input { padding-right: 44px; }
    .tc-pw-toggle {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #9ca3af; font-size: 14px; padding: 0;
        transition: color .2s;
    }
    .tc-pw-toggle:hover { color: #6E43C1; }

    .tc-hint { margin: 5px 0 0; font-size: 11px; color: #9ca3af; }
    .tc-field-error { display: block; margin-top: 4px; font-size: 12px; color: #ef4444; }

    /* Footer */
    .tc-form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        padding-top: 24px; margin-top: 4px;
        border-top: 1px solid #f0edfb;
    }
    .tc-btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 22px; border-radius: 9px;
        font-size: 13px; font-weight: 600; border: none; cursor: pointer;
        transition: all .2s; text-decoration: none;
    }
    .tc-btn-primary {
        background: linear-gradient(135deg, #6E43C1, #996EF8);
        color: #fff;
        box-shadow: 0 4px 12px rgba(110,67,193,.25);
    }
    .tc-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(110,67,193,.35); }
    .tc-btn-secondary {
        background: #f3f4f6; color: #374151;
        border: 1px solid #e5e7eb;
    }
    .tc-btn-secondary:hover { background: #e5e7eb; }
</style>
@endpush

@push('scripts')
<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        document.getElementById('photo-preview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

function togglePassword(id, btn) {
    var input = document.getElementById(id);
    var icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush