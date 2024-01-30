<?php

namespace App\Http\Resources\Api\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\User\Address\AddressResource;

class OrderButlersResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    // $firstItem = $this->orderItems()->first();


    return [
      'id' => $this->id,
      'order_number' => $this->order_number,
      // 'order_item' => $firstItem->item ??null,
      // 'order_image' => $firstItem->image ?? null,
      'delivery_name' => $this->delivery->fname ?? null,
      'delivery_phone' => $this->driver->phone ?? null,

      'user_name' => $this->user->fname ?? null,
      'user_phone' => $this->user->phone,
      'expected_delivery_charge' => (double) $this->expected_delivery_charge,
      'expected_cost' => (double) $this->expected_cost,
      'total' => (double) $this->total,
      'sub_total' => (double) $this->sub_total,
      "coupon_id" => $this->coupon_id,
      "coupon_discount_percentage" => optional($this->coupon)->discount_percentage . " %" ?? 0,
      "coupon_discount_price" => optional($this->coupon)->discount_price ?? 0,
      'currency' => $this->defaultCurrency->isocode,
      'delivery_time' => $this->delivery_time ?? null,
      'delivery_fees' => (double) $this->delivery_charge ?? null,
      'status' => $this->status->name,
      'from_address' => AddressResource::make($this->fromAddress->first()) ?? null,
      'from_driver_instructions' => $this->from_driver_instructions ?? null,
      'to_address' => AddressResource::make($this->toAddress->first()) ?? null,
      'to_driver_instructions' => $this->to_driver_instructions ?? null,


    ];
  }
}

