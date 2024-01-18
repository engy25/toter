<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Favourite, Review,Day};
use App\Helpers\Helpers;
use App\Http\Resources\Api\User\{ReviewResource, DrinkResource, IngredientResource, ServiceResource, OptionResource};

class ItemResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {

    $reviews = Review::where("reviewable_type", "App\Models\Item")
      ->where("reviewable_id", $this->id);

    $reviews_count = $reviews->count();
    $highest_rating = $reviews->whereNotNull("comment")->orderBy('rating', 'desc')->take(5)->get();

    $fav = false;

    /**check user auth */
    if (auth('api')->check()) {

      $fav = Favourite::where('favoriteable_type', 'App\Models\Item')
        ->where('favoriteable_id', $this->id)->where('user_id', auth('api')->user()->id)->first();
      ($fav) ? $fav = true : $fav = false;

    }

    /**check if this item has offer or not */
    $offer_name = '';
    $offer_description = '';

    if ($this->has_offer == 1 && $this->store->offer()) {

      $offer_name = $this->store->offer()->first()->name;
      $offer_description = Helpers::stripText($this->store->offer()->first()->description);
    }

    /**
     *
     */

    $to_currency = '';
    $to_price = 0;
    if ($this->store->exchange_rate != 0) {
      $to_currency = $this->store->toCurrency->name;
      $to_price = (double) $this->store->exchange_rate * $this->price;
    } else {
      $to_currency = '';
    }



    $returnData = [
      "id" => $this->id,
      "name" => $this->name,
      "description" => Helpers::stripText($this->translation->description),
      "image" => $this->image,
      'offer_name' => $offer_name,
      'offer_description' => $offer_description,
      "tag" => $this->category->name,
      "store" => $this->store->name,
      "subsection" => $this->subsection->name,
      "section" => $this->section->name,
      "price" => (double) $this->price,

      "currency" => $this->currency,
      //"default_currency" => $this->store->defaultCurrency->name,
      //"to_currency" => $to_currency,
      //"to_price" => $to_price,
      //'exchange_rate' => (double) $this->store->exchange_rate,
      "delivery_time" => $this->store->delivery_time . " " . trans("api.unit"),
      "reviews_count" => $reviews_count,
      'rating' => $this->reviews->isEmpty() ? 0 : (double) round($this->reviews->pluck('rating')->sum() / $this->reviews->pluck('rating')->count(), 1),
      'favourite' => ($fav) ? 1 : 0,
      'popuar' => $this->status,
      'delivery_fees' => $this->store->delivery_fees,
      'points'=>$this->points

    ];

   
    if ($this->Addingredients->isNotEmpty()) {
      $returnData['Add_ingredients'] = IngredientResource::collection($this->Addingredients);
    }

    if ($this->Removeingredients->isNotEmpty()) {
      $returnData['Remove_ingredients'] = IngredientResource::collection($this->Removeingredients);
    }

    if ($this->services->isNotEmpty()) {
      $returnData['choose_services'] = ServiceResource::collection($this->services);
    }

    if ($this->drinks->isNotEmpty()) {
      $returnData['choose_drinks'] = DrinkResource::collection($this->drinks);
    }

    if ($this->options->isNotEmpty()) {
      $returnData['choose_options'] = OptionResource::collection($this->options);
    }

    if ($this->sides->isNotEmpty()) {
      $returnData['sides'] = SideResource::collection($this->sides);
    }

    if ($this->gifts->isNotEmpty()) {
      $returnData['gifts'] = GiftResource::collection($this->gifts);
    }

    if ($this->preferences->isNotEmpty()) {
      $returnData['preferences'] = PreferenceResource::collection($this->preferences);
    }

    if (!$this->reviews->isEmpty()) {
      $returnData['reviews'] = ReviewResource::collection($highest_rating);
    }

    if (isset($this->store->delivery_time)) {
      $returnData['delivery_time'] = $this->store->delivery_time . " " . trans("api.unit");
    }

    $returnData['reviews_count'] = $reviews_count;
    $returnData['rating'] = $this->reviews->isEmpty() ? 0 : (double) round($this->reviews->pluck('rating')->sum() / $this->reviews->pluck('rating')->count(), 1);
    $returnData['favourite'] = ($fav) ? 1 : 0;

    return $returnData;
  }

}
