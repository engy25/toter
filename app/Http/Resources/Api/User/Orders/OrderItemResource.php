<?php

namespace App\Http\Resources\Api\User\Orders;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Ingredient, Drink, Side, Size, Option, Service, Addon};
use App\Http\Resources\Api\User\{IngredientResource};
use App\Http\Resources\Api\User\Orders\ItemResource;

class OrderItemResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {


    $sizeId = $this->size_id ?? null;
    $preferenceId = $this->preference_id ?? null;
    $giftId = $this->gift_id ?? null;
    $optionId = $this->option_id ?? null;

    return [
      "id" => $this->id,
      "item_name" => $this->item->name,
      "item_image" => $this->item->image,
      "qty" => $this->qty,
      "size"=>$sizeId ? $this->size->name : null,
      "preference"=>$preferenceId ? $this->preference->name : null,
      "gift"=>$giftId ? $this->gift->name : null,
      "option"=>$optionId ? $this->option->name : null,
      "addIngredients" => ItemResource::collection($this->addingredients) ,
      "removeIngredients" => ItemResource::collection($this->remove_ingredients),
      "options" => ItemResource::collection($this->options) ,
      "services" => ItemResource::collection($this->services) ,
      "sides" => ItemResource::collection($this->sides) ,
      "addons" =>  ItemResource::collection($this->addons) ,
      "drinks" =>  ItemResource::collection($this->drinks),
    ];
  }
}
