<?php

namespace App\Http\Resources\Api\User;

use App\Http\Resources\TierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

     
      /**check if the user auth */
      if(auth('api')->check())
      {
        "tier"==new TierResource($this->tier);

      }else{
        "tier"==null;

      }
        return[

        ] ;
    }
}
