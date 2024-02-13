@extends('layouts/layoutMaster')

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
          <span class="app-brand-text fw-bold fs-4">{{ $order->order_number }}</span>
        </div>
      </div>
      <div style="max-width: 20">
        <br>
      </div>
    </div>
  </div>

  <hr class="my-0" />
  <div class="card-body">
    <div class="row p-sm-3 p-0">
      <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
        <h4 class="mb-1">From Address:</h4>
        <div class="address-details">
          <h5 class="mb-1">District:</h5>
          <h6 class="mb-3">{{ $order->fromAddress->district->name }}</h6>
          <h5 class="mb-1">Building:</h5>
          <h6 class="mb-3">{{ $order->fromAddress->building }}</h6>
          <h5 class="mb-1">Street:</h5>
          <h6 class="mb-3">{{ $order->fromAddress->street }}</h6>
          <h5 class="mb-1">Apartment:</h5>
          <h6 class="mb-3">{{ $order->fromAddress->apartment }}</h6>
          <h5 class="mb-1">Instructions:</h5>
          <h6 class="mb-3">{{ $order->fromAddress->instructions }}</h6>
        </div>

        <h5 class="mb-1">User Phone:</h5>
        <h6 class="mb-3">{{ $order->user->country_code }}{{ "" }} {{ $order->user->phone }}</h6>

        <h5 class="mb-1">Delivery First Name:</h5>
        @if($order->driver != null)
        <h6 class="mb-3">{{ $order->driver->fname }}</h6>
        <h5 class="mb-1">Phone:</h5>
        <h6 class="mb-3">{{ $order->driver->country_code }}{{ "" }} {{ $order->driver->phone }} </h6>
        @else
        <h6 class="mb-3">This Delivery Does not have a last name</h6>
        @endif
      </div>

      <div class="col-xl-6 col-md-12 col-sm-7 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
        <h5 class="mb-1">SubTotal:</h5>
        <h6 class="mb-3">{{ $order->sub_total }}</h5>
          <h5 class="mb-1">Total:</h5>
          <h6 class="mb-3">{{ $order->total }}</h6>
          <h5 class="mb-1">Delivery Fees:</h5>
          <h6 class="mb-3">{{ $order->delivery_charge }}</h6>

          <h4 class="mb-1">To Address:</h4>
          <div class="address-details">
            <h5 class="mb-1">District:</h5>
            <h6 class="mb-3">{{ $order->toAddress->district->name }}</h6>
            <h5 class="mb-1">Building:</h5>
            <h6 class="mb-3">{{ $order->toAddress->building }}</h6>
            <h5 class="mb-1">Street:</h5>
            <h6 class="mb-3">{{ $order->toAddress->street }}</h6>
            <h5 class="mb-1">Apartment:</h5>
            <h6 class="mb-3">{{ $order->toAddress->apartment }}</h6>
            <h5 class="mb-1">Instructions:</h5>
            <h6 class="mb-3">{{ $order->toAddress->instructions }}</h6>
          </div>

          @if($order->order != null)
          <h5 class="mb-1">Order:</h5>
          <h6 class="mb-3">{{ $order->order }}</h6>
          @endif
      </div>
    </div>

    @if($order->order == null)
    <h5 class="my-3 text-center">Order Items</h5>
    <div class="table-responsive border-top" id="data-table2">
      <table class="table m-0">
        <thead>
          <tr>
            <th>Item Name</th>
            <th>Image</th>
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
            <td colspan="3">No order items available.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @endif

    <div class="card-body mx-3">
      <div class="row">
        <div class="col-12">
          <!-- Add any additional content here -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
