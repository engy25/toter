<?php

namespace App\Http\Resources\Api\User\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      return[
        'id'=>$this->id,
        "user_id"=>auth('api')->user()->id,
        'name'=>auth('api')->user()->fname,
        'title'=>$this->title,
        'building'=>$this->building,
        'street'=>$this->street,
        'apartment'=>$this->apartment,
        "phone"=>$this->phone,
        'default'=>$this->default,
        'country_code'=>$this->country_code,
        'lat'=>$this->lat,
        'lng'=>$this->lng,
        'instructions'=>$this->instructions

    ];
    }
}
