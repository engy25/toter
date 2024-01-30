<?php

namespace App\Http\Resources\Api\User\Orders;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleOrderResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $firstItem = $this->orderItems()->first() ?? null;
    //dd($firstItem->item->name);



    return [
      'id' => $this->id,
      'order_number' => $this->order_number,
      'store_id' => $this->store_id ?? null,
      'store_image' => $this->store->image,
      'store_name' => $this->store->translation->name ?? null,
      //'item_image' => optional($firstItem->item->image) ?? optional($firstItem->item),
      'item_name' => optional(optional($firstItem)->item)->name ?? null,
      'item_image' => optional(optional($firstItem)->item)->image ?? null,

      'item_qty' => optional($firstItem)->qty ?? 0,

      'total' => (double) $this->total,
      'sub_total' => (double) $this->sub_total,
      'points' => $this->points,
      'sum' => (double) $this->sum,
      'currency' => $this->currency->isocode,
      'delivery_time' => $this->delivery_time ?? null,
      'delivery_fees' => (double) $this->delivery_charge ?? null,
      'status' => $this->status->name ?? null,






    ];
  }
}
