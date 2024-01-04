<!-- create.blade.php -->

@extends('layouts.layoutMaster')

@section('title', 'Update Offer')

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
        <h4 class="card-title">Update Offer</h4>
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
        <form method="post" action="{{ route('offers.update', $offer->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')


          <div class="mb-3">
            <label for="store_id" class="form-label">Store</label>
            <select class="form-control" id="store_id" name="store_id" required>
              <option>Select Store</option>
              @foreach ($stores as $store)
              <option value="{{ $store->id }}" {{ $store->id ==
                $offer->store_id ? 'selected' : '' }}>{{ $store->name }}</option>
              @endforeach
            </select>
          </div>


          <div class="mb-3">
            <label for="tier_id" class="form-label">Tier</label>
            <select class="form-control" id="tier_id" name="tier_id" required>
              <option>Select Tier</option>
              @foreach ($tiers as $tier)
              <option value="{{ $tier->id }}" {{ $tier->id ==
                $offer->tier_id ? 'selected' : '' }}>{{ $tier->name }}</option>
              @endforeach
            </select>
          </div>


          <div class="mb-3">
            <label for="name_en" class="form-label">Name (English) </label>
            <input type="text" value="{{ $offer->name }}" class="form-control" id="name_en" name="name_en" required>
          </div>

          <div class="mb-3">
            <label for="name_ar" class="form-label">Name (Arabic)</label>
            <input type="text" value="{{ $offer->translations->where("locale","ar")->first()->name }}"
            class="form-control" id="name_ar" name="name_ar" required>
          </div>

          <div class="mb-3">
            <label for="description_en" class="form-label">Descriprion (English)</label>
            <textarea name="description_en" class="form-control" required id="description_en"
              style="resize:none;">{{ $offer->translations->where("locale","en")->first()->description }}</textarea>
          </div>

          <div class="mb-3">
            <label for="description_en" class="form-label">Descriprion (Arabic)</label>
            <textarea name="description_ar" class="form-control" required id="description_ar"
              style="resize:none;">{{ $offer->translations->where("locale","ar")->first()->description }}</textarea>
          </div>

          <div class="mb-3">
            <label for="title_en" class="form-label">Title (English)</label>
            <textarea name="title_en" class="form-control" required id="title_en"
              style="resize:none;">{{ $offer->translations->where("locale","en")->first()->title }}</textarea>
          </div>

          <div class="mb-3">
            <label for="title_ar" class="form-label">Title (Arabic)</label>
            <textarea name="title_ar" class="form-control" required id="title_ar"
              style="resize:none;">{{ $offer->translations->where("locale","ar")->first()->title }}</textarea>
          </div>



      <!-- Price -->
      <div class="mb-3">
        <label for="discount_percentage">Discount Percenrtage</label>
        <input type="number" value="{{ $offer->discount_percentage }}"  name="discount_percentage" class="form-control" step="0.01" id="discount_percentage"
          required>
        <span class="text-danger error-message" id="error_discount_percentage"></span>
      </div>


      <!-- Price -->
      <div class="mb-3">
        <label for="min_price">Minimum Price</label>
        <input type="number" name="min_price"  value="{{ $offer->min_price }}" class="form-control" step="0.01" id="min_price" required>
        <span class="text-danger error-message" id="error_min_price"></span>
      </div>


      <!-- Save Up Price -->
      <div class="mb-3">
        <label for="saveup_price">SaveUp Price</label>
        <input type="number" name="saveup_price" class="form-control" value="{{ $offer->saveup_price }}" step="0.01" id="saveup_price" required>
        <span class="text-danger error-message" id="error_saveup_price"></span>
      </div>


      <div class="mb-3">
        <label for="order_counts">Order Counts </label>
        <input type="number" name="order_counts" class="form-control" value="{{ $offer->order_counts }}" step="0.01" id="order_counts" required>
        <span class="text-danger error-message" id="error_order_counts"></span>
      </div>

      <div class="mb-3">
        <label for="required_points">Required Points </label>
        <input type="number" name="required_points" class="form-control"  value="{{ $offer->required_points }}" step="0.01" id="required_points" required>
        <span class="text-danger error-message" id="error_required_points"></span>
      </div>

      <div class="mb-3">
        <label for="earned_points">Earned Points </label>
        <input type="number" name="earned_points" class="form-control"  value="{{ $offer->earned_points }}" step="0.01" id="earned_points" required>
        <span class="text-danger error-message" id="error_earned_points"></span>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="featured" name="featured" value="1" {{ $offer->free_delivery ? 'checked' : '' }}>
        <label class="form-check-label" for="featured">Free Delivery?</label>
      </div>

      <div class="mb-3">
        <label for="from_date" class="form-label">From Date</label>
        <input type="date" class="form-control" value="{{ $offer->from_date }}" id="from_date" name="from_date" value="{{ now()->format('Y-m-d') }}"
          required>
      </div>

      <div class="mb-3">
        <label for="from_date" class="form-label">To Date</label>
        <input type="date" class="form-control" id="to_date" value="{{ $offer->to_date }}" name="to_date" value="{{ now()->format('Y-m-d') }}"
          required>
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
                <img id="image-preview" src="{{ asset($offer->image) }}" alt="Store Image" style="max-width: 200px;">
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
            <button type="submit" class="btn btn-primary">Update Offer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
