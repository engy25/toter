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
    $addIngredientsID = json_decode($this->addingredients);
    $addIingredients = $addIngredientsID == null ? null : Ingredient::whereIn('id', $addIngredientsID)->get();


    $removeIngredientsID = json_decode($this->remove_ingredients);
    $removeIngredients = $removeIngredientsID == null ? null : Ingredient::whereIn('id', $removeIngredientsID)->get();

    $optionsID = json_decode($this->options);
    $options = $optionsID == null ? null : Option::whereIn('id', $optionsID)->get();

    $servicesID = json_decode($this->services);
    $services = $servicesID == null ? null : Service::whereIn('id', $servicesID)->get();



    $sidesID = json_decode($this->sides);
    $sides = $sidesID == null ? null : Side::whereIn('id', $sidesID)->get();

    $addonsID = json_decode($this->addons);
    $addons = $addonsID == null ? null : Addon::whereIn('id', $addonsID)->get();

    $drinksID = json_decode($this->drinks);
    $drinks = $drinksID == null ? null : Drink::whereIn('id', $drinksID)->get();

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
      "addIngredients" => $addIingredients ? ItemResource::collection($addIingredients) : [],
      "removeIngredients" => $removeIngredients ? ItemResource::collection($removeIngredients) : [],
      "options" => $options ? ItemResource::collection($options) : [],
      "services" => $services ? ItemResource::collection($services) : [],
      "sides" => $sides ? ItemResource::collection($sides) : [],
      "addons" => $addons ? ItemResource::collection($addons) : [],
      "drinks" => $drinks ? ItemResource::collection($drinks) : [],
    ];
  }
}
