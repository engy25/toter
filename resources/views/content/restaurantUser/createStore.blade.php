<!-- create.blade.php -->
@extends('layouts.layoutMaster')

@section('title', 'Create Order')

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
    <h4 class="card-title">Add New Order</h4>
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
    <form method="post" action="{{ route('createStore.store', ['user' => $user->id]) }}" enctype="multipart/form-data">

      @csrf

      <div class="form-group"></div>
      <label for="up_country_id">Store </label>
      <select name="store" class="form-control" id="store">
        @foreach($stores as $store)
        <option value="{{ $store->id }}">{{ $store->name }}</option>
        @endforeach
      </select>
      <span class="text-danger error-message" id="error_store"></span>
      <br><br>



      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Add Item</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>

@endsection
