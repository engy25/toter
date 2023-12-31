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

@include('content.subsection.pagination_index')

{!! Toastr::message() !!}

@include('content.subsection.subsection_js')
@include('content.subsection.add_subsection_model')
@endsection
