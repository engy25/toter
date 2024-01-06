<!-- create.blade.php -->

@extends('layouts.layoutMaster')

@section('title', 'Create Offer')

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
    <h4 class="card-title">Add New Offer</h4>
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
    <form method="post" action="{{ route('offers.store') }}" enctype="multipart/form-data">
      @csrf



      <div class="mb-3">
        <label for="store_id" class="form-label">Store</label>
        <select class="form-control" id="store_id" name="store_id" required>
          <option>Select Store</option>
          @foreach ($stores as $store)
          <option value="{{ $store->id }}">{{ $store->name }}</option>
          @endforeach
        </select>
      </div>



      <div class="mb-3">
        <label for="tier_id" class="form-label">Tier</label>
        <select class="form-control" id="tier_id" name="tier_id" required>
          <option>Select Tier</option>
          @foreach ($tiers as $tier)
          <option value="{{ $tier->id }}">{{ $tier->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label for="name_en" class="form-label">Name (English) </label>
        <input type="text" class="form-control" id="name_en" name="name_en" required>
      </div>

      <div class="mb-3">
        <label for="name_ar" class="form-label">Name (Arabic)</label>
        <input type="text" class="form-control" id="name_ar" name="name_ar" required>
      </div>

      <div class="mb-3">
        <label for="description_en" class="form-label">Descriprion (English)</label>
        <textarea type="text" class="form-control" id="description_en" name="description_en" style="resize:none;"
          required></textarea>
      </div>

      <div class="mb-3">
        <label for="description_ar" class="form-label">Descriprion (Arabic)</label>
        <textarea type="text" class="form-control" id="description_ar" name="description_ar" style="resize:none;"
          required></textarea>
      </div>
      <br>

      <div class="mb-3">
        <label for="title_en" class="form-label">Title (English)</label>
        <textarea type="text" class="form-control" id="title_en" name="title_en" style="resize:none;"></textarea>
      </div>

      <div class="mb-3">
        <label for="title_ar" class="form-label">Title (Arabic)</label>
        <textarea type="text" class="form-control" id="title_ar" name="title_ar" style="resize:none;"></textarea>
      </div>
      <br>


      <!-- Price -->
      <div class="mb-3">
        <label for="discount_percentage">Discount Percenrtage</label>
        <input type="number" name="discount_percentage" class="form-control" step="0.01" id="discount_percentage"
          required>
        <span class="text-danger error-message" id="error_discount_percentage"></span>
      </div>


      <!-- Price -->
      <div class="mb-3">
        <label for="min_price">Minimum Price</label>
        <input type="number" name="min_price" class="form-control" step="0.01" id="min_price" required>
        <span class="text-danger error-message" id="error_min_price"></span>
      </div>


      <!-- Save Up Price -->
      <div class="mb-3">
        <label for="saveup_price">SaveUp Price</label>
        <input type="number" name="saveup_price" class="form-control" step="0.01" id="saveup_price" required>
        <span class="text-danger error-message" id="error_saveup_price"></span>
      </div>


      <div class="mb-3">
        <label for="order_counts">Order Counts </label>
        <input type="number" name="order_counts" class="form-control" step="0.01" id="order_counts" required>
        <span class="text-danger error-message" id="error_order_counts"></span>
      </div>

      <div class="mb-3">
        <label for="required_points">Required Points </label>
        <input type="number" name="required_points" class="form-control" step="0.01" id="required_points" required>
        <span class="text-danger error-message" id="error_required_points"></span>
      </div>

      <div class="mb-3">
        <label for="earned_points">Earned Points </label>
        <input type="number" name="earned_points" class="form-control" step="0.01" id="earned_points" required>
        <span class="text-danger error-message" id="error_earned_points"></span>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="featured" name="featured" value="1">
        <label class="form-check-label" for="featured">Free Delivery?</label>
      </div>

      <div class="mb-3">
        <label for="from_date" class="form-label">From Date</label>
        <input type="date" class="form-control" id="from_date" name="from_date" value="{{ now()->format('Y-m-d') }}"
          required>
      </div>

      <div class="mb-3">
        <label for="from_date" class="form-label">To Date</label>
        <input type="date" class="form-control" id="to_date" name="to_date" value="{{ now()->format('Y-m-d') }}"
          required>
      </div>


      <div class="row mb-3">
        <label class="col-md-2 form-label mb-4">Main Image:</label>
        <div class="col-md-10">
          <input required name="image" id="demo" type="file" accept=".jpg, .png, image/jpeg, image/png"
            placeholder="Image" onchange="previewImage(event)">
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





      <button type="submit" class="btn btn-primary">Add Offer</button>
    </form>
  </div>
</div>
</div>
</div>

@endsection
