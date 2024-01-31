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
@endsection

@section('content')

<div class="card invoice-preview-card">

  <div class="card-body">
    <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
      <div class="mb-xl-0 mb-4">
        <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
          <img src="{{ asset($delivery->image) }}" alt="Delivery Image" style="height: 60% ; width:60%"
            class="img-fluid">
          <span class="app-brand-text fw-bold fs-4">
            {{ $delivery->fname }}
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
        <h6 class="mb-3">{{ $delivery->fname }}</h6>
        <h4 class="mb-1">Delivery Last Name:</h4>
        @if($delivery->lname)
        <h6 class="mb-3">{{ $delivery->lname }}</h6>
        @else
        <h6 class="mb-3">This Delivery Doesnot have last name</h6>
        @endif
        <h4 class="mb-1">Phone:</h4>
        <h6 class="mb-3">{{$delivery->country_code}}{{ "" }} {{ $delivery->phone }} </h6>

        <h4 class="mb-1">Email:</h4>
        <h6 class="mb-3">{{ $delivery->email }}</h6>
        <h4 class="mb-1">Is Active:</h4>
        @if($delivery->is_active==1)
        <h6 class="mb-3">True</h6>
        @else
        <h6 class="mb-3">False</h6>
        @endif
      </div>



    </div>
  </div>

  <div class="text-center mb-3">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <a href="{{ route('drinks.create') }}" class="btn btn-primary" data-bs-toggle="modal"
      data-bs-target="#addScheduleModal">Add New Delivery Schedule </a>
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
  <div class="table-responsive border-top" id="data-table2">
    <table class="table m-0">
      <thead>
        <tr>
          <th>Day Name</th>
          <th>From</th>
          <th>To</th>
          <th>Eorking Hours</th>
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
                <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>
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






  <div class="card-body mx-3">
    <div class="row">
      <div class="col-12">


      </div>
    </div>
  </div>
</div>
</div>
@include('content.delivery.createDeliverySchedule', ['delivery'=>$delivery])

@include('content.delivery.updateDeliverySchedule')
@include('content.delivery.delivery_js', ['delivery'=>$delivery])
</div>
@endsection
