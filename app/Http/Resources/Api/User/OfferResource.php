<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OfferResource extends JsonResource
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
          "id"=>$this->id,
          "image"=>$this->image,
          "name"=>$this->name,
          "title"=>$this->title,
          "description"=>$this->description,
          "discount_percentage"=>$this->discount_percentage,
          "required_points"=>$this->required_points,
          "tier"=>$this->tier->name,
          "sub_section"=>$this->subsection->name,
          "store"=>$this->store->name,
          "from_date" => Carbon::parse($this->from_date)->format("Y-m-d"),
          "to_date"=>Carbon::parse($this->to_date)->format("Y-m-d")
        ];
    }
}
