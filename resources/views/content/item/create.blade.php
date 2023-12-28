@extends('layouts.layoutMaster')

@section('title', 'Create Item')

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
    <h4 class="card-title">Add New Item</h4>
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
    <form method="post" action="{{ route('items.store') }}" enctype="multipart/form-data">
      @csrf

      <!-- Name (English) -->
      <div class="mb-3">
        <label for="name_en" class="form-label">Name (English)</label>
        <input type="text" class="form-control" id="name_en" name="name_en" required>
      </div>

      <!-- Name (Arabic) -->
      <div class="mb-3">
        <label for="name_ar" class="form-label">Name (Arabic)</label>
        <input type="text" class="form-control" id="name_ar" name="name_ar" required>
      </div>

      <!-- Description (English) -->
      <div class="mb-3">
        <label for="description_en" class="form-label">Description (English)</label>
        <textarea type="text" class="form-control" id="description_en" name="description_en" style="resize:none;"
          required></textarea>
      </div>

      <!-- Description (Arabic) -->
      <div class="mb-3">
        <label for="description_ar" class="form-label">Description (Arabic)</label>
        <textarea type="text" class="form-control" id="description_ar" name="description_ar" style="resize:none;"
          required></textarea>
      </div>

      <!-- Price -->
      <div class="mb-3">
        <label for="price">Price</label>
        <input type="number" name="price" class="form-control" step="0.01" id="price">
        <span class="text-danger error-message" id="error_price"></span>
      </div>

      <!-- Added Value -->
      <div class="mb-3">
        <label for="added_value">Added Value</label>
        <input type="number" name="added_value" class="form-control" step="0.01" id="added_value">
        <span class="text-danger error-message" id="error_added_value"></span>
      </div>

      <!-- Is Restaurant? -->
      <div class="mb-3">
        <label for="restaurant_true" class="form-label">Is Restaurant?</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="restaurant_true" id="restaurant_true" value="1" checked>
          <label class="form-check-label" for="restaurant_true">True</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="restaurant_true" id="restaurant_false" value="0">
          <label class="form-check-label" for="restaurant_false">False</label>
        </div>
      </div>

      <!-- Store -->
      <div class="mb-3">
        <label for="store_id" class="form-label">Store</label>
        <select class="form-control" id="store_id" name="store_id" required>
          <option value="">Select Store</option>
          @foreach ($stores as $store)
          <option value="{{ $store->id }}">{{ $store->name }}</option>
          @endforeach
        </select>
      </div>

      <!-- Tag -->
      <div class="form-group">
        <label for="tag_id">Tag</label>
        <select name="tag_id" class="form-control" id="tag_id" required>
          <!-- Options will be dynamically populated here using JavaScript -->
        </select>
        <span class="text-danger error-message" id="error_tag_id"></span>
      </div><br>

      <!-- Gifts Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#giftsContainer" aria-expanded="true"
              aria-controls="giftsContainer">
              Gifts
            </button>
          </h5>
        </div>

        <div id="giftsContainer" class="collapse show">
          <div class="card-body">
            <!-- Existing store gifts (if any) will be added here dynamically -->
            <button type="button" class="btn btn-success" onclick="addStoreGift()">Add Gift</button>
          </div>
        </div>
      </div>


      <!-- Sizes Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#sizesContainer" aria-expanded="true"
              aria-controls="sizesContainer">
              Sizes
            </button>
          </h5>
        </div>

        <div id="sizesContainer" class="collapse show">
          <div class="card-body">
            <!-- Existing store sizes (if any) will be added here dynamically -->
            <button type="button" class="btn btn-success" onclick="addSize()">Add Size</button>
          </div>
        </div>
      </div>

      <!-- Ingredients Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#ingredientsContainer" aria-expanded="true"
              aria-controls="ingredientsContainer">
              Ingredients
            </button>
          </h5>
        </div>

        <div id="ingredientsContainer" class="collapse show">
          <div class="card-body">
            <!-- Existing store ingredients (if any) will be added here dynamically -->
            <button type="button" class="btn btn-success" onclick="addIngredient()">Add Ingredient</button>
          </div>
        </div>
      </div>

      <!-- Add Services Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#servicesContainer" aria-expanded="true"
              aria-controls="servicesContainer">
              Add Services
            </button>
          </h5>
        </div>

        <div id="servicesContainer" class="collapse show">
          <div class="card-body">
            <!-- Existing store Add Ingredients (if any) will be added here dynamically -->
            <button type="button" class="btn btn-success" onclick="addSerivice()">Add Service</button>
          </div>
        </div>
      </div>

      <!-- Add Preference Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#preferencesContainer" aria-expanded="true"
              aria-controls="preferencesContainer">
              Add Preference
            </button>
          </h5>
        </div>

        <div id="preferencesContainer" class="collapse show">
          <div class="card-body">
            <!-- Existing store Add Ingredients (if any) will be added here dynamically -->
            <button type="button" class="btn btn-success" onclick="addPreference()">Add Preference</button>
          </div>
        </div>
      </div>

      <!-- Add Option Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#optionsContainer" aria-expanded="true"
              aria-controls="optionsContainer">
              Add Option
            </button>
          </h5>
        </div>

        <div id="optionsContainer" class="collapse show">
          <div class="card-body">
            <!-- Existing store Add Ingredients (if any) will be added here dynamically -->
            <button type="button" class="btn btn-success" onclick="addOption()">Add Option</button>
          </div>
        </div>
      </div>

      <!-- Add Side Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#sidesContainer" aria-expanded="true"
              aria-controls="sidesContainer">
              Add Side
            </button>
          </h5>
        </div>

        <div id="sidesContainer" class="collapse show">
          <div class="card-body">
            <!-- Existing store Add Ingredients (if any) will be added here dynamically -->
            <button type="button" class="btn btn-success" onclick="addSide()">Add Side</button>
          </div>
        </div>
      </div>
      <!-- Drinks Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#drinksContainer" aria-expanded="true"
              aria-controls="drinksContainer">
              Drinks
            </button>
          </h5>
        </div>

        <div id="drinksContainer" class="collapse show">
          <div class="card-body">
            <div class="form-group">
              <label for="drinks">Drinks</label>
              <select name="drinks[]" class="form-control" id="drinks" multiple="multiple">
                <!-- Options will be dynamically populated here using JavaScript -->
              </select>
              <span class="text-danger error-message" id="error_drinks"></span>
              <br>
            </div>
          </div>
        </div>
      </div>

      <!-- Addons Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#addonsContainer" aria-expanded="true"
              aria-controls="addonsContainer">
              Addons
            </button>
          </h5>
        </div>

        <div id="addonsContainer" class="collapse show">
          <div class="card-body">
            <div class="form-group">
              <label for="addons">Addons</label>
              <select name="addons[]" class="form-control" id="addons" multiple="multiple">
                <!-- Options will be dynamically populated here using JavaScript -->
              </select>
              <span class="text-danger error-message" id="error_addons"></span>
              <br>
            </div>
          </div>
        </div>
      </div>


      <!-- Main Image Section -->
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#mainImageContainer" aria-expanded="true"
              aria-controls="mainImageContainer">
              Main Image
            </button>
          </h5>
        </div>

        <div id="mainImageContainer" class="collapse show">
          <div class="card-body">
            <div class="row mb-3">
              <label class="col-md-2 form-label mb-4">Choose Image:</label>
              <div class="col-md-10">
                <input required name="image" id="demo" type="file" accept=".jpg, .png, image/jpeg, image/png"
                  placeholder="Image" onchange="previewImage(event)">
                <br><br><br>
                <img id="preview" style="display:none">
                @error('image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
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
                reader.onload = function() {
                  var dataURL = reader.result;
                  var img = document.getElementById('preview');
                  img.src = dataURL;
                  img.style.display = 'block';
                  img.style.maxWidth = '200px'; // Set a maximum width of 200 pixels for the image
                };
                reader.readAsDataURL(input.files[0]);
              }
      </script>

      <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
  </div>
</div>
</div>
</div>
@include('content.item.item_js')
@endsection
