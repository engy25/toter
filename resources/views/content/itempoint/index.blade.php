@extends('layouts.layoutMaster')

@section('title', 'Item List - Pages')

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
    <span class="text-muted fw-light">Item /</span> List
    <br>
  </h4>


  <div class="d-flex align-items-center">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <a href="{{ route('items.create') }}" class="btn btn-primary me-2"
    {{-- data-bs-toggle="modal" data-bs-target="#addModal" --}}
    title="{{ trans('words.add') }}">
      {{ trans('words.add') }}
    </a>

    <form class="d-flex" id="searchForm">
      <input class="form-control me-2" type="search" id="search" name="search" placeholder="{{ trans('words.search') }}"
        aria-label="Search" style="width: 950px;">

    </form>


  </div>
</div>



@section('page-script')

<script>
  $(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    let storeId = window.location.pathname.split('/').pop();
    item(page, storeId);
  });

  function item(page, storeId) {
    $.ajax({
      url: "/pagination/paginate-storeItem/" + storeId + "?page=" + page, // Updated URL
      type: 'get',
      success: function(data) {

        $('.table-responsive').html(data);
      }
    });
  }
</script>
@endsection






<div class="alert alert-success" style="display: none;" id="success1">

  Item Added Successfully
</div>

<div class="alert alert-success" style="display: none;" id="success2">
  Item Updated Successfully
</div>

<div class="alert alert-danger" style="display: none;" id="success3">
  Item Deleted Successfully
</div>

<?php
$i=0;
?>
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      @include('content.item.pagination_index')
    </div>
  </div>
</div>

{{-- @include('content.item.update') --}}
{{-- @include('content.item.add_city_model') --}}
{!! Toastr::message() !!}



@endsection
