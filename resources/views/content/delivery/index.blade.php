@extends('layouts.layoutMaster')

@section('title', 'Delivery List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection
<!-- Font Awesome Icon Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Font Awesome Icon Library -->

<style>
  .checked {
    color: orange;
  }
</style>
@section('content')
<div class="d-flex justify-content-between align-items-center">
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Delivery /</span> List
    <br>
  </h4>


  <div class="d-flex align-items-center">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <a href="{{ route('deliveries.create') }}" class="btn btn-primary me-2" title="{{ trans('words.add') }}">
      {{ trans('words.add') }}
    </a>

    <form class="d-flex" id="searchForm">
      <input class="form-control me-2" type="search" id="search" name="search" placeholder="{{ trans('words.search') }}"
        aria-label="Search" style="width: 950px;">

    </form>


  </div>
</div>

<div class="alert alert-success" style="display: none;" id="success1">

  Store Added Successfully
</div>

<div class="alert alert-success" style="display: none;" id="success2">
  Store Updated Successfully
</div>

<div class="alert alert-danger" style="display: none;" id="success3">
  Store Deleted Successfully
</div>

<?php
$i=0;
?>
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table id="data-table2" class="table border p-0 text-nowrap mb-0">
        <thead class="tabel-row-heading text-dark">
          <tr style="background:#f4f5f7">
            <th class="fw-semibold border-bottom">ID</th>
            <th class="fw-semibold border-bottom">{{ trans('words.fname') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.image') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.email') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.phone') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.active') }}</th>
            <th class="bg-transparent fw-semibold border-bottom">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($deliveries as $delivery)
          <tr>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">

                {{ $delivery->fname }}

              </span>
            </td>

            <td>
              <img src="{{ asset($delivery->image) }}" alt="Delivery Image" style="height: 50% ; width:50%"
                class="img-fluid">
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $delivery->email }}</span>
            </td>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $delivery->country_code }} {{ $delivery->phone }}</span>
            </td>
            <td>
              @if($delivery->is_active==1)
              <span class="badge text-white bg-success fw-semibold fs-11">Active</span>
              @else
              <span class="badge text-white bg-danger fw-semibold fs-11">Not Active</span>
              @endif
            </td>
            <td class="center align-middle">
              <div class="btn-group">
                <a href="{{ route('deliveries.edit', $delivery->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>
                <a href="{{ LaravelLocalization::localizeURL(route('deliveries.edit', $delivery->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 "
                  data-id="{{ $delivery->id }}" title="Edit"
                  style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>

                <a href="{{ route('deliveries.show', $delivery->id) }}" class="btn btn-success show-delivery"
                  style="width: 100px; height: 40px;">
                  <i class="bi bi-eye"></i> {{ trans('words.show') }}
                </a>&nbsp;&nbsp;
              

              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{-- {!! $cities->links() !!} --}}
      <div class="mt-4">
        @if ($deliveries->lastPage() > 1)
        {{ $deliveries->links('pagination.simple-bootstrap-4') }}
        @endif
      </div>
    </div>
  </div>
</div>

@include('content.delivery.delivery_js')
{{-- @include('content.city.update')
@include('content.city.add_city_model') --}}
{!! Toastr::message() !!}



@endsection
