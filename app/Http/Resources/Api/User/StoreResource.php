<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Review, Favourite};
use App\Http\Resources\Api\User\{CategoryResource,ReviewResource};
class StoreResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $reviews = Review::where("reviewable_type", "App\Models\Store")
      ->where("reviewable_id", $this->id);

    $reviews_count=$reviews->count();
    $highest_rating=$reviews->whereNotNull("comment")->orderBy('rating','desc')->take(5)->get();



    $fav = false;

    /**check user auth */
    if (auth('api')->check()) {

      $fav = Favourite::where('favoriteable_type', 'App\Models\Store')
        ->where('favoriteable_id', $this->id)->where('user_id', auth('api')->user()->id)->first();
      ($fav) ? $fav = true : $fav = false;

    }
    $offer_name = "";
    $offer_discount_percentage = 0;


    if ($this->is_offered == 1 && $this->offers()) {

      $offer_name = $this->offers()->first()->name;
      $offer_discount_percentage = $this->offers()->first()->discount_percentage;
    }
    return [
      "id" => $this->id,
      "name" => $this->name,
      "image" => $this->image,
      "price" => (double) $this->price,
      "currency" => $this->defaultCurrency->name,
      "exchange_rate"=>(double)$this->exchange_rate,
      "to_currency"=>$this->toCurrency->name,
      'offer_name' => $offer_name,
      'offer_discount' => (int) $offer_discount_percentage . '' . '%',
      "delivery_time" => $this->delivery_time . " " . trans("api.unit"),
      'status' => $this->statusvalue,
      'working_hours' => $this->TodayWorkingHours,
      "reviews"=>ReviewResource::collection($highest_rating),
      "reviews_count" => $reviews_count,
      'rating' => $this->reviews->isEmpty() ? 0 : (double) round($this->reviews->pluck('rating')->sum() / $this->reviews->pluck('rating')->count(), 1),
      'favourite' => ($fav) ? 1 : 0,
      "tags" => CategoryResource::Collection($this->tags),

    ];
  }
}
