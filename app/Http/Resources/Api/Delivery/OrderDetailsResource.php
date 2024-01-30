<?php

namespace App\Http\Resources\Api\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\User\Address\AddressResource;
class OrderDetailsResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'order_number' => $this->order_number,
      'store_id' => $this->store_id ?? null,
      'store_image' => $this->store->image,
      'store_name' => $this->store->translation->name ?? null,
      "offer_id" => $this->offer_id,
      "coupon_discount" => optional($this->coupon)->discount_percentage . " %" ?? null,
      "user_name" => $this->user->fname ?? null,
      "user_image" => $this->user->image ?? null,
      "user_phone" => $this->user->phone ?? null,

      "delivery_name" => $this->driver->fname ?? $this->delivery->fname ??null,
      "delivery_image" => $this->driver->image ?? $this->delivery->image ??null,
      "delivery_phone" => $this->driver->phone ?? $this->delivery->phone ??null,

      'total' => (double) $this->total,
      'sub_total' => (double) $this->sub_total,
      'sum' => (double) ($this->sum == 0 ? $this->total : $this->sum),

      'points' => $this->points ?? 0,
      'payment_type' => $this->payment_type,
      "transaction_id" => $this->transaction_id ??null,
      'address' => AddressResource::make($this->address->first()),
      'currency' => $this->currency->isocode,
      'delivery_time' => $this->delivery_time ?? null,
      'delivery_fees' => (double) $this->delivery_charge ?? null,
      'status' => $this->status->name ?? null,

    ];
  }
}
