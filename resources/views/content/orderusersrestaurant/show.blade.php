@extends('layouts.layoutMaster')

@section('title', 'Order')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
@endsection

@section('page-script')
<script src="{{ asset('assets/js/offcanvas-add-payment.js') }}"></script>
{{-- <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script> --}}
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
@endsection

@section('content')

@if(isset($msg))
<div class="alert alert-success">{{ $msg }}</div>
@endif

<div class="card invoice-preview-card">
    <div class="card-body">
        <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
            <div class="mb-xl-0 mb-4">
                <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                    <span class="app-brand-text fw-bold fs-4">
                        {{ $order->order_number }}
                    </span>
                </div>
            </div>
            <div style="max-width:20 ">
                <br>
            </div>
        </div>
    </div>

    <hr class="my-0" />

    <div class="card-body">
        <div class="row p-sm-3 p-0">
            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                <h5 class="mb-1">Delivery First Name:</h5>
                @if($order->delivery)
                    <h6 class="mb-3">{{ $order->delivery->fname }}</h6>
                    <h5 class="mb-1"> Delivery Phone:</h5>
                    <h6 class="mb-3">{{ $order->delivery->country_code ?? '' }} {{ $order->delivery->phone ?? '' }}</h6>
                @else
                    <h6 class="mb-3">This Delivery Does not have last name</h6>
                @endif
                <h5 class="mb-1">User First Name:</h5>
                <h6 class="mb-3">{{ $order->user->fname }}</h6>
                <h5 class="mb-1">User Phone:</h5>
                <h6 class="mb-3">{{ $order->user->phone }}</h6>
                <h4 class="mb-1">User Address:</h4>
                <h5 class="mb-1">Title:</h5>
                <h6 class="mb-3">{{ $order->address->title }}</h6>
                <h5 class="mb-1">Building:</h5>
                <h6 class="mb-3">{{ $order->address->building }}</h6>
                <h5 class="mb-1">Street:</h5>
                <h6 class="mb-3">{{ $order->address->street }}</h6>
                <h5 class="mb-1">Apartment:</h5>
                <h6 class="mb-3">{{ $order->address->apartment }}</h6>
                <h5 class="mb-1">Instructions:</h5>
                <h6 class="mb-3">{{ $order->address->instructions }}</h6>

            </div>

            <div class="col-xl-6 col-md-12 col-sm-7 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                <h4 class="mb-1">Subtotal:</h4>
                <h6 class="mb-3">{{ $order->sub_total }} {{ ' ' }}{{ $defaultCurrency->isocode }}</h6>
                <h4 class="mb-1">Total:</h4>
                <h6 class="mb-3">{{ $order->total }}  {{ ' ' }} {{ $defaultCurrency->isocode }}</h6>
                <h4 class="mb-1">Sum:</h4>
                <h6 class="mb-3">{{ $order->sum }}   {{ ' ' }} {{ $defaultCurrency->isocode }}</h6>

                <h4 class="mb-1">Delivery Fees:</h4>
                <h6 class="mb-3">{{ $order->delivery_charge }}  {{ ' ' }} {{ $defaultCurrency->isocode }}</h6>

                <h4 class="mb-1">Delivery Time:</h4>
                <h6 class="mb-3">{{ $order->delivery_time }}</h6>

                <h4 class="mb-1">District:</h4>
                <h6 class="mb-3">{{ $order->district->name ?? '' }}</h6>
            </div>
        </div>

        <h3 class="mb-1">Offer:</h3>
        @if($order->offer)
            <h5 class="mb-1">Discount Percentage:</h5>
            <h6 class="mb-3">{{ $order->offer->discount_percentage  }} {{ '%' }}</h6>
            <h5 class="mb-1">Is Free Delivery:</h5>
            <h6 class="mb-3">{{ $order->offer->free_delivery == 1 ? "True" : "False" }}</h6>
        @else
            <h6 class="mb-3">This Order Does not Use Offers</h6>
        @endif

        <h3 class="mb-1">Coupon:</h3>
        @if($order->coupon)
            <h5 class="mb-1">Percentage:</h5>
            <h6 class="mb-3">
                {{ $order->coupon->discount_percentage ? $order->coupon->discount_percentage . ' %' : $defaultCurrency->isocode }}
                {{ $order->coupon->price ?? '' }}
            </h6>
        @else
            <h6 class="mb-3">This Order Does not Use Coupon</h6>
        @endif

        <h4 class="mb-1">Statuses:</h4>
        @foreach($order->statuses as $status)
            <h5 class="mb-3">{{ $status->name }}</h5>
        @endforeach

        <h5 class="my-3 text-center">Order Items</h5>
        <div class="table-responsive border-top" id="data-table2">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Sizes</th>
                        <th>Preference</th>
                        <th>Option</th>
                        <th>Gift</th>
                        <th>Add Ingredients</th>
                        <th>Remove Ingredients</th>
                        <th>Sides</th>
                        <th>Drinks</th>
                        <th>Addons</th>
                        <th>Options</th>
                        <th>Quantity</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order->orderItems as $orderItem)
                        <tr>
                            <td>{{ $orderItem->item->name }}</td>
                            <td>
                                @if ($orderItem->item->price != null && $orderItem->item->price != 0)
                                    {{ $orderItem->item->price . $defaultCurrency->isocode }}
                                @else
                                    {{ $orderItem->item->points . " Point" }}
                                @endif
                            </td>
                            <td>{{ optional($orderItem->size)->name ?: 'No Size Available' }}</td>
                            <td>{{ optional($orderItem->preference)->name ?: 'No Preference Available' }}</td>
                            <td>{{ optional($orderItem->option)->name ?: 'No Option Available' }}</td>
                            <td>{{ optional($orderItem->gift)->name ?: 'No Gift Available' }}</td>
                            <td>
                                @forelse ($orderItem->addingredients as $addingredient)
                                    {{ $addingredient->name }} {{ $addingredient->price }}{{ $defaultCurrency->isocode }},
                                @empty
                                    No ingredients available.
                                @endforelse
                            </td>
                            <td>
                                @forelse ($orderItem->remove_ingredients as $removeingredient)
                                    {{ $removeingredient->name }} {{ $removeingredient->price }}{{ $defaultCurrency->isocode }},
                                @empty
                                    No ingredients available.
                                @endforelse
                            </td>
                            <td>
                                @forelse ($orderItem->sides as $side)
                                    {{ $side->name }} {{ $side->price }}{{ $defaultCurrency->isocode }},
                                @empty
                                    No Sides available.
                                @endforelse
                            </td>
                            <td>
                                @forelse ($orderItem->drinks as $drink)
                                    {{ $drink->name }} {{ $drink->price }}{{ $defaultCurrency->isocode }},
                                @empty
                                    No Drinks available.
                                @endforelse
                            </td>
                            <td>
                                @forelse ($orderItem->addons as $addon)
                                    {{ $addon->name }} {{ $addon->price }}{{ $defaultCurrency->isocode }},
                                @empty
                                    No Addon available.
                                @endforelse
                            </td>
                            <td>
                                @forelse ($orderItem->options as $option)
                                    {{ $option->name }} {{ $option->price }}{{ $defaultCurrency->isocode }},
                                @empty
                                    No Option available.
                                @endforelse
                            </td>
                            <td>{{ $orderItem->qty }}</td>
                            <td>{{ $orderItem->notes }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No order items available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body mx-3">
            <div class="row">
                <div class="col-12">
                    <!-- Additional content or actions can be added here -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
