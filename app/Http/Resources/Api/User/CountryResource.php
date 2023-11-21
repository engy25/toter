<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
        'id'=>$this->id,
        'flag'=>$this->flag,
        'name'=>$this->name,
        'country_code'=>$this->country_code,

        ];
    }
}
