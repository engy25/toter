<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Review, Favourite};
use Carbon\Carbon;
class SimpleItemResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $reviews_count = Review::where("reviewable_type", "App\Models\Item")
      ->where("reviewable_id", $this->id)->count();

    $fav = false;

    /**check user auth */
    if (auth('api')->check()) {

      $fav = Favourite::where('favoriteable_type', 'App\Models\Item')
        ->where('favoriteable_id', $this->id)->where('user_id', auth('api')->user()->id)->first();
      ($fav) ? $fav = true : $fav = false;

    }
    $to_currency='';
    if($this->store->exchange_rate!=0)
    {
      $to_currency=$this->store->toCurrency->name;
    }else{
      $to_currency='';
    }




    return [
      "id" => $this->id,
      "name" => $this->name,
      "image"=>$this->image,
      "price"=>(double)$this->price,
      "currency" => $this->currency,
      // "default_currency"=>$this->store->defaultCurrency->name,
      // "to_currency"=>$to_currency,
      // 'exchange_rate'=>(double)$this->exchange_rate,
      "delivery_time" => $this->store->delivery_time." ".trans("api.unit"),
      "reviews_count" => $reviews_count,
      "subSection_name"=>$this->subsection->name ??null,
      'rating' => $this->reviews->isEmpty() ? 0 : (double) round($this->reviews->pluck('rating')->sum() / $this->reviews->pluck('rating')->count(), 1),
      'favourite' => ($fav) ? 1 : 0,
      'popuar'=>$this->status
    ];
  }
}
