<!-- create.blade.php -->

@extends('layouts.layoutMaster')

@section('title', 'Create Delivery')

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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
  // Add schedule dynamically
  $('#add-schedule').on('click', function () {
      var template = $('#schedule-template').clone();
      template.removeAttr('id').show();
      $('#schedule-container').append(template);
  });

  // Remove schedule
  $('#schedule-container').on('click', '.remove-schedule', function () {
      $(this).closest('.card').remove();
  });
</script>

@endsection


@section('content')

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Add New Delivery</h4>
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
    <form method="post" action="{{ route('deliveries.store') }}" enctype="multipart/form-data">
      @csrf


      <div class="mb-3">
        <label for="fname" class="form-label">First Name </label>
        <input type="text" class="form-control" id="fname" name="fname" required>
      </div>

      <div class="mb-3">
        <label for="lname" class="form-label">Last Name </label>
        <input type="text" class="form-control" id="lname" name="lname" required>
      </div>


      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <div class="input-group">
          <select class="form-control" id="country" name="country" style="max-width: 70px;">
            @foreach($countries as $country)
            <option value="{{ $country->country_code }}">{{ $country->country_code }}</option>
            @endforeach
          </select>
          <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
      </div>


      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" name="password" required>
          <button class="btn btn-outline-secondary" type="button" id="toggle-password"></button>
        </div>
      </div>

      <!-- Add Week hours Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#deliveriesContainer" aria-expanded="true"
              aria-controls="deliveriesContainer">
              Add WeekHours
            </button>
          </h5>
        </div>

        <div id="deliveriesContainer" class="collapse show">
          <div class="card-body">
            <!-- Existing store Add Ingredients (if any) will be added here dynamically -->
            <button type="button" class="btn btn-success" onclick="addDelivery()">Add WeekHours</button>
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-md-2 form-label mb-4">Main Image:</label>
        <div class="col-md-10">
          <input name="image" id="demo" type="file" accept=".jpg, .png, image/jpeg, image/png" placeholder="Image"
            onchange="previewImage(event)">
          <br><br><br>
          <img id="preview" style="display:none">
          @error('image')
          <div>{{ $message }}</div>
          @enderror
        </div>
      </div>


      <script>
        $(document).ready(function() {
var fileInput = $('#demo');
var previewImage = $('#preview-image');

// Listen for changes to the file input field
fileInput.on('change', function() {
  // Get the selected file
  var file = fileInput.get(0).files[0];

  // Create a new FileReader object
  var reader = new FileReader();

  // Set the image source when the file is loaded
  reader.onload = function(event) {
    previewImage.attr('src', event.target.result);
  };

  // Read the selected file as a data URL
  reader.readAsDataURL(file);
});
});

function previewImage(event) {
var input = event.target;
var reader = new FileReader();
reader.onload = function(){
    var dataURL = reader.result;
    var img = document.getElementById('preview');
    img.src = dataURL;
    img.style.display = 'block';
    img.style.maxWidth = '200px'; // Set a maximum width of 200 pixels for the image
};
reader.readAsDataURL(input.files[0]);
}
      </script>





      <button type="submit" class="btn btn-primary">Add Delivery</button>
    </form>
  </div>
</div>
</div>
</div>
@include('content.delivery.delivery_schedule_js')
@endsection
