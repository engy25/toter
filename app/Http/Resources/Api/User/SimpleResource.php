<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{
    Country,
    Currency
};
use Carbon\Carbon;
use App\Http\Resources\TierResource;

class SimpleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
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
            'email_address' => $this->email_address,
            'orders_make_This_month'=> $this->count_orders_created_this_month(),
            'duration_expired'=>Carbon::now()->endOfMonth()->format('d F'),
            // 'tier'=>new TierResource($this->tier),
            'token' => $this->when($this->token, $this->token),


        ];
    }
}
