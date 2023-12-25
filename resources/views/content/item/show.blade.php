@extends('layouts/layoutMaster')

@section('title', 'Item')

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
<div class="row justify-content-center">
  <!-- Invoice -->
  <div class="col-xl-10 col-md-10 col-14 mb-md-0 mb-6">
    <div class="alert alert-success" style="display: none;" id="successingredient1">

      Ingredient Added Successfully
    </div>
    <div class="alert alert-success" style="display: none;" id="successing2">
      Ingredient Updated Successfully
    </div>

    <div class="alert alert-danger" style="display: none;" id="successing3">
      Ingredient Deleted Successfully
    </div>

    <div class="alert alert-success" style="display: none;" id="successaddon1">

      Addon Added Successfully
    </div>



    <div class="card invoice-preview-card">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0 "
          id="item_list">
          <div class="mb-xl-0 mb-4">
            <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
              <img src="{{ asset($item->image) }}" alt="store Image" style="height: 60%; width:60%" class="img-fluid">
              <span class="app-brand-text fw-bold fs-4">{{ $item->name }}</span>
            </div>
            <h4 class="mb-2">{{ $item->description }}</h4>
          </div>

          <div class="text-center">
            @if($item->has_offer==1 || $item->offer)
            <a href="{{ route('offers.show', $item->store->offer->id) }}" class="btn btn-primary">Go to Offer</a>
            @else
            <p>No offer available for this item.</p>
            @endif
          </div>

          <div style="max-width:20"><br></div>
        </div>
      </div>

      <hr class="my-0" />

      <div class="card-body">
        <div class="row p-sm-3 p-0">
          <div class="col-md-6 mb-md-4 mb-sm-0 mb-4">
            <h5 class="mb-1">Store Name:</h5>
            <h5 class="mb-3">{{ $item->store->name}}</h5>

            <h5 class="mb-1">Price Before Added Value:</h5>
            <h5 class="mb-3">{{ $item->PriceBeforeTax}} {{ $item->currencyIsoCode }}</h5>

            <h5 class="mb-1">Added Value:</h5>
            <h5 class="mb-3">{{ $item->added_value}}</h5>

            <h5 class="mb-1">Price After Added Value:</h5>
            <h5 class="mb-3">{{ $item->price}} {{ $item->currencyIsoCode }}</h5>
          </div>

          <div class="col-md-6">
            <h5 class="mb-1">Category Name:</h5>
            <h5 class="mb-3">{{ $item->category->name }}</h5>

            <h5 class="mb-1">Section Name:</h5>
            <h5 class="mb-3">{{ $item->section->name }}</h5>

            <h5 class="mb-1">SubSection Name:</h5>
            <h5 class="mb-3">{{ $item->subsection->name}}</h5>

            <h5 class="mb-1">Points:</h5>
            <h5 class="mb-3">{{ $item->points}}</h5>

            <h5 class="mb-1">Choose Days:</h5>
            <h5 class="mb-3">{{ $item->choose_days}}</h5>
          </div>
        </div>
      </div>



      @php
      $title = 'Add Ingredients';
      $add = ($title === 'Add Ingredients') ? 1 : 0;
      @endphp

      <br><br>
      @if($item->is_restaurant==1)

      @include('content.item.partials.ingredientTable', ['item'=>$item,'ingredients' => $added_ingredients, 'title'
      =>'Add Ingredients', 'title_Add'=> $title])

      <br><br>

      @include('content.item.partials.ingredientTable', ['item'=>$item,'ingredients' => $remove_ingredients, 'title'
      => 'Remove Ingredients','title_Add'=>$title])


      <br><br>
      @include('content.item.partials.addonTable', ['item'=>$item,'addons' => $addons, 'title' => 'Addons'])

      <br><br>
      @include('content.item.partials.drinkTable', ['item'=>$item,'drinks' => $drinks, 'title' => 'Drinks'])

      <br><br>
      @include('content.item.partials.sideTable', ['item'=>$item,'sides' => $sides, 'title' => 'Sides'])


      @endif


      <br><br>
      @include('content.item.partials.sizeTable', ['item'=>$item,'sizes' => $sizes, 'title' => 'Sizes'])
      @include('content.item.partials.giftTable', ['item'=>$item,'gifts' => $gifts, 'title' => 'Gifts'])
      @include('content.item.partials.serviceTable', ['item'=>$item,'services' => $services, 'title' => 'Service'])
      @include('content.item.partials.preferenceTable', ['item'=>$item,'preferences' => $preferences, 'title' =>
      'Preference'])
      @include('content.item.partials.optionTable', ['item'=>$item,'options' => $options, 'title' => 'Option'])

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

          {{-- <a href="{{ route('store.items', ['store_id' => $store->id]) }}" class="btn btn-primary">View
            Items</a>
          --}}
        </div>
      </div>
    </div>
  </div>

  @include('content.ingredient.add_ingredient_model', ['add' => $add])
  @include('content.ingredient.ingredient_js',['item_id'=>$item->id])

  @include('content.addon.addon_js',['item_id'=>$item->id])


</div>
@endsection
