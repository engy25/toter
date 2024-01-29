<?php

namespace App\Http\Resources\Api\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{StatusTranslation,Currency};
use App\Http\Resources\Api\User\Address\AddressResource;
class SimpleOrderUserResource extends JsonResource
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
      'item_image' => $firstItem->item->image,
      'item_name' => $firstItem->first()->item->name,
      'item_qty' => $firstItem->qty,
      'total' => (double) $this->total,
      'sub_total' => (double) $this->sub_total,
      'points'=>$this->points,
      'sum' => (double) $this->sum,
      'currency' => $this->currency->isocode,
      'delivery_time' => $this->delivery_time ?? null,
      'delivery_fees' => (double) $this->delivery_charge ?? null,
      'status' => $this->status->name ?? null,
      'address' => AddressResource::make($this->address->first()),






    ];
  }
}
