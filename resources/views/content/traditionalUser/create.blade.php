<!-- create.blade.php -->
@extends('layouts.layoutMaster')

@section('title', 'Create User')

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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('page-script')

<style>
  [required]:invalid+label::after {
    content: ' *';
    color: red;
  }
</style>


@endsection

<div class="alert alert-success" style="display: none;" id="success">

  User Added Successfully
</div>
@section('content')

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Add New User</h4>
  </div>
  <div class="card-body">
    @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <form method="post" action="{{ route('traditionalusers.store') }}" enctype="multipart/form-data">
      @csrf


      <div class="mb-3">
        <label for="fname" class="form-label"> Name </label>
        <input type="text" class="form-control required" id="fname" name="fname" required>
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
        </div>
      </div>


      <div class="mb-3">
        <label for="building" class="form-label"> Building </label>
        <input type="text" class="form-control required" id="building" name="building" required>
      </div>

      <div class="mb-3">
        <label for="street" class="form-label"> Street </label>
        <input type="text" class="form-control required" id="street" name="street" required>
      </div>


      <div class="mb-3">
        <label for="apartment" class="form-label">Apartment </label>
        <input type="text" class="form-control required" id="apartment" name="apartment" required>
      </div>


      <div class="mb-3">
        <label for="instructions" class="form-label">Instructions </label>
        <input type="text" class="form-control" id="instructions" name="instructions" >
      </div>


      <button type="submit" class="btn btn-primary">Add User</button>
    </form>
  </div>
</div>
</div>
</div>
@include("content.user.user_js")
@endsection
