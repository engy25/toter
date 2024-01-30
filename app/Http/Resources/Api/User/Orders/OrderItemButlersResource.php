<?php

namespace App\Http\Resources\Api\User\Orders;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemButlersResource extends JsonResource
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
          "id"=>$this->id,
          "item"=>$this->item,
          "image"=>$this->image
        ];
    }
}
