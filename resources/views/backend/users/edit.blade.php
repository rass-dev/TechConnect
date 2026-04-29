@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.update',$user->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('PATCH')

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name</label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter name" value="{{$user->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" type="email" name="email" placeholder="Enter email" value="{{$user->email}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="photo" class="col-form-label">Photo</label>
          <input type="file" name="photo" id="photo" class="form-control">
          @if($user->photo)
            <img src="{{ asset($user->photo) }}" alt="User Photo" style="margin-top:10px; max-height:100px;">
          @endif
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

          @auth
            @if(auth()->user()->role === 'superadmin')
              @php 
                $roles = ['admin', 'user','superadmin'];
              @endphp
              <div class="form-group">
                <label for="role" class="col-form-label">Role</label>
                <select name="role" class="form-control">
                  <option value="">-----Select Role-----</option>
                  @foreach($roles as $role)
                      <option value="{{$role}}" {{ $user->role == $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                      </option>
                  @endforeach
                </select>
                @error('role')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            @endif
          @endauth


        <div class="form-group">
          <label for="status" class="col-form-label">Status</label>
          <select name="status" class="form-control">
              <option value="active" {{ $user->status=='active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ $user->status=='inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection
