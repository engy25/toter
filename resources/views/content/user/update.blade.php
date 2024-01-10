<!-- create.blade.php -->

@extends('layouts.layoutMaster')

@section('title', 'Update Delivery')

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
    <h4 class="card-title">Update Delivery</h4>
  </div>
  <div class="card-body">

    <form method="post" action="{{ route('deliveries.update', $delivery->id) }}" enctype="multipart/form-data">
      @csrf

      @method('PUT')

      <div class="mb-3">
        <label for="fname" class="form-label">First Name </label>
        <input type="text" value="{{ $delivery->fname }}" class="form-control" id="fname" name="fname" required>
        @error('fname')
        <div class="alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="lname" class="form-label">Last Name </label>
        <input type="text" value="{{ $delivery->lname  }}" class="form-control" id="lname" name="lname" required>
        @error('lname')
        <div class="alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" value="{{ $delivery->email  }}" class="form-control" name="email" required>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <div class="input-group">
          <select class="form-control" id="country" name="country" style="max-width: 70px;">
            @foreach($countries as $country)

            <option value="{{ $country->country_code }}" {{ $country->country_code ==
              $delivery->country_code ? 'selected' : '' }}>{{ $country->country_code }}</option>
            @endforeach
          </select>
          <input type="text" class="form-control" id="phone" value="{{ $delivery->phone  }}" name="phone" required>
        </div>
      </div>


      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" name="password" >
          <button class="btn btn-outline-secondary" type="button" id="toggle-password"></button>
        </div>
      </div>


      <div class="row mb-3">
        <label class="col-md-2 form-label mb-4">Main Image:</label>
        <div class="col-md-10">
          <input name="upimage" id="demo" type="file" accept=".jpg, .png, image/jpeg, image/png" placeholder="Image">
          @error('upimage')
          <div class="alert alert-danger" role="alert">
            {{ $message }}
          </div>
          @enderror
          <br><br><br>
          @if($delivery->image)
          <div>
            <img id="image-preview" src="{{ asset($delivery->image) }}" alt="Store Image" style="max-width: 200px;">
          </div>
          @else
          <div>
            <img id="image-preview" alt="Delivery Image" style="display: none; max-width: 200px;">
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
        <button type="submit" class="btn btn-primary">Update Delivery</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>

@endsection
