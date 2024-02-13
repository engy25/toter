@extends('layouts.layoutMaster')

@section('title', 'Orde CallCenter List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

<style>
  .checked {
    color: orange;
  }

  .card {
    width: 100%; /* Set a consistent width for the cards */
  }

  .export-pdf-card {
    width: 100%; /* Set a consistent width for the Export to PDF card */
  }
</style>

@section('content')


<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Orders /</span> List
  <br>
</h4>

<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Monthly Orders Counts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2">
                {{ $monthlyOrders }}
              </h4>

            </div>

          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>





  <div class="col-sm-6 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Daily OrdersCounts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2"> {{ $dailyOrders }}
              </h4>
            </div>
          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>





  <div class="col-sm-6 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Daily Sales Counts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2"> {{ $daily_sales }}{{ $defaultCurrency->isocode }}</h4>

            </div>

          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>



  <div class="col-sm-6 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Monthly Sales Counts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2">{{ $monthly_sales}} {{ $defaultCurrency->isocode }}</h4>

            </div>

          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>




  <div class="col-sm-6 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Year Orders Counts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2">{{ $yearOrders }} </h4>

            </div>

          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>


  <div class="col-sm-6 col-xl-4">
    <div class="card" style="width: 330px; height: 105px;">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <span class="fw-bold">Export to PDF</span>
                <a href="{{ route('exportcallcenter.pdf') }}" class="btn btn-primary">
                    <i class="fa fa-file-pdf me-2"></i> Export
                </a>
            </div>
        </div>
    </div>
</div>




</div>

<div class="d-flex align-items-center">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <form class="d-flex" id="searchForm">
    <input class="form-control me-2" type="search" id="search" name="search" placeholder="{{ trans('words.search') }}"
      aria-label="Search" style="width: 950px;">

    <!-- Select input for delivery representative -->
    <select class="form-select me-2" id="delivery" name="delivery">
      <option value="">Select Delivery Representative</option>
      @foreach ($deliveries as $deliveryRepresentative)
      <option value="{{ $deliveryRepresentative->id }}">{{ $deliveryRepresentative->fname }}</option>
      @endforeach
    </select>

    <select class="form-select me-2" id="status" name="status">
      <option value="">Select Status</option>
      @foreach ($statuses as $status)
      <option value="{{ $status->id }}">{{ $status->name }}</option>
      @endforeach
    </select>

    <!-- Input for date range -->
    <input class="form-control me-2" type="date" id="date" name="date">

  </form>

</div>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">

      @include('content.orders.pagination_index')

  </div>
</div>

@include('content.orders.order_js')

{!! Toastr::message() !!}

@endsection
