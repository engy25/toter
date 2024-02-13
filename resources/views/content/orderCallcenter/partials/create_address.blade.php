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
<script>
  $(document).ready(function() {
    $('#city_id').change(function() {
      var cityId = $(this).val();

      // Make an AJAX request to fetch districts for the selected city
      $.ajax({
        url: '/cities/districts/' + cityId,
        type: 'GET',
        success: function(data) {
          // Populate the district dropdown with the received data
          var options = '<option value="">Select District</option>';

          $.each(data, function(index, district) {
            var districtName = district.translations.length > 0 ? district.translations[0].name : district.name;
            options += '<option value="' + district.id + '">' + districtName + '</option>';
          });
          $('#district_id').html(options);
        },
        error: function(response) {
          console.error('Error fetching districts:', response);
        }
      });
    });
  });
</script>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Add New Address</h4>
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

    <form method="post" action="{{ route('order.address.store', ['orderId' => $orderId]) }}" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label for="up_country_id">City </label>
        <select name="city_id" class="form-control" id="city_id">
          @foreach($cities as $city)
          <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
        <span class="text-danger error-message" id="error_city_id"></span>
      </div>

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

      <button type="submit" class="btn btn-primary">Add Address</button>
    </form>
  </div>
</div>
</div>
@endsection
