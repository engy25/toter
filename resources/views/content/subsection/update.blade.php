<!-- create.blade.php -->

@extends('layouts.layoutMaster')

@section('title', 'Update Subsection')

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
    <h4 class="card-title">Update Subsection</h4>
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
    <form method="post" action="{{ route('subsections.update', $subsection->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="section_id" class="form-label">Section</label>
        <select class="form-control" id="section_id" name="section_id" required>
          <option>Select Section</option>
          @foreach ($sections as $section)
          <option value="{{ $section->id }}" {{ $section->id ==
            $subsection->section_id ? 'selected' : '' }}>{{ $section->name }}</option>
          @endforeach
        </select>
      </div>


      <div class="mb-3">
        <label for="name_en" class="form-label">Name (English) </label>
        <input type="text" value="{{ $subsection->translations->where("locale","en")->first()->name }}"
        class="form-control" id="name_en" name="name_en" required>
      </div>

      <div class="mb-3">
        <label for="name_ar" class="form-label">Name (Arabic)</label>
        <input type="text" value="{{ $subsection->translations->where("locale","ar")->first()->name }}"
        class="form-control" id="name_ar" name="name_ar" required>
      </div>

      <div class="mb-3">
        <label for="description_en" class="form-label">Descriprion (English)</label>
        <textarea name="description_en" class="form-control"  id="description_en"
          style="resize:none;">{{ $subsection->translations->where("locale","en")->first()->description }}</textarea>
      </div>

      <div class="mb-3">
        <label for="description_en" class="form-label">Descriprion (Arabic)</label>
        <textarea name="description_ar" class="form-control"  id="description_ar"
          style="resize:none;">{{ $subsection->translations->where("locale","ar")->first()->description }}</textarea>
      </div>





      <div class="row mb-3">
        <label class="col-md-2 form-label mb-4">Main Image:</label>
        <div class="col-md-10">
          <input name="image" id="demo" type="file" accept=".jpg, .png, image/jpeg, image/png" placeholder="Image">
          @error('image')
          <div>{{ $message }}</div>
          @enderror
          <br><br><br>
          @if($subsection->image)
          <div>
            <img id="image-preview" src="{{ asset($subsection->image) }}" alt="Store Image" style="max-width: 200px;">
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







      <br><br>
      <div class="text-center my-3">
        <button type="submit" class="btn btn-primary">Update Store</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>

@endsection
