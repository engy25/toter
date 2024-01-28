<?php

namespace App\Http\Resources\Api\User\Carts;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $cartItemsPrice = 0;
    $cartItemsPrice += $this->item->price ?? 0;
    $cartItemsPrice += $this->cartItems()->get()->sum('price');
    $cartItemsPrice += $this->size->price ?? 0;
    $cartItemsPrice += $this->preference->price ?? 0;
    $cartItemsPrice += $this->option->price ?? 0;
    $cartItemsPrice *= $this->qty;
    return [
      "id" => $this->id,
      "store_name" => $this->store->name ?? null,
      "store_image" => $this->store->image ?? null,
      "item_name" => $this->item->name ?? null,
      "item_image" => $this->item->image ?? null,
      "item_price" => $this->item->price,
      "points" => $this->item->points,
      "qty" => $this->qty,
      "total" => $cartItemsPrice,
      "currency" => $this->item->currencyIsoCode,


    ];
  }
}
