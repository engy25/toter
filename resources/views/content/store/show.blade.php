@extends('layouts/layoutMaster')

@section('title', 'Store')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('page-script')
<script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>


@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
@endsection

@section('content')
<div class="row justify-content-center">

  <!-- Invoice -->
  <div class="col-xl-10 col-md-10 col-14 mb-md-0 mb-6">

    <div class="card invoice-preview-card">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
          <div class="mb-xl-0 mb-4">
            <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
              <img src="{{ asset($store->image) }}" alt="store Image" style="height: 60% ; width:60%" class="img-fluid">
              <span class="app-brand-text fw-bold fs-4">
                {{ $store->name }}
              </span>
            </div>
            <h4 class="mb-2">{{ $store->description }}</h4>
          </div>

          @if($store->offer)
          <div class="text-center">
            <a href="{{ route('offers.show', $store->offer->id) }}" class="btn btn-primary">Go to Offer</a>
          </div>
          @else
          <div class="text-center">
            <p>No offer available for this store.</p>
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
            <h4 class="mb-1">Store To:</h4>
            <h6 class="mb-3">{{ $store->admin->fname }}</h6>
            <h4 class="mb-1">Address:</h4>
            <h6 class="mb-3">{{ $store->address}}</h6>
            <h4 class="mb-1">Section Name:</h4>
            <h6 class="mb-3">{{ $store->section->name }}</h6>
            <h4 class="mb-1">SubSection Name:</h4>
            <h6 class="mb-3">{{ $store->sub_section->name}}</h6>
            <h4 class="mb-1">Delivery Time:</h4>
            <h6 class="mb-3">{{ $store->delivery_time}}</h6>
            <h4 class="mb-1">Status Now:</h4>
            <h6 class="mb-3">{{ $store->statusValue}}</h6>

            @if($store->pointstore)
            <h4 class="mb-1">Point Store:</h4>
            <h6>
              {{ "This store earned " . $store->pointstore->points_earned . " points after you make " .
              $store->pointstore->order_counts . " orders." ."and the minimum price of the total of orders is
              ".$store->pointstore->min_price ." this points must make in ".$store->pointstore->expire_days." days" }}
            </h6>

            @endif
          </div>



        </div>
      </div>
      <div class="alert alert-success" style="display: none;" id="weekhoursu">
        WeekHour Added Successfully
      </div>
      <div class="alert alert-danger" style="display: none;" id="weekdelete">
        WeekHour Deleted Successfully
      </div>

      <div class="alert alert-success" style="display: none;" id="weekupdate">
        WeekHour Updated Successfully
      </div>


      @include('content.store.partials.weekhourTable', ['store'=>$store,'days'=>$days,'weekhours' => $weekhours, 'title'
      =>
      'Add WeekHour'])
      <br><br>

      {{-- @include('content.store.partials.ingredientTable', ['store'=>$store,'ingredients' => $added_ingredients,
      'title'
      =>
      'Add Ingredients',"add"=>1])
      <br><br>
      @include('content.store.partials.ingredientTable', ['item'=>$store,'ingredients' => $remove_ingredients, 'title'
      => 'Remove Ingredients',"add"=>0]) --}}

      <br><br>
      <div class="alert alert-success" style="display: none;" id="successaddon1">
        Addon Added Successfully
      </div>
      <div class="alert alert-danger" style="display: none;" id="successadd3">
        Addon Deleted Successfully
      </div>
      @include('content.store.partials.addonTable', ['store'=>$store,'addons' => $addons, 'title' => 'Addons'])

      <br><br>
      <div class="alert alert-danger" style="display: none;" id="drinkdelete">
        Drink Deleted Successfully
      </div>
      <div class="alert alert-success" style="display: none;" id="successdrink1">
        Drink Added Successfully
      </div>
      @include('content.store.partials.drinkTable', ['store'=>$store,'drinks' => $drinks, 'title' => 'Drinks'])

      <div class="alert alert-success" style="display: none;" id="successdistrict">
        District Added  To This  Store Successfully
      </div>

      <div class="alert alert-danger" style="display: none;" id="successdistrict253">
        District Deleted From Store Successfully Successfully
      </div>


      @include('content.store.partials.districtTable', ['store'=>$store,'districts' => $districts, 'title'
      =>
      'Add District'])
      <br><br>

      <div class="alert alert-success" style="display: none;" id="tagstore">
       Tag Added  To This  Store Successfully
      </div>

      <div class="alert alert-danger" style="display: none;" id="tagdelete">
        Tag Deleted From Store Successfully Successfully
      </div>
      <div class="alert alert-success" style="display: none;" id="tagupdate">
        Tag Updated Successfully
      </div>
      @include('content.store.partials.tagTable', ['store'=>$store,'tags' => $store->tags()->get(), 'title'
      =>
      'Add Tag'])

      <br><br>
      <div class="card-body mx-3">
        <div class="row">
          <div class="col-12">
            {{-- <span class="fw-semibold">Note:</span>
            <span>It was a pleasure working with you and your team. We hope you will keep us in mind for future
              freelance projects. Thank You!</span> --}}
          </div>
        </div>
      </div>

      <!-- Add the link to the items page -->
      <div class="card-footer">
        <div class="text-center">

          <a href="{{ route('store.items', ['store_id' => $store->id]) }}" class="btn btn-primary">View Items</a>
        </div>
      </div>
    </div>
  </div>
  <!-- /js -->

  @include('content.store.addons.addon_js')
  @include('content.store.drinks.drink_js')
  @include('content.store.districts.district_js')
  @include('content.store.tags.tag_js')
  @include('content.store.weekhours.weekhour_js')

 <!-- /js -->

</div>
@endsection
