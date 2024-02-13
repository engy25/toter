<!-- create.blade.php -->
@extends('layouts.layoutMaster')

@section('title', 'Add Address')

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

@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Make Order</h4>
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

    <form method="post" action="{{ route('store.order.butler', ['userId' => $userId]) }}" enctype="multipart/form-data">
      @csrf


      <h5>From Address</h5>
      <div class="form-group">
        <label for="up_country_id">City </label>
        <select name="city_id" class="form-control" id="city_id">
          @foreach($cities as $city)
          <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
        <span class="text-danger error-message" id="error_city_id"></span>
      </div><br>

      <div class="form-group">
        <label for="district_id">District </label>
        <select name="district_id" class="form-control" id="district_id"></select>
        <span class="text-danger error-message" id="error_district_id">
          @if(isset($status) && $status == 401)
          {{ trans('api.invalid_district_for_store') }}
          @endif
        </span>
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
        <input type="text" class="form-control" id="instructions" name="instructions">
      </div>


      <h5>To Address</h5>
      <div class="form-group">
        <label for="tocity_id">City </label>
        <select name="tocity_id" class="form-control" id="tocity_id">
          @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
        <span class="text-danger error-message" id="error_tocity_id"></span>
      </div><br>

      <div class="form-group">
        <label for="todistrict_id">District </label>
        <select name="todistrict_id" class="form-control" id="todistrict_id"></select>
        <span class="text-danger error-message" id="error_todistrict_id">
          @if(isset($status) && $status == 401)
            {{ trans('api.invalid_district_for_store') }}
          @endif
        </span>
      </div>

      <div class="mb-3">
        <label for="tobuilding" class="form-label"> Building </label>
        <input type="text" class="form-control required" id="tobuilding" name="tobuilding" required>
      </div>

      <div class="mb-3">
        <label for="tostreet" class="form-label"> Street </label>
        <input type="text" class="form-control required" id="tostreet" name="tostreet" required>
      </div>

      <div class="mb-3">
        <label for="toapartment" class="form-label">Apartment </label>
        <input type="text" class="form-control required" id="toapartment" name="toapartment" required>
      </div>

      <div class="mb-3">
        <label for="toinstructions" class="form-label">Instructions </label>
        <input type="text" class="form-control" id="toinstructions" name="toinstructions">
      </div>


      <h3>Cost</h3>

      <!-- expected_cost -->
      <div class="mb-3">
        <label for="expected_cost">Expected Cost</label>
        <input type="number" name="expected_cost" class="form-control" step="0.01" id="expected_cost">
        <span class="text-danger error-message" id="error_expected_cost"></span>
      </div>
      <!-- expected_cost -->
      <div class="mb-3">
        <label for="expected_delivery">Expected Delivery Charge</label>
        <input type="number" name="expected_delivery" class="form-control" step="0.01" id="expected_delivery">
        <span class="text-danger error-message" id="error_expected_delivery"></span>
      </div>


      <h3>Order</h3>

      <!-- expected_cost -->
      <div class="mb-3">
        <label for="orderType">Select Order Type:</label>
        <select id="orderType" name="orderType" class="form-control" onchange="toggleFormElements()">
          <option>Choose Order Type</option>
          @foreach($butlers as $butler)
          <option value="{{ $butler->id }}">{{ $butler->name }}</option>
          @endforeach
        </select>
      </div>

      <div id="addOrderForm" style="display: none;">
        <div class="mb-3">
          <label for="order" class="form-label">Order </label>
          <input type="text" class="form-control" id="order" name="order" >
        </div>

      </div>


      <!-- Add Item Section -->
      <div class="card mb-3" id="addItemsForm" style="display: none;">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#itemsContainer" aria-expanded="true"
              aria-controls="itemsContainer">
              Add Items
            </button>
          </h5>
        </div>

        <div id="itemsContainer" class="collapse show">
          <div class="card-body">
            <!-- Existing store Add Ingredients (if any) will be added here dynamically -->
            <button type="button" class="btn btn-success" onclick="addItem()">Add Item</button>
          </div>
        </div>
      </div>



      <button type="submit" class="btn btn-primary">Add Order</button>
    </form>
  </div>
</div>
</div>
@include('content.orderCallcenter.orderbutler.orderbutler_js')
@endsection
