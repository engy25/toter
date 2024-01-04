@extends('layouts/layoutMaster')

@section('title', 'Offer')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('page-script')
<script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>
{{-- <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script> --}}
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
@endsection

@section('content')

<div class="card invoice-preview-card">
  <div class="card-body">
        <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
          <div class="mb-xl-0 mb-4">
            <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
              <img src="{{ asset($offer->image) }}" alt="Offer Image" style="height: 60% ; width:60%" class="img-fluid">
              <span class="app-brand-text fw-bold fs-4">
                {{ $offer->name }}
              </span>
            </div>
            <h4 class="mb-2">{{ $offer->description }}</h4>
          </div>

          @if($offer->store)
          <div class="text-center">
            <a href="{{ route('stores.show', $offer->store->id) }}" class="btn btn-primary">Go to Store</a>
          </div>
          @else
          <div class="text-center">
            <p>No Store available for this Offer.</p>
          </div>
          @endif

          <div style="max-width:20 ">
            <br>
          </div>
        </div>
      </div>

      <hr class="my-0" />
      <div class="card-body">
        <div class="row p-sm-3 p-0">
          <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
            <h4 class="mb-1">Title:</h4>
            <h6 class="mb-3">{{ $offer->title }}</h6>
            <h4 class="mb-1">Discount Percentage:</h4>
            <h6 class="mb-3">{{ $offer->discount_percentage}}</h6>
            <h4 class="mb-1">order count:</h4>
            <h6 class="mb-3">{{ $offer->order_counts }}</h6>
            <h4 class="mb-1">SubSection Name:</h4>
            <h6 class="mb-3">{{ $offer->subsection->name}}</h6>
            <h4 class="mb-1">Minimum Price:</h4>
            <h6 class="mb-3">{{ $offer->min_price}}</h6>
            <h4 class="mb-1">SaveUp Price:</h4>
            <h6 class="mb-3">{{ $offer->saveup_price}}</h6>
            <h4 class="mb-1">Earned Points:</h4>
            <h6 class="mb-3">{{ $offer->earned_points}}</h6>
            <h4 class="mb-1">Required Points:</h4>
            <h6 class="mb-3">{{ $offer->required_points}}</h6>
            <h4 class="mb-1">Required Tier:</h4>
            <h6 class="mb-3">{{ $offer->tier->name}}</h6>
            <h4 class="mb-1">Is Free Delivery</h4>
            @if($offer->free_delivery==1)
            <h6 class="mb-3">True</h6>
            @else
            <h6 class="mb-3">False</h6>
            @endif

            {{-- @if($store->pointstore)
            <h4 class="mb-1">Point Store:</h4>
            <h6>
              {{ "This store earned " . $store->pointstore->points_earned . " points after you make " .
              $store->pointstore->order_counts . " orders." ."and the minimum price of the total of orders is
              ".$store->pointstore->min_price ." this points must make in ".$store->pointstore->expire_days." days" }}
            </h6> --}}
{{--
            @endif --}}
          </div>



        </div>
      </div>

      <div class="card-body mx-3">
        <div class="row">
          <div class="col-12">
          </div>
        </div>
      </div>

      <!-- Add the link to the items page -->
      <div class="card-footer">
        <div class="text-center">

          <a href="{{ route('offer.items', ['store_id' => $offer->store->id]) }}" class="btn btn-primary">View Items That Belongs Offer</a>
        </div>
      </div>
    </div>
  </div>
  <!-- /Invoice -->
  <!-- /Invoice -->

  <!-- /Offcanvas -->
</div>
@endsection
