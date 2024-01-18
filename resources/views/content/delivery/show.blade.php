@extends('layouts/layoutMaster')

@section('title', 'Delivery')

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
@include('content.delivery.addIncentiveModal')
@endsection

@section('content')

<div class="alert alert-success" style="display: none;" id="success200">
  Added Successfully
</div>

<div class="card invoice-preview-card">


  <div class="card-body">
    <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
      <div class="mb-xl-0 mb-4">
        <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
          <img src="{{ asset($delivery->image) }}" alt="Delivery Image" style="height: 60%; width: 60%"
            class="img-fluid">
          <span class="app-brand-text fw-bold fs-4">
            {{ $delivery->fname }}
          </span>
        </div>
      </div>

      <div style="max-width: 20%">
        <!-- Button for Attendance Time -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <a href="#" class="btn btn-success add_delivery_arrival_time_form" data-delivery_id="{{ $delivery->id }}"
          data-bs-toggle="modal" data-bs-target="#addDeliveryArrivalTimeModal">Add Delivery Arrival Time</a>
        @include('content.delivery.addAttendanceModal')
      </div>


    </div>
  </div>
</div>



<hr class="my-0" />

<div class="card-body">
  <div class="row p-sm-3 p-0">
    <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
      <h4 class="mb-1">Delivery First Name:</h4>
      <h6 class="mb-3">{{ $delivery->fname }}</h6>
      <h4 class="mb-1">Delivery Last Name:</h4>
      @if($delivery->lname)
      <h6 class="mb-3">{{ $delivery->lname }}</h6>
      @else
      <h6 class="mb-3">This Delivery Does not have a last name</h6>
      @endif
      <h4 class="mb-1">Phone:</h4>
      <h6 class="mb-3">{{$delivery->country_code}}{{ "" }} {{ $delivery->phone }} </h6>
      <h4 class="mb-1">Email:</h4>
      <h6 class="mb-3">{{ $delivery->email }}</h6>
      <h4 class="mb-1">Is Active:</h4>
      <h6 class="mb-3">{{ $delivery->is_active ? 'True' : 'False' }}</h6>
    </div>
  </div>
</div>

<!-- Add buttons for adding incentives and discounts -->
<div class="d-flex justify-content-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <a href="#" class="btn btn-danger mx-2" data-bs-toggle="modal"  data-delivery_id={{ $delivery->id }} data-bs-target="#addDiscountModal">Add Discount</a>
  <a href="#" class="btn btn-success mx-2" data-bs-toggle="modal"  data-delivery_id={{ $delivery->id }} data-bs-target="#addIncentiveModal">Add Incentive</a>


</div>


<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">Add New Delivery
    Schedule </a>
</div>



<div class="alert alert-success" style="display: none;" id="successing2">
  Delivery Schedule Updated Successfully
</div>

<div class="alert alert-danger" style="display: none;" id="success3">
  Delivery Schedule Deleted Successfully
</div>

<div class="alert alert-success" style="display: none;" id="success1">
  Delivery Schedule Added Successfully
</div>


<h5 class="my-3 text-center"> Delivery Schedules</h5>
<div class="border-top" id="data-table2">
  <table class="table m-0">
    <thead>
      <tr>
        <th>Day Name</th>
        <th>From</th>
        <th>To</th>
        <th>Working Hours</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($weekhours as $weekhour)
      <tr>
        <td>{{ $weekhour->day->name }}</td>
        <td>{{ \Carbon\Carbon::parse($weekhour->from_time)->format('g:i a') }}</td>
        <td>{{ \Carbon\Carbon::parse($weekhour->to_time)->format('g:i a') }}</td>
        <td>{{ $weekhour->working_hours }}</td>
        <td class="center align-middle">
          <div class="btn-group">
            <a href="{{ route('deliveryschedules.update', $weekhour->id) }}"
              class="btn bg-info-transparent d-flex align-items-center justify-content-center">
              <i style="font-size: 20px;" class="fe fe-edit text-info "></i>
            </a>
            <a href="{{ LaravelLocalization::localizeURL(route('deliveryschedules.update', $weekhour->id)) }}"
              class="btn btn-info btn-icon py-1 me-2 update_schedule_form" data-bs-toggle="modal"
              data-bs-target="#updateScheduleModal" data-id="{{ $weekhour->id }}"
              data-from_time="{{ $weekhour->from_time }}" data-to_time="{{ $weekhour->to_time }}" title="Edit"
              style="width: 100px; height: 40px;">
              {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
            </a>
            <button type="button" class="btn btn-danger delete-weekhour" data-id="{{ $weekhour->id }}">
              <span class="bi bi-trash me-1">{{ trans('words.delete') }}</span>
            </button>
          </div>
        </td>
      </tr>
      @endforeach

    </tbody>
  </table>
</div>




<br><br>
<div class="alert alert-success" style="display: none;" id="successPrice">
  Added Successfully
</div>

<h5 class="my-3 text-center"> Arrival Time</h5>
<div class="border-top" id="data-table5">
  <table class="table m-0">
    <thead>
      <tr>
        <th>Day Name</th>
        <th>Working Hours</th>
        <th>Attendance Time</th>
        <th>Check Out Time</th>
        <th>Date</th>
        <th>Orders Count</th>
        <th>Is Paid</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($arrivalTimes as $arrivalTime)
      <tr>
        <td>{{ $arrivalTime->day->name }}</td>
        <td>{{ $weekhour->working_hours }}</td>
        <td>{{ \Carbon\Carbon::parse($arrivalTime->attendance_time)->format('g:i a') }}</td>
        <td>{{ \Carbon\Carbon::parse($arrivalTime->cancel_time)->format('g:i a') }}</td>

        <td>{{ \Carbon\Carbon::parse($arrivalTime->created_at)->format('d-m-Y') }}</td>

        <td>
          @php
          $ordersCount =
          \App\Helpers\Helpers::deliveryOrdersCount($delivery->id,\Carbon\Carbon::parse($arrivalTime->created_at)->format('d-m-Y'));
          @endphp

          Orders: {{ $ordersCount['deliveryOrdersCount'] }}<br>
          Callcenter Orders: {{ $ordersCount['deliveryOrderCallcenterCount'] }}<br>
          Butlers Orders: {{ $ordersCount['deliveryOrderButlersCount'] }}
        </td>

        <td>
          {{ $arrivalTime->is_paid==1 ? 'true' : 'false' }}
        </td>



        <td class="center align-middle">
          <div class="btn-group">
            @if($arrivalTime->is_paid==0 )
            <button type="button" class="btn btn-primary add_daily_cal_form" data-bs-toggle="modal"
              data-bs-target="#dailyCalculationModal" data-arrivalTimeId={{ $arrivalTime->id }}
              data-delivery_id={{ $delivery->id }} >
              Daily Calculation
            </button>
            @include('content.delivery.dailyCalculationModal',["id"=> $arrivalTime->id])
          </div>
          @else
          It Is Paid
          @endif
        </td>

      </tr>
      @endforeach

    </tbody>
  </table>
</div>





<div class="card-body mx-3">
  <div class="row">
    <div class="col-12">
      <!-- Add any additional content for the card body if needed -->

      @include('content.delivery.addDiscountModal')

    </div>
  </div>
</div>
</div>

@include('content.delivery.createDeliverySchedule', ['delivery'=>$delivery])
@include('content.delivery.updateDeliverySchedule')
@include('content.delivery.delivery_js')


@endsection
