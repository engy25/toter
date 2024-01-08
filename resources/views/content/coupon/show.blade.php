@extends('layouts/layoutMaster')

@section('title', 'Coupon')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
    <style>
        /* Add your custom styles here */
        .store-link {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.store-link').on('click', function () {
                // Redirect to the show page of the store
                var storeId = $(this).data('store-id');
                window.location.href = '/stores/' + storeId;
            });
        });
    </script>
@endsection

@section('content')

    <div class="card invoice-preview-card">
        <div class="card-body">
            <!-- Display Coupon Details -->
            <h4 class="card-title mb-1">Coupon Details</h4>
            <ul>
                <li><strong>Discount Percentage:</strong> {{ $coupon->discount_percentage }}</li>
                <li><strong>Code:</strong> {{ $coupon->code }}</li>
                <li><strong>Max User Used Code:</strong> {{ $coupon->max_user_used_code }}</li>
                <li>
                    <strong>Store Name:</strong>
                    <span class="store-link" data-store-id="{{ $coupon->store->id }}">
                        {{ $coupon->store->name }}
                    </span>
                </li>
                <li><strong>Expire Date:</strong> {{ $coupon->expire_date }}</li>
            </ul>
        </div>
    </div>

@endsection
