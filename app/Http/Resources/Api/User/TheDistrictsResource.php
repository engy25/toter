<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class TheDistrictsResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {

    $firstStore = $this->resource->stores->first();
    $delivery_charge = $firstStore ? (double) $firstStore->pivot->delivery_charge : null;


    return [
      "id" => $this->id,
      "name" => $this->name,
      "delivery_charge" =>$delivery_charge,
    ];
  }
}
