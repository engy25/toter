@extends('layouts.layoutMaster')

@section('title', 'Offer List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Offer /</span> List
        <br>
    </h4>

    <div class="d-flex align-items-center">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <a href="{{ route('offers.create') }}" class="btn btn-primary me-2" title="{{ trans('words.add') }}">
            {{ trans('words.add') }}
        </a>

        <form class="d-flex" id="searchForm">
            <input class="form-control me-2" type="search" id="search" name="search" placeholder="{{ trans('words.search') }}"
                aria-label="Search" style="width: 950px;">
        </form>
    </div>
</div>

<div class="alert alert-success" style="display: none;" id="success1">
    Offer Added Successfully
</div>

<div class="alert alert-success" style="display: none;" id="success2">
    Offer Updated Successfully
</div>

<div class="alert alert-danger" style="display: none;" id="success3">
    Offer Deleted Successfully
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<?php $i=0; ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="data-table2" class="table border p-0 text-nowrap mb-0">
                <thead class="tabel-row-heading text-dark">
                    <tr style="background:#f4f5f7">
                        <th class="fw-semibold border-bottom">ID</th>
                        <th class="fw-semibold border-bottom">{{ trans('words.name') }}</th>
                        <th class="fw-semibold border-bottom">{{ trans('words.image') }}</th>
                        <th class="fw-semibold border-bottom">{{ trans('words.discount_percentage') }}</th>
                        <th class="fw-semibold border-bottom">{{ trans('words.expire_date') }}</th>
                        <th class="bg-transparent fw-semibold border-bottom">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offers as $offer)
                        <tr>
                            <td><span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span></td>
                            <td><span class="text-dark fs-13 fw-semibold">
                                    @if ($offer->translations->isNotEmpty())
                                        {{ $offer->translations[0]->name }}
                                    @else
                                        {{ $offer->name }}
                                    @endif
                                </span>
                            </td>
                            <td><img src="{{ asset($offer->image) }}" alt="offer Image" style="height: 50% ; width:50%" class="img-fluid"></td>
                            <td><span class="text-dark fs-13 fw-semibold">{{ $offer->discount_percentage }}</span></td>
                            <td><span class="text-dark fs-13 fw-semibold">{{ $offer->from_date }}</span></td>
                            <td class="center align-middle">
                                <div class="btn-group">
                                    <a href="{{ route('offers.edit', $offer->id) }}" class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                                        <i style="font-size: 20px;" class="fe fe-edit text-info "></i>
                                    </a>
                                    <a href="{{ LaravelLocalization::localizeURL(route('offers.edit', $offer->id)) }}" class="btn btn-info btn-icon py-1 me-2" title="Edit" style="width: 100px; height: 40px;">
                                        {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                                    </a>
                                    <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-success show-offer" style="width: 100px; height: 40px;">
                                        <i class="bi bi-eye"></i> {{ trans('words.show') }}
                                    </a>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-danger delete-store" data-id="{{ $offer->id }}" style="width: 100px; height: 40px;">
                                        <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                @if ($offers->lastPage() > 1)
                    {{ $offers->links('pagination.simple-bootstrap-4') }}
                @endif
            </div>
        </div>
    </div>
</div>
@include('content.offer.offer_js')

{!! Toastr::message() !!}
@endsection
