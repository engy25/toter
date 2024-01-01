<!-- create.blade.php -->

@extends('layouts.layoutMaster')

@section('title', 'Update Store')

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
<script>
  $(document).ready(function() {
      // Get the existing sub_section_id value from your view (replace 'existingValue' with the actual variable)
      var existingSubSectionId = {{ $store->sub_section_id ?? null }};

      // Trigger the change event when the document is ready to populate the subsection dropdown initially
      $('#section_id').change();

      // Set the data-existing-value attribute on the sub_section_id dropdown
      $('#sub_section_id').data('existing-value', existingSubSectionId);

      // Set the selected attribute for the existingSubSectionId in the subsection dropdown
      $('#sub_section_id').val(existingSubSectionId).change();

      $('#section_id').change(function() {
          var sectionId = $(this).val();

          // Make an AJAX request to fetch subsections for the selected section
          $.ajax({
              url: '/getSubSections/' + sectionId,
              type: 'GET',
              success: function(data) {
                  // Populate the subsection dropdown with the received data
                  var options = '<option value="">Select Subsection</option>';

                  $.each(data, function(index, subSection) {
                      var subsectionName = subSection.translations ? subSection.translations[0].name : subSection.name;
                      options += '<option value="' + subSection.id + '">' + subsectionName + '</option>';
                  });
                  $('#sub_section_id').html(options);

                  // Set the selected attribute based on the data-existing-value attribute
                  var existingValue = $('#sub_section_id').data('existing-value');
                  $('#sub_section_id').val(existingValue).change();
              },
              error: function(response) {
                  console.error('Error fetching subsections:', response);
              }
          });
      });
  });

  $(document).ready(function() {
  // Get the existing sub_section_id value from your view (replace 'existingValue' with the actual variable)
  var existingSubSectionId = {{ $store->sub_section_id ?? null }};

  // Trigger the change event when the document is ready to populate the subsection dropdown initially
  $('#section_id').change();

  // Set the data-existing-value attribute on the sub_section_id dropdown
  $('#sub_section_id').data('existing-value', existingSubSectionId);

  // Set the selected attribute for the existingSubSectionId in the subsection dropdown
  $('#sub_section_id').val(existingSubSectionId).change();
  // console.log($('#sub_section_id').val())

  $('#section_id').change(function() {
      var sectionId = $(this).val();
      // console.log(sectionId);

      $.ajax({
    url: '/getSubSections/' + sectionId,
    type: 'GET',
    success: function(data) {

        var options ='<option value="">Select Subsection</option>';
        $.each(data, function(index, subSection) {
            var subsectionName = subSection.translations ? subSection.translations[0].name : subSection.name;

            var selected = subSection.id === existingSubSectionId ? 'selected' : '';


            options += '<option value="' + subSection.id + '" ' + selected + '>' + subsectionName + '</option>';
        });

         console.log(options);
        $('#sub_section_id').html(options);
    },
    error: function(response) {
        console.error('Error fetching subsections:', response);
    }
  });
    });
});

</script>



@endsection


@section('content')

    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Update Store</h4>
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
        <form method="post" action="{{ route('stores.update', $store->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="name_en" class="form-label">Name (English) </label>
            <input type="text" value="{{ $store->name }}" class="form-control" id="name_en" name="name_en" required>
          </div>

          <div class="mb-3">
            <label for="name_ar" class="form-label">Name (Arabic)</label>
            <input type="text" value="{{ $store->translations->where("locale","ar")->first()->name }}"
            class="form-control" id="name_ar" name="name_ar" required>
          </div>

          <div class="mb-3">
            <label for="description_en" class="form-label">Descriprion (English)</label>
            <textarea name="description_en" class="form-control" required id="description_en"
              style="resize:none;">{{ $store->translations->where("locale","en")->first()->description }}</textarea>
          </div>

          <div class="mb-3">
            <label for="description_en" class="form-label">Descriprion (Arabic)</label>
            <textarea name="description_ar" class="form-control" required id="description_ar"
              style="resize:none;">{{ $store->translations->where("locale","ar")->first()->description }}</textarea>
          </div>




          <div class="mb-3">
            <label for="address" class="form-label">Address </label>
            <textarea name="address" class="form-control" required id="address"
              style="resize:none;">{{ $store->address }}</textarea>
          </div>

          <div class="mb-3">
            <label for="delivery_time" class="form-label">Delivery Time</label>
            <input type="text" class="form-control" value="{{ $store->delivery_time }}" id="delivery_time"
              name="delivery_time" required>
          </div>

          <div class="row mb-3">
            <label class="col-md-2 form-label mb-4">Main Image:</label>
            <div class="col-md-10">
              <input name="image" id="demo" type="file" accept=".jpg, .png, image/jpeg, image/png" placeholder="Image">
              @error('image')
              <div>{{ $message }}</div>
              @enderror
              <br><br><br>
              @if($store->image)
              <div>
                <img id="image-preview" src="{{ asset($store->image) }}" alt="Store Image" style="max-width: 200px;">
              </div>
              @else
              <div>
                <img id="image-preview" alt="Store Image" style="display: none; max-width: 200px;">
              </div>
              @endif
            </div>
          </div>


          <script>
            const input = document.getElementById('demo');
    const preview = document.getElementById('image-preview');

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', () => {
                preview.src = reader.result;
                preview.style.display = 'block';
                preview.style.maxWidth = '200px'; // Set a maximum width of 200 pixels for the image
            });
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });

          </script>

          <div class="mb-3">
            <label for="section_id" class="form-label">Section</label>
            <select class="form-control" id="section_id" name="section_id" required>
              <option>Select Section</option>
              @foreach ($sections as $section)
              <option value="{{ $section->id }}" {{ $section->id ==
                $store->section_id ? 'selected' : '' }}>{{ $section->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="sub_section_id" class="form-label">Subsection</label>
            <select class="form-control" id="sub_section_id" name="sub_section_id" required>
              <!-- Options will be dynamically populated using JavaScript -->
            </select>
          </div>





          <br><br>
          <div class="text-center my-3">
            <button type="submit" class="btn btn-primary">Update Store</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@include('content.store.store_js')
@endsection
