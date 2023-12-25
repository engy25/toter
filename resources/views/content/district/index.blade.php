@extends('layouts.layoutMaster')

@section('title', 'City List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center">
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">City /</span> List
    <br>
  </h4>

  <div class="d-flex align-items-center">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <a href="{{ route('cities.create') }}" class="btn btn-primary me-2" data-bs-toggle="modal"
      data-bs-target="#addModal" title="{{ trans('words.add') }}">
      {{ trans('words.add') }}
    </a>

    <form class="d-flex" id="searchForm">
      <input class="form-control me-2" type="search" id="search" name="search" placeholder="{{ trans('words.search') }}"
        aria-label="Search" style="width: 950px;">

    </form>


  </div>
</div>






<div class="alert alert-success" style="display: none;" id="success1">

  City Added Successfully
</div>



<div class="alert alert-success" style="display: none;" id="success2">
  City Updated Successfully
</div>

<div class="alert alert-danger" style="display: none;" id="success3">
  City Deleted Successfully
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
            <th class="fw-semibold border-bottom">{{ trans('words.name') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.CountryName') }}</th>

            <th class="bg-transparent fw-semibold border-bottom">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cities as $city)
          <tr>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">
                @if ($city->translations->isNotEmpty())
                {{ $city->translations[0]->name }}
                @else
                {{ $city->name }}
                @endif
              </span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $city->country->name }}</span>
            </td>

            <td class="center align-middle">
              <div class="btn-group">
                <a href="{{ route('cities.edit', $city->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>&nbsp;
                <a href="{{ LaravelLocalization::localizeURL(route('cities.edit', $city->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 update_city_form" data-bs-toggle="modal"
                  data-bs-target="#updateModal" data-id="{{ $city->id }}"
                  data-name_en="{{ $city->translations()->where("locale","en")->first()->name }}"
                  data-name_ar="{{$city->translations()->where("locale","ar")->first()->name }}"
                  data-Country_name="{{ $city->country->name }}" data-country_id="{{ $city->country->id }}" title="Edit"
                  style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>
                <button type="button" class="btn btn-danger delete-city" data-id="{{ $city->id }}">
                  <span class="bi bi-trash me-1">{{ trans('words.delete') }}</span>
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{-- {!! $cities->links() !!} --}}
      <div class="mt-4">
        @if ($cities->lastPage() > 1)
        {{ $cities->links('pagination.simple-bootstrap-4') }}
        @endif
      </div>
    </div>
  </div>
</div>
@include('content.city.city_js')
@include('content.city.update')
@include('content.city.add_city_model')
{!! Toastr::message() !!}



@endsection
