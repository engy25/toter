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

            <a href="{{ route('traditionalusers.create') }}" class="btn btn-primary me-2" title="{{ trans('words.add') }}">
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

    <?php $i = 0; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">

            </div>
        </div>
    </div>

    @include('content.traditionalUser.user_js')

    {!! Toastr::message() !!}
@endsection
