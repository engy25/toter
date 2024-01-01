<!-- resources/views/your_page.blade.php -->

@extends('layouts.layoutMaster')

@section('title', 'Subsection List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<!-- Include other vendor styles if needed -->
@endsection

@section('content')
@include('content.subsection.header')

<div class="alert alert-success" style="display: none;" id="success1">SubSection Added Successfully</div>
<div class="alert alert-success" style="display: none;" id="success2">SubSection Updated Successfully</div>
<div class="alert alert-danger" style="display: none;" id="success3">SubSection Deleted Successfully</div>

<?php
$i=0;
?>
<table id="data-table2" class="table border p-0 text-nowrap mb-0">
  <thead class="tabel-row-heading text-dark">
    <tr style="background:#f4f5f7">
      <th class="fw-semibold border-bottom">ID</th>
      <th class="fw-semibold border-bottom">{{ trans('words.name') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.image') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.SectionName') }}</th>
      <th class="bg-transparent fw-semibold border-bottom">Action</th>
    </tr>
  </thead>

  <tbody>
    @foreach($subsections as $subsection)
    <tr>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
      </td>

      <td>
        <span class="text-dark fs-13 fw-semibold">
          @if ($subsection->translations->isNotEmpty())
          {{ $subsection->translations[0]->name }}
          @else
          {{ $subsection->name }}
          @endif
        </span>
      </td>
      <td>
        <img src="{{ asset($subsection->image) }}" alt="Subsection Image" class="img-fluid">
      </td>

      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $subsection->section->name }}</span>
      </td>

      <td class="center align-middle">
        <div class="btn-group">
          <a href="{{ route('subsections.edit', $subsection->id) }}"
            class="btn bg-info-transparent d-flex align-items-center justify-content-center">
            <i style="font-size: 20px;" class="fe fe-edit text-info "></i>
          </a>&nbsp;
          <a href="{{ LaravelLocalization::localizeURL(route('subsections.edit', $subsection->id)) }}"
            class="btn btn-info btn-icon py-1 me-2 update_subsection_form" data-bs-toggle="modal"
            data-bs-target="#updateModal" data-id="{{ $subsection->id }}"
            data-name_en="{{ optional($subsection->translations()->where('locale', 'en')->first())->name }}"
            data-name_ar="{{ optional($subsection->translations()->where('locale', 'ar')->first())->name }}"
            data-description_en="{{ optional($subsection->translations()->where('locale', 'en')->first())->description }}"
            data-description_ar="{{ optional($subsection->translations()->where('locale', 'ar')->first())->description }}"
            data-section_id="{{ $subsection->section->id }}" data-image="{{ $subsection->image }}"
            style="width: 100px; height: 40px;">
            {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
          </a>
          <button type="button" class="btn btn-danger delete-subsection" data-id="{{ $subsection->id }}">
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
  @if ($subsections->lastPage() > 1)
  {{ $subsections->links('pagination.simple-bootstrap-4') }}
  @endif
  <div>

{!! Toastr::message() !!}

@include('content.subsectio.subsection_js')
@include('content.subsectio.update')
@include('content.subsectio.add_subsection_model')
@endsection
