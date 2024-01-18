<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class CitiesResource extends JsonResource
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
        "id" => $this->id,
        "name" => $this->name,
        // "districts" => DistrictResource::collection($this->districts)
        "districts" => TheDistrictsResource::collection($this->districts)



    ];
    }
}
