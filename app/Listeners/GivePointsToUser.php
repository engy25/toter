<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use App\Models\{PointStore, Order};
use App\Models\PointUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GivePointsToUser
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   *
   * @param  \App\Events\OrderCompleted  $event
   * @return void
   */
  public function handle(OrderCompleted $event)
  {
    //
    $order = $event->order;
    $orderSubTotal = $order->sub_total;
    $storeId = $order->store_id;
    $userId = auth('api')->user()->id;
    $userOrdersCount = Order::where("user_id", $userId)->where('store_id', $storeId)->count();

    $pointStore = $order->store->pointstore;

    if ($pointStore && $pointStore->min_price <= $orderSubTotal && $pointStore->order_counts <= $userOrdersCount) {
      $pointUserExists = PointUser::where("user_id", $userId)
        ->where("pointeable_type", PointStore::class)
        ->where("pointeable_id", $pointStore->id)
        ->where("user_id", $userId)
        ->exists();

      if (!$pointUserExists) {
        $currentDate = now();
        PointUser::create([
          "user_id" => $userId,
          "pointeable_type" => PointStore::class,
          "pointeable_id" => $pointStore->id,
          "point_earned" => $pointStore->points_earned,
          'expired_at' => $currentDate->addDays($pointStore->expire_days),
          'order_id'=>$order->id
        ]);
      }

    }




  }
}
