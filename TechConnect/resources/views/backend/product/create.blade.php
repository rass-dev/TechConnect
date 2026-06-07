@extends('backend.layouts.master')

@section('main-content')

  <div class="card">
    <h5 class="card-header">Add Product</h5>
    <div class="card-body">

      {{-- Flash Messages --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label for="inputTitle">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" value="{{old('title')}}" class="form-control">
          @error('title')<span class="text-danger">{{$message}}</span>@enderror
        </div>

        <div class="form-group">
          <label for="summary">Summary <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
          @error('summary')<span class="text-danger">{{$message}}</span>@enderror
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
          @error('description')<span class="text-danger">{{$message}}</span>@enderror
        </div>

        <div class="form-group">
          <label for="is_featured">Is Featured</label><br>
          <input type="checkbox" name='is_featured' id='is_featured' value='1'> Yes
        </div>

        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="cat_id">Category <span class="text-danger">*</span></label>
            <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Select any category--</option>
              @foreach($categories as $cat)
                <option value='{{$cat->id}}'>{{$cat->title}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group col-md-4 d-none" id="child_cat_div">
            <label for="child_cat_id">Sub Category</label>
            <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">--Select any sub category--</option>
            </select>
          </div>

          <div class="form-group col-md-4">
            <label for="brand_id">Brand <span class="text-danger">*</span></label>
            <select name="brand_id" class="form-control" required>
              <option value="">--Select Brand--</option>
              @foreach($brands as $brand)
                <option value="{{$brand->id}}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{$brand->title}}
                </option>
              @endforeach
            </select>
            @error('brand_id')<span class="text-danger">{{$message}}</span>@enderror
          </div>

        </div>

        <div class="form-group">
          <label for="price">Price <span class="text-danger">*</span></label>
          <input id="price" type="number" name="price" value="{{old('price')}}" class="form-control">
          @error('price')<span class="text-danger">{{$message}}</span>@enderror
        </div>

        <div class="form-group">
          <label for="discount">Discount (%)</label>
          <input id="discount" type="number" name="discount" min="0" max="100" value="{{old('discount')}}"
            class="form-control">
          @error('discount')<span class="text-danger">{{$message}}</span>@enderror
        </div>


        <div class="form-group">
          <label for="condition">Condition</label>
          <select name="condition" class="form-control">
            <option value="">--Select Condition--</option>
            <option value="standard">Standard</option>
            <option value="new">New</option>
            <option value="hot">Hot</option>
          </select>
        </div>

        <div class="form-group">
          <label for="stock">Quantity <span class="text-danger">*</span></label>
          <input id="stock" type="number" name="stock" min="0" value="{{old('stock')}}" class="form-control">
          @error('stock')<span class="text-danger">{{$message}}</span>@enderror
        </div>

        <div class="form-group">
          <label for="photo">Photo <span class="text-danger">*</span></label>
          <input id="photo" type="file" name="photo" class="form-control">
          @error('photo')<span class="text-danger">{{$message}}</span>@enderror
        </div>

        <div class="form-group">
          <label for="status">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
          @error('status')<span class="text-danger">{{$message}}</span>@enderror
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
          <button class="btn btn-success" type="submit">Submit</button>
        </div>

      </form>
    </div>
  </div>

@endsection

@push('styles')
  <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush

@push('scripts')
  <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
  <script>
    $(document).ready(function () {
      $('#summary').summernote({ height: 100 });
      $('#description').summernote({ height: 150 });

      // Subcategory AJAX
      $('#cat_id').change(function () {
        var cat_id = $(this).val();
        if (cat_id != '') {
          $.ajax({
            url: "/admin/category/" + cat_id + "/child",
            type: "POST",
            data: { _token: "{{csrf_token()}}", id: cat_id },
            success: function (response) {
              if (typeof (response) != 'object') { response = JSON.parse(response); }
              var html_option = "<option value=''>--Select Sub Category--</option>";
              if (response.status && response.data) {
                $('#child_cat_div').removeClass('d-none');
                $.each(response.data, function (id, title) {
                  html_option += "<option value='" + id + "'>" + title + "</option>";
                });
              } else {
                $('#child_cat_div').addClass('d-none');
              }
              $('#child_cat_id').html(html_option);
            }
          });
        }
      });
    });
  </script>
@endpush