@extends('layouts.layoutMaster')

@section('title', 'User List - Pages')

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
    <span class="text-muted fw-light">Users /</span> List
    <br>
  </h4>


  <div class="d-flex align-items-center">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <a href="{{ route('users.create') }}" class="btn btn-primary me-2" title="{{ trans('words.add') }}">
      {{ trans('words.add') }}
    </a>

    <form class="d-flex" id="searchForm">
      <input class="form-control me-2" type="search" id="search" name="search" placeholder="{{ trans('words.search') }}"
        aria-label="Search" style="width: 950px;">

    </form>


  </div>
</div>

<div class="alert alert-success" style="display: none;" id="success1">

  User Added Successfully
</div>

<div class="alert alert-success" style="display: none;" id="success2">
  User Updated Successfully
</div>

<div class="alert alert-danger" style="display: none;" id="success3">
  User Deleted Successfully
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
            <th class="fw-semibold border-bottom">{{ trans('words.user') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.role') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.phone') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.active') }}</th>
            <th class="bg-transparent fw-semibold border-bottom">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>

            <td class="sorting_1">
              <div class="d-flex align-items-center user-name">
                <div class="avatar-wrapper">
                  <div class="avatar avatar-sm me-3">
                    <img src="{{ $user->image }}" alt="Image" class="rounded-circle">
                  </div>
                </div>
                <div class="d-flex flex-column">
                  <span class="fw-semibold">{{ $user->fname }}</span>
                  <small class="text-muted">{{ $user->email }}</small>
                </div>
              </div>
            </td>

            <td>
              @if($user->roles->isNotEmpty())

              @foreach($user->roles as $role)
              <span class="badge bg-primary">{{ $role->name }}</span>
              @endforeach
              @else
              <span class="text-muted">No roles assigned</span>
              @endif

            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $user->country_code }} {{ $user->phone }}</span>
            </td>
            <td>
              @if($user->is_active==1)
              <span class="badge text-white bg-success fw-semibold fs-11">Active</span>
              @else
              <span class="badge text-white bg-danger fw-semibold fs-11">Not Active</span>
              @endif
            </td>
            <td class="center align-middle">
              <div class="btn-group">
                <a href="{{ route('users.edit', $user->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>
                <a href="{{ LaravelLocalization::localizeURL(route('users.edit', $user->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 " data-id="{{ $user->id }}" title="Edit"
                  style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>

                <a href="{{ route('users.show', $user->id) }}" class="btn btn-success show-delivery"
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
        @if ($users->lastPage() > 1)
        {{ $users->links('pagination.simple-bootstrap-4') }}
        @endif
      </div>
    </div>
  </div>
</div>

@include('content.user.user_js')
{{-- @include('content.city.update')
@include('content.city.add_city_model') --}}
{!! Toastr::message() !!}



@endsection
