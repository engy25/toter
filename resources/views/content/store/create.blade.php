<!-- create.blade.php -->

@extends('layouts.layoutMaster')

@section('title', 'Create Store')

@section('vendor-style')
<!-- Include your vendor styles here -->
@endsection

@section('page-style')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDiA82v-YbjjXlbJ_wjJUfS902W446uCMU&callback=initMap"
    defer></script>
<script src="/js/mapInput.js"></script>
@endsection

@section('vendor-script')
<!-- Include your vendor scripts here -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  function addDistrict() {
    const container = document.getElementById('districtsContainer');

    // Create a new district div
    const districtDiv = document.createElement('div');
    districtDiv.className = 'district mb-3';

    // City select

    const citySelect = document.createElement('select');
    citySelect.className = 'form-control';
    citySelect.name = 'city_id[]';

    // Fetch cities from the server
    fetchCities(function (cities) {
      // Populate city options
      cities.forEach(function (city) {
        const option = document.createElement('option');
        option.value = city.id;
        option.textContent = city.translations[0].name;
        citySelect.appendChild(option);
      });

      // Now that the city select is populated, fetch districts
      loadDistricts(citySelect);

      // Set up an event listener to load districts when the city select changes
      citySelect.addEventListener('change', function () {
        loadDistricts(citySelect);
      });
    });

    districtDiv.appendChild(citySelect);

    // District select
    const districtSelect = document.createElement('select');
    districtSelect.className = 'form-control';
    districtSelect.name = 'district_id[]';
    // You can leave this empty or fetch districts dynamically based on the selected city if needed

    districtDiv.appendChild(districtSelect);

    // Delivery fees input
    const deliveryFeesInput = document.createElement('input');
    deliveryFeesInput.type = 'text';
    deliveryFeesInput.className = 'form-control';
    deliveryFeesInput.name = 'delivery_fees[]';
    deliveryFeesInput.placeholder = 'Delivery Fees';
    districtDiv.appendChild(deliveryFeesInput);

    // Remove button
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remove District';
    removeButton.onclick = function () {
      container.removeChild(districtDiv);
    };
    districtDiv.appendChild(removeButton);

    // Append the new district div to the container
    container.appendChild(districtDiv);
  }

  function fetchCities(callback) {
    // Make an Ajax request to fetch cities from the server
    $.ajax({
      url: '/get-cities', // Replace with your actual endpoint
      method: 'GET',
      success: function (data) {
        callback(data);
      },
      error: function (error) {
        console.error('Error fetching cities:', error);
      },
    });
  }

  function fetchDistricts(cityId, callback) {
  // Make an Ajax request to fetch districts from the server based on the selected city
  $.ajax({
    url: '/cities/districts/' + cityId,
    method: 'GET',
    success: function (data) {
      callback(data);
    },
    error: function (error) {
      console.error('Error fetching districts:', error);
    },
  });
}


function loadDistricts(citySelect) {

  const cityId = citySelect.value;
  const districtSelect = citySelect.parentElement.querySelector('[name="district_id[]"]');
  const container = document.getElementById('districtsContainer');


  // Clear existing district options
  districtSelect.innerHTML = '';


  // Call the fetchDistricts function to fetch districts based on the selected city
  fetchDistricts(cityId, function (districts) {
    // Dynamically populate districts
    districts.forEach(function (district) {
      const option = document.createElement('option');
      option.value = district.id;
      option.textContent = district.translations[0].name;
      districtSelect.appendChild(option); // Append options to the districtSelect element
    });
  });
}







  // Declare the function at the global scope
  function addStoreCategory() {
    const container = document.getElementById('storeCategoriesContainer');
    let categoryId = 1;

    // Create a new category div
    const categoryDiv = document.createElement('div');
    categoryDiv.className = 'category mb-3';

    // Function to create input elements
    function createInput(type, name, placeholder) {
      const input = document.createElement('input');
      input.type = type;
      input.className = 'form-control';
      input.name = name;
      input.placeholder = placeholder;
      return input;
    }

    // Category Name (English)
    categoryDiv.appendChild(createInput('text', `store_categories[${categoryId}][name_en]`, 'Category Name (English)'));

    // Add a line break after the "Name (English)" input field
    categoryDiv.appendChild(document.createElement('br'));

     // Category Name (English)
    categoryDiv.appendChild(createInput('text', `store_categories[${categoryId}][name_ar]`, 'Category Name (Arabic)'));
    categoryDiv.appendChild(document.createElement('br'));
  // Category Name (English)
    categoryDiv.appendChild(createInput('text', `store_categories[${categoryId}][description_en]`, 'Description Name (English)'));

    categoryDiv.appendChild(document.createElement('br'));

    categoryDiv.appendChild(createInput('text', `store_categories[${categoryId}][description_ar]`, 'Description Name (Arabic)'));

    categoryDiv.appendChild(document.createElement('br'));
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remove Category';
    removeButton.onclick = function () {
    container.removeChild(categoryDiv);
    };

    categoryDiv.appendChild(removeButton);

    // Append the new category div to the container
    container.appendChild(categoryDiv);
    categoryId++; // Increment the unique identifier for the next category
  }

  document.addEventListener('DOMContentLoaded', function () {
    // Loop through each time input field and initialize Flatpickr
    for (let i = 1; i <= 7; i++) {
      flatpickr(`#from_time${i}`, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
      });

      flatpickr(`#to_time${i}`, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
      });
    }





  });
</script>
@endsection


@section('content')

    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Add New Store</h4>
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
        <form method="post" action="{{ route('stores.store') }}" enctype="multipart/form-data">
          @csrf

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
            <label for="section_id" class="form-label">Section</label>
            <select class="form-control" id="section_id" name="section_id" required>
              <option>Select Section</option>
              @foreach ($sections as $section)
              <option value="{{ $section->id }}">{{ $section->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="sub_section_id" class="form-label">Subsection</label>
            <select class="form-control" id="sub_section_id" name="sub_section_id" required>
              <!-- Options will be dynamically populated using JavaScript -->
            </select>
          </div>


          <div class="mb-3">
            <label for="delivery_time" class="form-label">Delivery Time</label>
            <input type="text" class="form-control" id="delivery_time" name="delivery_time" required>
          </div>


          <h5 class="my-3">Tags</h5>

          <div id="storeCategoriesContainer">
            <!-- Existing store categories (if any) will be added here dynamically -->
          </div>

          <div class="mb-3">
            <button type="button" class="btn btn-success" onclick="addStoreCategory()">Add Category</button>
          </div>


          <h5 class="my-3">Week Hours</h5>

          @for($i = 1; $i <= 7; $i++) <div class="mb-3">
            <label for="day{{ $i }}" class="form-label">Day {{ $i }}</label>
            <select class="form-control" id="day{{ $i }}" name="weekhours[{{ $i }}][day_id]" required>
              <option>Select Day</option>
              @foreach ($days as $day)
              <option value="{{ $day->id }}">{{ $day->name }}</option>
              @endforeach
            </select>
      </div>

      <div class="mb-3">
        <label for="from_time{{ $i }}" class="form-label">From Time</label>
        <input type="text" class="form-control" id="from_time{{ $i }}" name="weekhours[{{ $i }}][from_time]" required>
      </div>

      <div class="mb-3">
        <label for="to_time{{ $i }}" class="form-label">To Time</label>
        <input type="text" class="form-control" id="to_time{{ $i }}" name="weekhours[{{ $i }}][to_time]" required>
      </div>

      @endfor

      <h5 class="my-3">Cities</h5>
      <div id="districtsContainer">
        <!-- Districts and delivery fees will be added here dynamically -->
      </div>
      <button type="button" class="btn btn-success" onclick="addDistrict()">Add District</button>


      <br><br>


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
      <br>




      <div  class="mb-3">
        <label for="address_address">Address</label>
        <textarea type="text" name="address"  id="address" name="address_address" class="form-control map-input" style="resize:none;" required> </textarea>
        <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
        <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
    </div>
    <div id="address-map-container" style="width:100%;height:400px; ">
        <div style="width: 100%; height: 100%" id="address-map"></div>
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










      <button type="submit" class="btn btn-primary">Add New Store</button>
      </form>
    </div>
  </div>
</div>
</div>
@include('content.store.store_js')
@endsection
