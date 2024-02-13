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
        <h4 class="mb-1">Delivery First Name:</h4>
        @if($order->delivery !=null)
        <h6 class="mb-3">{{ $order->delivery->fname }}</h6>
        <h4 class="mb-1">Phone:</h4>
        <h6 class="mb-3">{{$order->delivery->country_code}}{{ "" }} {{ $order->delivery->phone }} </h6>
        @else
        <h6 class="mb-3">This Delivery Doesnot have last name</h6>
        @endif
      </div>
      <h4 class="mb-1">subTotal:</h4>
      <h6 class="mb-3">{{ $order->sub_total }}</h6>
      <h4 class="mb-1">Total:</h4>
      <h6 class="mb-3">{{ $order->total }}</h6>
      <h4 class="mb-1">Delivery Fees:</h4>
      <h6 class="mb-3">{{ $order->delivery_charge }}</h6>
      <h4 class="mb-1">District:</h4>
      <h6 class="mb-3">{{ $order->district->name }}</h6>
    </div>



    <h5 class="my-3 text-center">Order Items</h5>
    <div class="table-responsive border-top" id="data-table2">
      <table class="table m-0">
        <thead>
          <tr>
            <th>Item Name </th>
            <th>Price</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($order->orderItems as $orderItem)
          <tr>
            <td>{{ $orderItem->item->name }}</td>
            <td>{{ $orderItem->item->price }}</td>
            <td>{{ $orderItem->qty }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="3">No order items available.</td>
          </tr>
          @endforelse


        </tbody>
      </table>
    </div>






    <div class="card-body mx-3">
      <div class="row">
        <div class="col-12">


        </div>
      </div>
    </div>
  </div>
</div>

</div>
@endsection
