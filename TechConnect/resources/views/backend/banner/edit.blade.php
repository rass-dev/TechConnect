@extends('backend.layouts.master')

@section('title', 'TechConnect | Banner Edit')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Edit Banner</h5>
        <div class="card-body">
            <form method="post" action="{{ route('banner.update', $banner->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="form-group">
                    <div class="d-flex align-items-center justify-content-between">
                        <label for="inputTitle" class="col-form-label">Title</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="show_title" name="show_title" value="1" 
                            {{ old('show_title', $banner->show_title) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_title">Show Title</label>
                        </div>
                    </div>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ old('title', $banner->title) }}"
                        class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group">
                    <div class="d-flex align-items-center justify-content-between">
                        <label for="description" class="col-form-label">Description</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="show_description" name="show_description"
                                value="1" {{ old('show_description', $banner->show_description) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_description">Show Description</label>
                        </div>
                    </div>
                    <textarea class="form-control" id="description" name="description">{{ old('description', $banner->description) }}</textarea>
                    @error('description')
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
                        <img id="photo-preview" style="max-height:150px;" src="{{ asset($banner->photo) }}" />
                    </div>
                </div>

                <!-- Show Button -->
                <div class="form-group">
                    <label for="show_button">
                        <input type="checkbox" name="show_button" id="show_button" value="1" 
                        {{ old('show_button', $banner->show_button) ? 'checked' : '' }}>
                        Show Shop Now Button
                    </label>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#description').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });

        // Preview Image
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
