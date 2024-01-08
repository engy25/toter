@extends('layouts.layoutMaster')

@section('title', ' Permision List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center">
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Permission /</span> List
    <br>
  </h4>

  <div class="d-flex align-items-center">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <a href="{{ route('cities.create') }}" class="btn btn-primary me-2" data-bs-toggle="modal"
      data-bs-target="#addpermissionModal" title="{{ trans('words.add') }}">
      {{ trans('words.add') }}
    </a>

    <form class="d-flex" id="searchForm">
      <input class="form-control me-2" type="search" id="search" name="search" placeholder="{{ trans('words.search') }}"
        aria-label="Search" style="width: 950px;">

    </form>


  </div>
</div>






<div class="alert alert-success" style="display: none;" id="success1">

  Permission Added Successfully
</div>



<div class="alert alert-success" style="display: none;" id="success2">
  Permission Updated Successfully
</div>

<div class="alert alert-danger" style="display: none;" id="success3">
  Permission Deleted Successfully
</div>

<div class="alert alert-warning" style="display: none;" id="success5">
  This Permission Is Used You Canoot Update It .
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
            <th class="fw-semibold border-bottom">{{ trans('words.assignedto') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.created_date') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.guard') }}</th>
            <th class="bg-transparent fw-semibold border-bottom">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($permissions as $permission)
          <tr>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold"> {{ $permission->name }}</span>
            </td>
            <td>
              <span class="text-nowrap">
                  @foreach($permission->roles as $role)
                      <a href="#"><span class="badge bg-label-primary m-1">{{ $role->name }}</span></a>
                  @endforeach
              </span>
          </td>
            <td>
              <span class="text-dark fs-13 fw-semibold">  {{ $permission->created_at->format('g:i A, F j, Y') }}</span>
            </td>

            <td>
              @if($permission->guard_name=="web")
              <span class="text-dark fs-13 fw-semibold">Web</span>
              @else
              <span class="text-dark fs-13 fw-semibold">Mobile</span>
              @endif
            </td>

            <td class="center align-middle">
              <div class="btn-group">
                <a href="{{ route('permissions.edit', $permission->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>&nbsp;
                <a href="{{ LaravelLocalization::localizeURL(route('permissions.edit', $permission->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 update_permission_form" data-bs-toggle="modal"
                  data-bs-target="#updatePermissionModal" data-id="{{ $permission->id }}"  data-guard="{{ $permission->guard_name }}"
                  data-name="{{ $permission->name }}"
                 title="Edit"
                  style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>
                <button type="button" class="btn btn-danger delete-permission" data-id="{{ $permission->id }}">
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
        @if ($permissions->lastPage() > 1)
        {{ $permissions->links('pagination.simple-bootstrap-4') }}
        @endif
      </div>
    </div>
  </div>
</div>
 @include('content.permission.permission_js')
@include('content.permission.update')
@include('content.permission.add_permission_model')
{!! Toastr::message() !!}



@endsection
