@extends('layouts.layoutMaster')

@section('title', 'Coupon List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
      data-bs-target="#addCouponModal" title="{{ trans('words.add') }}">
      {{ trans('words.add') }}
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
            <th class="fw-semibold border-bottom">{{ trans('words.storename') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.code') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.discount_percentage') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.expire_date') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.isActive') }}</th>
            <th class="bg-transparent fw-semibold border-bottom">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($coupons as $coupon)
          <tr>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">
                @if ($coupon->store->translations->isNotEmpty())
                {{ $coupon->store->translations[0]->name }}
                @else
                {{ $store->name }}
                @endif
              </span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $coupon->code }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $coupon->discount_percentage }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $coupon->expire_date }}</span>
            </td>

            <td>
              @if($coupon->is_active==1)
              <div>
                <span class="badge text-white bg-success fw-semibold fs-11">True</span>
              </div>
              @else
              <div>
                <span class="badge text-white bg-danger fw-semibold fs-11">False</span>
              </div>
              @endif
            </td>



            <td class="center align-middle">
              <div class="btn-group">
                <a href="{{ route('coupons.edit', $coupon->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>
                <a href="{{ LaravelLocalization::localizeURL(route('coupons.edit', $coupon->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 update_coupon_form" data-bs-toggle="modal"
                  data-bs-target="#updateCouponModal" data-id="{{ $coupon->id }}"
                  data-discount_percentage="{{ $coupon->discount_percentage }}" data-code="{{ $coupon->code }}"
                  data-store_id="{{ $coupon->store_id }}" data-is_active="{{ $coupon->is_active }}"
                  data-expire_date="{{ $coupon->expire_date }}"
                  data-max_user_used_code="{{ $coupon->max_user_used_code	 }}" title="Edit"
                  style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>

                <a href="{{ route('coupons.show', $coupon->id) }}" class="btn btn-success show-offer"
                  style="width: 100px; height: 40px;">
                  <i class="bi bi-eye"></i> {{ trans('words.show') }}
                </a>&nbsp;&nbsp;



                <button type="button" class="btn btn-danger delete-coupon" data-id="{{ $coupon->id }}"
                  style="width: 100px; height: 40px;">
                  <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      {{-- {!! $cities->links() !!} --}}
      <div class="mt-4">
        @if ($coupons->lastPage() > 1)
        {{ $coupons->links('pagination.simple-bootstrap-4') }}
        @endif
      </div>

    </div>
  </div>
</div>

@include('content.coupon.coupon_js')
@include('content.coupon.update')
@include('content.coupon.add_coupon_modal')



{!! Toastr::message() !!}



@endsection
