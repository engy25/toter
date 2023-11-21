<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TierResource extends JsonResource
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
          'orders_count'=>$this->orders_count,
          'duration_bydays'=>$this->duration_bydays,
          'expired_duration_bydays'=>$this->expired_duration_bydays,
          'earn_reward_point'=>$this->earn_reward_point,
          'image'=>$this->image,
          'name'=>$this->name,
          'description'=>$this->description
        ];
    }
}
