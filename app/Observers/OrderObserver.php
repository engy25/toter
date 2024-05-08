<?php

namespace App\Observers;

use App\Models\{Order, Role, StatusTranslation, User,Currency};
use Illuminate\Support\Str;

class OrderObserver {
  /**
   * Handle the Order "created" event.
   *
   * @param  \App\Models\Order  $order
   * @return void
   */
  public function creating(Order $order) {
    //
   
    $status_pending = StatusTranslation::where("name", "pending")->first();

    $defaultCurrency=Currency::where("default",1)->value("id");

    $order->order_number = Str::random(10); // generates a random string of length 10
    $order->default_currency_id =$defaultCurrency;

    $order->user_id = auth("api")->user()->id;
    $order->status_id = $status_pending->status_id;


  }

  /**
   * Handle the orders "updated" event.
   *
   * @param  \App\Models\Order  $Order
   * @return void
   */
  public function updated(Order $order) {
    //
  }

  /**
   * Handle the orders "deleted" event.
   *
   * @param  \App\Models\Order  $order
   * @return void
   */
  public function deleted(Order $orders) {
    //
  }

  /**
   * Handle the orders "restored" event.
   *
   * @param  \App\Models\Order  $order
   * @return void
   */
  public function restored(Order $order) {
    //
  }

  /**
   * Handle the orders "force deleted" event.
   *
   * @param  \App\Models\Order  $order
   * @return void
   */
  public function forceDeleted(Order $order) {
    //
  }
}
