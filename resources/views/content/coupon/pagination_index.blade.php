<?php
$i=0;
?>
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table id="data-table25" class="table border p-0 text-nowrap mb-0">
        <thead class="tabel-row-heading text-dark">
          <tr style="background:#f4f5f7">
            <th class="fw-semibold border-bottom">ID</th>
            <th class="fw-semibold border-bottom">{{ trans('words.storename') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.code') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.discount_percentage') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.discount_price') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.expire_date') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.isActive') }}</th>
            <th class="bg-transparent fw-semibold border-bottom">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($coupons as $coupon)
          <tr>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">
                @if($coupon->store !=null)
                @if ($coupon->store->translations->isNotEmpty())
                {{ $coupon->store->translations[0]->name }}
                @else
                {{ $store->name }}
                @endif
                @else
                {{ "Company" }}
                @endif
              </span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $coupon->code }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $coupon->discount_percentage ?? "Null" }} </span>
            </td>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $coupon->price?? "Null" }} </span>
            </td>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $coupon->expire_date }}</span>
            </td>

            <td>
              @if($coupon->is_active==1)
              <div>
                <span class="badge text-white bg-success fw-semibold fs-11">True</span>
              </div>
              @else
              <div>
                <span class="badge text-white bg-danger fw-semibold fs-11">False</span>
              </div>
              @endif
            </td>



            <td class="center align-middle">
              <div class="btn-group">

                @if($coupon->store_id !=null)
                <a href="{{ route('coupons.edit', $coupon->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>
                <a href="{{ LaravelLocalization::localizeURL(route('coupons.edit', $coupon->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 update_coupon_form" data-bs-toggle="modal"
                  data-bs-target="#updateCouponModal" data-id="{{ $coupon->id }}"
                  data-discount_percentage="{{ $coupon->discount_percentage }}" data-code="{{ $coupon->code }}"
                  data-store_id="{{ $coupon->store_id }}" data-is_active="{{ $coupon->is_active }}"
                  data-expire_date="{{ $coupon->expire_date }}"
                  data-max_user_used_code="{{ $coupon->max_user_used_code	 }}" title="Edit"
                  style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>
                @else
                <a href="{{ route('update.coupon.com', $coupon->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>
                <a href="{{ LaravelLocalization::localizeURL(route('update.coupon.com', $coupon->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 update_couponCom_form" data-bs-toggle="modal"
                  data-bs-target="#updateCouponToComModal" data-id="{{ $coupon->id }}"
                  data-discount_percentage="{{ $coupon->discount_percentage }}" data-code="{{ $coupon->code }}"
                  data-store_id="{{ $coupon->store_id }}" data-is_active="{{ $coupon->is_active }}"
                  data-expire_date="{{ $coupon->expire_date }}"
                  data-max_user_used_code="{{ $coupon->max_user_used_code	 }}" title="Edit"
                  style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>
                @endif



                <a href="{{ route('coupons.show', $coupon->id) }}" class="btn btn-success show-offer"
                  style="width: 100px; height: 40px;">
                  <i class="bi bi-eye"></i> {{ trans('words.show') }}
                </a>&nbsp;&nbsp;



                <button type="button" class="btn btn-danger delete-coupon" data-id="{{ $coupon->id }}"
                  style="width: 100px; height: 40px;">
                  <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-4">
        @if ($coupons->lastPage() > 1)
        {{ $coupons->links('pagination.simple-bootstrap-4') }}
        @endif
      </div>

    </div>
