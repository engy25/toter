@extends('layouts.layoutMaster')

@section('title', 'Order')

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

@if(isset($msg))
<div class="alert alert-success">{{ $msg }}</div>
@endif

<div class="card invoice-preview-card">
  <div class="card-body">
    <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
      <div class="mb-xl-0 mb-4">
        <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
          <span class="app-brand-text fw-bold fs-4">
            {{ $order->order_number }}
          </span>
        </div>
      </div>
      <div style="max-width:20 ">
        <br>
      </div>
    </div>
  </div>

  <hr class="my-0" />

  <div class="card-body">
    <div class="row p-sm-3 p-0">
      <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
        <h5 class="mb-1">Delivery First Name:</h5>
        @if($order->driver)
        <h6 class="mb-3">{{ $order->driver->fname }}</h6>
        <h5 class="mb-1"> Delivery Phone:</h5>
        <h6 class="mb-3">{{ $order->driver->country_code ?? '' }} {{ $order->driver->phone ?? '' }}</h6>
        @else
        <h6 class="mb-3">This Delivery Does not have last name</h6>
        @endif

        <h5 class="mb-1">Order Type:</h5>
        <h6 class="mb-3">{{ $order->butler->name }}</h6>


        <h5 class="mb-1">User First Name:</h5>
        <h6 class="mb-3">{{ $order->user->fname }}</h6>
        <h5 class="mb-1">User Phone:</h5>
        <h6 class="mb-3">{{ $order->user->phone }}</h6>
        <br><br><br>

        <h4 class="mb-1">User From Address:</h4>

        <h5 class="mb-1">Building:</h5>
        <h6 class="mb-3">{{ optional($order->fromAddress)->building }}</h6>
        <h5 class="mb-1">Street:</h5>
        <h6 class="mb-3">{{ optional($order->fromAddress)->street }}</h6>
        <h5 class="mb-1">Apartment:</h5>
        <h6 class="mb-3">{{ optional($order->fromAddress)->apartment }}</h6>
        <h5 class="mb-1">Instructions:</h5>
        <h6 class="mb-3">{{ $order->from_driver_instructions }}</h6>



      </div>

      <div class="col-xl-6 col-md-12 col-sm-7 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
        <h4 class="mb-1">Subtotal:</h4>
        <h6 class="mb-3">{{ $order->sub_total }} {{ ' ' }}{{ $defaultCurrency->isocode }}</h6>
        <h4 class="mb-1">Total:</h4>
        <h6 class="mb-3">{{ $order->total }} {{ ' ' }} {{ $defaultCurrency->isocode }}</h6>
        <h4 class="mb-1">Sum:</h4>
        <h6 class="mb-3">{{ $order->sum }} {{ ' ' }} {{ $defaultCurrency->isocode }}</h6>

        <h4 class="mb-1">Delivery Fees:</h4>
        <h6 class="mb-3">{{ $order->delivery_charge }} {{ ' ' }} {{ $defaultCurrency->isocode }}</h6>

        <h4 class="mb-1">Delivery Time:</h4>
        <h6 class="mb-3">{{ $order->delivery_time }}</h6>
        <br>
        <h4 class="mb-1">User To Address:</h4>
        <h5 class="mb-1">Building:</h5>
        <h6 class="mb-3">{{ optional($order->toAddress)->building }}</h6>
        <h5 class="mb-1">Street:</h5>
        <h6 class="mb-3">{{ optional($order->toAddress)->street }}</h6>
        <h5 class="mb-1">Apartment:</h5>
        <h6 class="mb-3">{{ optional($order->toAddress)->apartment }}</h6>
        <h5 class="mb-1">Instructions:</h5>
        <h6 class="mb-3">{{ $order->to_driver_instructions }}</h6>


      </div>
    </div>




    <h4 class="mb-1">Statuses:</h4>
    @foreach($order->statuses as $status)
    <h5 class="mb-3">{{ $status->name }}</h5>
    @endforeach

    @if($order->order!=null)
    <h4 class="mb-1">Order:</h4>

    <h5 class="mb-3">{{ $order->order }}</h5>
    @endif

    @if($order->order==null)
   <h5 class="my-3 text-center">Order Items</h5>
    <div class="table-responsive border-top" id="data-table2">
      <table class="table m-0">
        <thead>
          <tr>
            <th>Item Name</th>
            <th>Item Image</th>
            
          </tr>
        </thead>
        <tbody>
          @forelse ($order->orderItems as $orderItem)
          <tr>
            <td>{{ $orderItem->item }}</td>
            <td>{{ $orderItem->image }}</td>

          </tr>
          @empty
          <tr>
            <td colspan="4">No order items available.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @endif


    <div class="card-body mx-3">
      <div class="row">
        <div class="col-12">
          <!-- Additional content or actions can be added here -->
        </div>
      </div>
    </div>
  </div>




</div>

@endsection
