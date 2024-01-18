<table style="border-collapse: collapse; width: 100%;">
  <thead>
    <tr>
      <th style="border: 1px solid black;">{{ trans('words.order') }}</th>
      <th style="border: 1px solid black;">{{ trans('words.isCoupon') }}</th>
      <th style="border: 1px solid black;">{{ trans('words.subtotal') }}</th>
      <th style="border: 1px solid black;">{{ trans('words.delivery_charge') }}</th>
      <th style="border: 1px solid black;">{{ trans('words.total') }}</th>
      <th style="border: 1px solid black;">{{ trans('words.delivery') }}</th>
      <th style="border: 1px solid black;">{{ trans('words.date') }}</th>
      <th style="border: 1px solid black;">{{ trans('words.status') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($orders as $order)
    <tr>
      <td style="border: 1px solid black;">
        @forelse ($order->orderItems as $orderItem)
        <span style="padding: 5px;">{{ $orderItem->item }}</span><br>
        @empty
        <span style="padding: 5px;">No items available</span>
        @endforelse
      </td>


      <td style="border: 1px solid black;">
        @if ($order->coupon)
        <span style="padding: 5px;">{{ $order->coupon->discount_percentage }} %</span><br>
        @else
        <!-- Handle the case when there are no order items -->
        <span style="padding: 5px;">False</span>
        @endif
      </td>

      <td style="border: 1px solid black;">
        <span style="padding: 5px;">{{ $order->sub_total }} {{ $defaultCurrency->isocode }}</span>
      </td>
      <td style="border: 1px solid black;">
        <span style="padding: 5px;">{{ $order->delivery_charge }} {{ $defaultCurrency->isocode }}</span>
      </td>
      <td style="border: 1px solid black;">
        <span style="padding: 5px;">{{ $order->total }} {{ $defaultCurrency->isocode }}</span>
      </td>
      <td style="border: 1px solid black;">
        @if ($order->driver)
        <span style="padding: 5px;">{{ $order->driver->fname }}</span>
        @else
        <span style="padding: 5px;">Not Assigned</span>
        @endif
      </td>
      <td style="border: 1px solid black;">
        <span style="padding: 5px;">{{ $order->created_at->format('Y-m-d') }}</span>
      </td>
      <td style="border: 1px solid black;">
        <span style="padding: 5px;">{{ $order->status->name }}</span>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
