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

      'service_charge'=>$this->service_charge,
      'delivery_fees'=> (double) $this->expected_delivery_charge ?? null,
      'expected_cost' => (double) $this->expected_cost,

      'total' => (double) $this->total,
      'sub_total' => (double) $this->sub_total,
      'sum'=>(double)$this->sum,
      'from_district'=>optional($this->district)->from->name ??null,
      'to_district'=>optional($this->district)->to->name ??null,


      'currency' => $this->defaultCurrency->isocode,
      'delivery_time' => $this->delivery_time ?? null,

      'status' => $this->status->name,
      'from_address' => AddressResource::make($this->fromAddress->first()) ?? null,
      'to_address' => AddressResource::make($this->toAddress->first()) ?? null,






    ];
  }
}

