<?php

namespace App\Http\Resources\Api\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Country;
class SimpleDeliveryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      $countries = Country::where("country_code", $this->country_code)->first();



      return [
          'id' => $this->id,
          'firstname' => $this->fname,
          'last_name'=>$this->lname,
          'nickname'=>$this->nickname,
          'dob'=>optional($this->dob)->format('d F Y'),
          'is_active' => (boolean) $this->is_active,
          'country_code' => $this->country_code,
          'image' => $this->image,
          'phone' => $this->phone,
          'flag' => $countries->flag,
          'email' => $this->email ?? null,
          'token' => $this->when($this->token, $this->token),


      ];
    }
}
