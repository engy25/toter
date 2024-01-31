@extends('layouts.layoutMaster')

@section('title', 'Comapny Districts List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center">
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Comapny Districts /</span> List
    <br>
  </h4>

  <div class="d-flex align-items-center">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <a href="{{ route('companydistricts.create') }}" class="btn btn-primary me-2" data-bs-toggle="modal"
      data-bs-target="#addDistrictCompanyModal" title="{{ trans('words.add') }}">
      {{ trans('words.add') }}
    </a>

    <form class="d-flex" id="searchForm">
      <input class="form-control me-2" type="search" id="search" name="search" placeholder="{{ trans('words.search') }}"
        aria-label="Search" style="width: 950px;">

    </form>


  </div>
</div>






<div class="alert alert-success" style="display: none;" id="success1">

  District Added Successfully
</div>



<div class="alert alert-success" style="display: none;" id="success2">
  District Updated Successfully
</div>

<div class="alert alert-danger" style="display: none;" id="success3">
  District Deleted Successfully
</div>

@include('content.company_districts.pagination_index')

</div>
</div>
</div>
@include('content.company_districts.district_js')
@include('content.company_districts.update')
@include('content.company_districts.add_district_model')
{!! Toastr::message() !!}



@endsection
