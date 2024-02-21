@extends('layouts.layoutMaster')

@section('title', 'Orde User List - Pages')

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
                <a href="{{ route('exportuser.pdf') }}" class="btn btn-primary">
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
      <table id="data-table2" class="table border p-0 text-nowrap mb-0">
        <thead class="tabel-row-heading text-dark">
          <tr style="background:#f4f5f7">
            <th class="fw-semibold border-bottom">{{ trans('words.order') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.isCoupon') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.subtotal') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.delivery_charge') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.total') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.delivery') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.date') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.status') }}</th>
            <th class="fw-semibold border-bottom">Actions</th>

          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          <tr>
            <td>
              @if ($order->orderItems->isNotEmpty())
              @foreach($order->orderItems as $orderItem)
              <span class="text-dark fs-13 fw-semibold">{{ $orderItem->item->name }}</span><br>
              @endforeach
              @else
              <!-- Handle the case when there are no order items -->
              <span>No items available</span>
              @endif
            </td>

            <td>
              @if ($order->coupon)
              <span class="text-dark fs-13 fw-semibold">{{ $order->coupon->discount_percentage }} %</span><br>

              @else
              <!-- Handle the case when there are no order items -->
              <span>False</span>
              @endif
            </td>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $order->sub_total }} {{ $defaultCurrency->isocode }}</span>
            </td>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $order->delivery_charge }} {{ $defaultCurrency->isocode }}</span>
            </td>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $order->total }} {{ $defaultCurrency->isocode }}</span>
            </td>
            <td>
              @if($order->driver)
              <span class="text-dark fs-13 fw-semibold">{{ $order->driver->fname }} </span>
              @else
              <span class="text-dark fs-13 fw-semibold">Not Assigned</span>
              @endif
            </td>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $order->created_at->format('Y-m-d') }}</span>
            </td>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $order->status->name }}</span>
            </td>

            <td class="center align-middle">
              <div class="btn-group">
                <a href="{{ route('storeorders.show', ['storeorder' => $order->id]) }}" class="btn btn-success" title="Order Details">
                  Show Order
                </a>&nbsp;
                @if($order->deliveryTrack )
                <a href="{{ route('create.track.order',['order'=>$order->id]) }}" class="btn btn-primary" title="Track Order">
                  Track Order
                </a>
                @endif
              </div>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-4 d-flex justify-content-center">
        @if ($orders->lastPage() > 1)
        {{ $orders->links('pagination.simple-bootstrap-4') }}
        @endif
      </div>
    </div>
  </div>
</div>

@include('content.orderusers.order_js')
{{-- @include('content.city.update')
@include('content.city.add_city_model') --}}
{!! Toastr::message() !!}

@endsection
