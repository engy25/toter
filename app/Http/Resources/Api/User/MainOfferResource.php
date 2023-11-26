<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Review, Item, Favourite};

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
    $reviews_count = Review::where("reviewable_type", "App\Models\Offer")
      ->where("reviewable_id", $this->id)->count();

      $fav=false;

    /**check user auth */
    if (auth('api')->check()) {

      $fav = Favourite::where('favoriteable_type', 'App\Models\Offer')
        ->where('favoriteable_id', $this->id)->where('user_id', auth('api')->user()->id)->first();
      ($fav) ? $fav = true : $fav = false;

    }

    $items = new Item();
    return [
      "id" => $this->id,
      "icon" => $this->subsection->image,
      "title"=>$this->title,
      "name" => $this->name,
      "description" => $this->description,
      "discount_percentage" => $this->discount_percentage,
      "required_points" => $this->required_points,
      "tier" => $this->tier->name,
      "sub_section" => $this->subsection->name,
      "store" => $this->store->name,
      "reviews_count" => $reviews_count,
      'rating' => $this->reviews->isEmpty() ? 0 : (double) round($this->reviews->pluck('rating')->sum() / $this->reviews->pluck('rating')->count(), 1),
      'favourite' => ($fav) ? 1 : 0,
      "items" => SimpleItemResource::collection($items->where('has_offer', 1)->where("store_id", $this->store_id)->get())
    ];
  }
}
