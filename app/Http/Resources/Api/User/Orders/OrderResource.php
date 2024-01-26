<?php

namespace App\Http\Resources\Api\User\Orders;

use App\Http\Resources\Api\User\Address\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
      "coupon_discount" => $this->coupon->discount_percentage ." %" ?? null,
      "driver_name" => $this->delivery->fname ?? null,
      "driver_image" => $this->delivery->image ?? null,
      "driver_phone" => $this->delivery->phone ?? null,

      'total' => (double) $this->total,
      'sub_total' => (double) $this->sub_total,
      'sum' => (double) $this->sum,
      'points' => $this->points,
      'payment_type' => $this->payment_type,
      "transaction_id" => $this->transaction_id,
      'address_id' => AddressResource::make($this->address->first()),
      'currency' => $this->currency->isocode,
      'delivery_time' => $this->delivery_time ?? null,
      'delivery_fees' => (double) $this->delivery_charge ?? null,
      'status' => $this->status->name ?? null,







    ];
  }
}
