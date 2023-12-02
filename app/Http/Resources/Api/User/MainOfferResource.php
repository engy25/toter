<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Review, Item, Favourite,Store};

class MainOfferResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $reviews_count = Review::where("reviewable_type", "App\Models\Store")
      ->where("reviewable_id", $this->id)->count();

      $fav=false;

    /**check user auth */
    if (auth('api')->check()) {

      $fav = Favourite::where('favoriteable_type', 'App\Models\Store')
        ->where('favoriteable_id', $this->id)->where('user_id', auth('api')->user()->id)->first();
      ($fav) ? $fav = true : $fav = false;

    }

    $items = new Item();
    $stores=Store::where("sub_section_id",$this->subsection_id)->get();
    return [
      "offer_id" => $this->id,
      "offer_icon" => $this->subsection->image,
      "offer_title"=>$this->title,
      "offer_name" => $this->name,
      "offer_description" => $this->description,
      "offer_discount_percentage" => $this->discount_percentage,
      "offer_required_points" => $this->required_points,
      "tier" => $this->tier->name,
      "sub_section" => $this->subsection->name,
      // "stores"=>SimpleStoreResource::collection($stores)
      "store_id"=>$this->store->id,
      "store_name" => $this->store->name,
      "store_image" => $this->store->image,
      "price" => $this->store->price,

      "currency" => $this->store->defaultCurrency->name,
      "reviews_count" => $reviews_count,
      "delivery_time"=>$this->store->delivery_time,
      'rating' => $this->store->reviews->isEmpty() ? 0 : (double) round($this->store->reviews->pluck('rating')->sum() / $this->store->reviews->pluck('rating')->count(), 1),
      'favourite' => ($fav) ? 1 : 0,
      //"items" => SimpleItemResource::collection($items->where('has_offer', 1)->where("store_id", $this->store_id)->get())
    ];
  }
}
