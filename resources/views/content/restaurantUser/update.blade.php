<!-- create.blade.php -->

@extends('layouts.layoutMaster')

@section('title', 'Update Delivery')

@section('vendor-style')
<!-- Include your vendor styles here -->
@endsection

@section('page-style')
<!-- Include your page-specific styles here -->
@endsection

@section('vendor-script')
<!-- Include your vendor scripts here -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@endsection


@section('content')

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Update Delivery</h4>
  </div>
  <div class="card-body">

    <form method="post" action="{{ route('restaurantusers.update', $restaurantuser->id) }}" enctype="multipart/form-data">
      @csrf

      @method('PUT')

      <div class="mb-3">
        <label for="fname" class="form-label">First Name </label>
        <input type="text" value="{{ $restaurantuser->fname }}" class="form-control" id="fname" name="fname" required>
        @error('fname')
        <div class="alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror
      </div>



      <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <div class="input-group">
          <select class="form-control" id="country" name="country" style="max-width: 70px;">
            @foreach($countries as $country)

            <option value="{{ $country->country_code }}" {{ $country->country_code ==
              $restaurantuser->country_code ? 'selected' : '' }}>{{ $country->country_code }}</option>
            @endforeach
          </select>
          <input type="text" class="form-control" id="phone" value="{{ $restaurantuser->phone  }}" name="phone" required>
          @error('phone')
          <div class="alert alert-danger" role="alert">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>


      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control"  value="{{ $restaurantuser->email }}" name="email" required>
        @error('email')
          <div class="alert alert-danger mt-2" role="alert">
            {{ $message }}
          </div>
        @enderror
      </div>



      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" name="password" >
          <button class="btn btn-outline-secondary" type="button" id="toggle-password"></button>
          @error('password')
          <div class="alert alert-danger" role="alert">
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
                <option value="{{ $store->id }}" {{ $store->id == $restaurantuser->store_id ? 'selected' : '' }}>
                    {{ $store->name }}
                </option>
            @endforeach
        </select>

        @error('store_id')
            <div class="alert alert-danger mt-2" role="alert">
                {{ $message }}
            </div>
        @enderror
    </div>




      <br><br>
      <div class="text-center my-3">
        <button type="submit" class="btn btn-primary">Update Delivery</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>

@endsection
