<?php

namespace App\Http\Resources\Api\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\User\Address\AddressResource;

class SimpleOrderButlerUserResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $firstItem = $this->orderItems()->first();


    return [
      'id' => $this->id,
      'order_item' => $firstItem->item ??null,
      'order_image' => $firstItem->image ?? null,

      'total' => (double) $this->total,
      'sub_total' => (double) $this->sub_total,
      'expected_delivery_charge' => (double) $this->expected_delivery_charge,
      'currency' => $this->defaultCurrency->isocode,
      'delivery_time' => $this->delivery_time ?? null,
      'delivery_fees' => (double) $this->delivery_charge ?? null,
      'status' => $this->status->name,
      'from_address' => AddressResource::make($this->fromAddress->first()) ?? null,
      'to_address' => AddressResource::make($this->toAddress->first()) ?? null,






    ];
  }
}

