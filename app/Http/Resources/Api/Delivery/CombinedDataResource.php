<?php

namespace App\Http\Resources\Api\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;

class CombinedDataResource extends JsonResource
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
          'Orders' => $this->resource['Orders'],
          'OrderButlers' => $this->resource['OrderButlers'],
          'OrderCallCenters' => $this->resource['OrderCallCenters'],
        ];
    }
}
