<table id="data-table2" class="table border p-0 text-nowrap mb-0">
  <thead class="tabel-row-heading text-dark">
    <tr style="background:#f4f5f7">
      <th class="fw-semibold border-bottom">{{ trans('words.order') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.isCoupon') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.subtotal') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.delivery_charge') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.total') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.delivery') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.date') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.status') }}</th>

    </tr>
  </thead>
  <tbody>
    @foreach($orders as $order)
    <tr>
      <td>
        @if ($order->orderItems->isNotEmpty())
        @foreach($order->orderItems as $orderItem)
        <span class="text-dark fs-13 fw-semibold">{{ $orderItem->item->name }}</span><br>
        @endforeach
        @else
        <!-- Handle the case when there are no order items -->
        <span>No items available</span>
        @endif
      </td>

      <td>
        @if ($order->coupon)
        <span class="text-dark fs-13 fw-semibold">{{ $order->coupon->discount_percentage }} %</span><br>

        @else
        <!-- Handle the case when there are no order items -->
        <span>False</span>
        @endif
      </td>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $order->sub_total }} {{ $defaultCurrency->isocode }}</span>
      </td>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $order->delivery_charge }} {{ $defaultCurrency->isocode }}</span>
      </td>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $order->total }} {{ $defaultCurrency->isocode }}</span>
      </td>
      <td>
        @if($order->driver)
        <span class="text-dark fs-13 fw-semibold">{{ $order->driver->fname }} </span>
        @else
        <span class="text-dark fs-13 fw-semibold">Not Assigned</span>
        @endif
      </td>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $order->created_at->format('Y-m-d') }}</span>
      </td>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $order->status->name }}</span>
      </td>

    </tr>
    @endforeach
  </tbody>
</table>

<div class="mt-4 d-flex justify-content-center">
  @if ($orders->lastPage() > 1)
  {{ $orders->links('pagination.simple-bootstrap-4') }}
  @endif
</div>
</div>
