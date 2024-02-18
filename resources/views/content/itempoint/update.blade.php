<!-- create.blade.php -->

@extends('layouts.layoutMaster')

@section('title', 'Update Item')

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
        <h4 class="card-title">Update Item</h4>
      </div>
      <div class="card-body">

        <form method="post" action="{{ route('itempoints.update', $item->id) }}" enctype="multipart/form-data">
          @csrf

          @method('PUT')

          <div class="mb-3">
            <label for="upname_en" class="form-label">Name (English) </label>
            <input type="text" value="{{ $item->name }}" class="form-control" id="upname_en" name="upname_en" required>
            @error('upname_en')
            <div class="alert alert-danger" role="alert">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="upname_ar" class="form-label">Name (Arabic)</label>
            <input type="text" value="{{ $item->translations->where("locale","ar")->first()->name }}"
            class="form-control" id="upname_ar" name="upname_ar" required>
            @error('upname_ar')
            <div class="alert alert-danger" role="alert">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="updescription_en" class="form-label">Descriprion (English)</label>
            <textarea name="updescription_en" class="form-control" required id="updescription_en"
              style="resize:none;">{{ $item->translations->where("locale","en")->first()->description }}</textarea>
            @error('updescription_en')
            <div class="alert alert-danger" role="alert">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="updescription_ar" class="form-label">Descriprion (Arabic)</label>
            <textarea name="updescription_ar" class="form-control" required id="updescription_ar"
              style="resize:none;">{{ $item->translations->where("locale","ar")->first()->description }}</textarea>
            @error('updescription_ar')
            <div class="alert alert-danger" role="alert">
              {{ $message }}
            </div>
            @enderror
          </div>




          <div class="mb-3">
            <label for="point">Point</label>
            <input type="number" name="point" value="{{ $item->points }}" class="form-control"
              id="point">
            @error('point')
            <div class="alert alert-danger" role="alert">
              {{ $message }}
            </div>
            @enderror
          </div>




          <div class="row mb-3">
            <label class="col-md-2 form-label mb-4">Main Image:</label>
            <div class="col-md-10">
              <input name="upimage" id="demo"  type="file" accept=".jpg, .png, image/jpeg, image/png" placeholder="Image">
              @error('upimage')
              <div class="alert alert-danger" role="alert">
                {{ $message }}
              </div>
              @enderror
              <br><br><br>
              @if($item->image)
              <div>
                <img id="image-preview" src="{{ asset($item->image) }}" alt="Store Image" style="max-width: 200px;">
              </div>
              @else
              <div>
                <img id="image-preview" alt="Item Image" style="display: none; max-width: 200px;">
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
            <button type="submit" class="btn btn-primary">Update Item</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
