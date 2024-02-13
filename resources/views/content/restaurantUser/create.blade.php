<!-- create.blade.php -->
@extends('layouts.layoutMaster')

@section('title', 'Create User')

@section('vendor-style')
  <!-- Include your vendor styles here -->
@endsection

@section('page-style')
  <!-- Include your page-specific styles here -->
  <style>
    [required]:invalid+label::after {
      content: ' *';
      color: red;
    }
  </style>
@endsection

@section('vendor-script')
  <!-- Include your vendor scripts here -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('page-script')
  <script>
    // Your page-specific scripts go here
  </script>
@endsection

@section('content')
  <div class="alert alert-success" style="display: none;" id="success">
    User Added Successfully
  </div>

  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Add New User</h4>
    </div>
    <div class="card-body">
      <form method="post" action="{{ route('restaurantusers.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label for="fname" class="form-label">Name</label>
          <input type="text" class="form-control required" id="fname" name="fname" required>
          @error('fname')
            <div class="alert alert-danger mt-2" role="alert">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Phone</label>
          <div class="input-group">
            <select class="form-control" id="country" name="country" style="max-width: 70px;">
              @foreach($countries as $country)
                <option value="{{ $country->country_code }}">{{ $country->country_code }}</option>
              @endforeach
            </select>
            <input type="text" class="form-control required" id="phone" name="phone" required>
            @error('phone')
              <div class="alert alert-danger mt-2" role="alert">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" required>
          @error('email')
            <div class="alert alert-danger mt-2" role="alert">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input type="password" class="form-control" name="password" required>
            <button class="btn btn-outline-secondary" type="button" id="toggle-password">Toggle Password</button>
            @error('password')
              <div class="alert alert-danger mt-2" role="alert">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label for="store_id">This User Belongs To Store?</label>
          <select name="store_id" class="form-control" id="store_id">
            <option value="" disabled selected>Select Store</option>
            @foreach($stores as $store)
              <option value="{{ $store->id }}">{{ $store->name }}</option>
            @endforeach
          </select>
          @error('store_id')
            <div class="alert alert-danger mt-2" role="alert">
              {{ $message }}
            </div>
          @enderror
        </div>
<br><br>
        <button type="submit" class="btn btn-primary">Add User</button>
      </form>
    </div>
  </div>
@endsection
