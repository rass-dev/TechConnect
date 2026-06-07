@extends('backend.layouts.master')

@section('title', 'Admin Profile')

@section('main-content')

    <div class="card profile-card shadow-lg border-0 rounded-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-dark">My Profile</h4>
            <ul class="breadcrumbs mb-0">
                <li><a href="{{route('admin')}}" class="text-secondary">Dashboard</a></li>
                <li><a href="" class="active text-primary">Profile Page</a></li>
            </ul>
        </div>

        <div class="card-body profile-card-body">
            <div class="row g-4">
                <!-- Profile Picture -->
                <div class="col-md-4 text-center">
                    <div class="position-relative d-inline-block">
                        <img id="profileImagePreview"
                            src="{{ $profile->photo ? asset($profile->photo) : asset('backend/img/avatar.png') }}"
                            alt="profile picture" class="profile-img" />

                        <!-- Pencil Icon -->
                        <button type="button" class="btn btn-sm btn-light shadow position-absolute edit-btn"
                            data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                    </div>
                </div>

                <!-- Profile Form -->
                <div class="col-md-8">
                    <form class="p-3" method="POST" action="{{ route('profile-update', $profile->id) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="file" name="photo" id="finalPhotoInput" class="d-none">

                        <div class="form-group mb-3">
                            <label for="inputName" class="form-label">Name</label>
                            <input id="inputName" type="text" name="name" value="{{ $profile->name }}"
                                class="form-control rounded">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input id="inputEmail" type="email" name="email" value="{{ $profile->email }}"
                                class="form-control rounded">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control rounded bg-light" value="{{ $profile->role }}" disabled>
                        </div>

                        <div class="d-flex justify-content-end align-items-center" style="gap: 15px;">
                            <a href="{{ route('change.password.form') }}" class="btn btn-primary px-4 rounded shadow-sm">
                                <i class="fas fa-key me-1"></i> Update Password
                            </a>
                            <button type="submit" class="btn btn-success px-4 rounded shadow-sm">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title">Update Profile Picture</h5>
                    <button type="button" class="btn-close btn-close-red" data-bs-dismiss="modal"></button>

                </div>
                <form id="photoForm" method="POST" enctype="multipart/form-data"
                    action="{{ route('profile.update.photo', $profile->id) }}">
                    @csrf
                    <div class="modal-body text-center">
                        <input type="file" name="photo" id="photoInput" class="form-control" accept="image/*" required>
                        <div class="mt-3">
                            <img id="modalPreview" src="#" alt="preview" style="max-width:150px; display:none;"
                                class="rounded shadow">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <style>
        .profile-card {
            margin: 20px;
        }

        .profile-card-body {
            padding-left: 40px;
            padding-right: 40px;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .breadcrumbs {
            list-style: none;
            padding-left: 0;
        }

        .breadcrumbs li {
            float: left;
            margin-right: 10px;
        }

        .breadcrumbs li a:hover {
            text-decoration: none;
        }

        .breadcrumbs li .active {
            color: #996EF8;
            font-weight: 500;
        }

        .breadcrumbs li+li:before {
            content: "/\00a0";
        }

        .profile-img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .edit-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            transform: translate(30%, 30%);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ddd;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.2s;
        }

        .edit-btn i {
            color: #333;
            font-size: 14px;
        }

        .edit-btn:hover {
            background-color: #f0f0f0;
            transform: translate(30%, 30%) scale(1.1);
        }


        .btn-close-red {
            position: relative;
            width: 24px;
            height: 24px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .btn-close-red::before,
        .btn-close-red::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 16px;
            height: 2px;
            background-color: red;/ transform-origin: center;
            transition: all 0.2s ease-in-out;
        }

        .btn-close-red::before {
            transform: translate(-50%, -50%) rotate(45deg);
        }

        .btn-close-red::after {
            transform: translate(-50%, -50%) rotate(-45deg);
        }

        .btn-close-red:hover::before,
        .btn-close-red:hover::after {
            box-shadow: 0 0 4px red, 0 0 6px red;
        }
    </style>


    @push('scripts')
        <!-- Bootstrap 5 Bundle (JS + Popper) - REQUIRED -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // Preview when choosing file
            document.getElementById('photoInput').addEventListener('change', function (e) {
                let file = e.target.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (ev) {
                        document.getElementById('modalPreview').src = ev.target.result;
                        document.getElementById('modalPreview').style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            document.getElementById("photoForm").addEventListener("submit", function (e) {
                e.preventDefault();
                let formData = new FormData(this);

                fetch("{{ route('profile.update.photo', $profile->id) }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // update preview sa main profile
                            document.getElementById("profileImagePreview").src = data.photo_url;
                            // reset modal preview
                            document.getElementById("modalPreview").style.display = "none";
                            document.getElementById("photoInput").value = "";

                            // CLOSE MODAL
                            let modalEl = document.getElementById("uploadModal");
                            let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                            modal.hide();
                        }
                    });
            });

        </script>
    @endpush


@endsection