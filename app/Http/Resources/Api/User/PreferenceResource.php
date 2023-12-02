<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;

class PreferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      $to_currency = '';
      $to_price=0;
      if ($this->store->exchange_rate != 0) {
        $to_currency = $this->store->toCurrency->name;
        $to_price=(double)$this->store->exchange_rate * $this->price;
      } else {
        $to_currency = '';
      }
        return [
          "id"=>$this->id,
          "name"=>$this->name,
          "image"=>$this->image,
          "price" => (double) $this->price,
          "default_currency" => $this->store->defaultCurrency->name,
          "to_currency" => $to_currency,
          "to_price"=>$to_price,
          'exchange_rate' => (double) $this->store->exchange_rate,
        ];
    }
}
