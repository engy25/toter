@extends('layouts.layoutMaster')

@section('title', 'Coupon List - Pages')

@section('vendor-style')

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection



@section('page-script')

@include('content.coupon.add_couponcompany_modal')
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
    <span class="text-muted fw-light">Coupon /</span> List
    <br>
  </h4>


  <div class="d-flex align-items-center">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <a href="{{ route('coupons.create') }}" class="btn btn-primary me-2" data-bs-toggle="modal"
      data-bs-target="#addModal" title="{{ trans('words.addtostore') }}">
      {{ trans('words.addtostore') }}
    </a>
    <a href="{{ route('add.coupon.store') }}" class="btn btn-primary me-2" data-bs-toggle="modal"
      data-bs-target="#addCouponCompanyModal" title="{{ trans('words.addtocompany') }}">
      {{ trans('words.addtocompany') }}
    </a>

    <form class="d-flex" id="searchForm">
      <input class="form-control me-2" type="search" id="search" name="search" placeholder="{{ trans('words.search') }}"
        aria-label="Search" style="width: 950px;">

    </form>


  </div>
</div>

<div class="alert alert-success" style="display: none;" id="success1">

  Coupon Added Successfully
</div>

<div class="alert alert-success" style="display: none;" id="success2">
  Coupon Updated Successfully
</div>

<div class="alert alert-danger" style="display: none;" id="success3">
  Coupon Deleted Successfully
</div>

<div class="alert alert-warning" style="display: none;" id="success5">
  This Coupon Is Used You Canoot Update It .
</div>

@include('content.coupon.pagination_index')





@include('content.coupon.coupon_js')
@include('content.coupon.update')
@include('content.coupon.updateCouponToCom')

@include('content.coupon.add_coupon_modal')



{!! Toastr::message() !!}



@endsection
