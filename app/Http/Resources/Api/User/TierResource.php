<?php

namespace App\Http\Resources\Api\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TierResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $user = auth('api')->user();

    if ($user && $user->tier_id == 1) {
      $text = trans('api.text_of_tier', [
        'count' => $this->orders_count - $this->count_orders_created_this_month(),
        'duration' => now()->endOfMonth()->format('F j'),
      ]);
    } else {
      $text = trans('api.text_of_goldeen_tier');
    }

    return [
      "id" => $this->id,
      'image' => $this->image,
      'name' => $this->name,
      'description' => $this->description,
      'orders_make_This_month' => $this->count_orders_created_this_month(),
      'text' => $text,
      'points' => $this->userPoints(),
    ];


  }
}
