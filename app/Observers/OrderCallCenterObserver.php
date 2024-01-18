<?php

namespace App\Observers;

use App\Models\{OrderCallCenter, Status, Role, StatusTranslation, User};
use App\Models\Currency;
use Illuminate\Support\Str;

class OrderCallCenterObserver
{
  /**
   * Handle the OrderCallCenter "created" event.
   *
   * @param  \App\Models\OrderCallCenter  $orderCallCenter
   * @return void
   */

  public function saving(OrderCallCenter $orderCallCenter)
  {
    $status_pending = StatusTranslation::where("name", "pending")->first();

    $defaultCurrency = Currency::where("default", 1)->first();


    $orderCallCenter->order_number = Str::random(10); // generates a random string of length 10
    $orderCallCenter->status_id = $status_pending->status_id;
    $orderCallCenter->callcenter_id = auth()->user()->id;
    $orderCallCenter->currency_id = $defaultCurrency->id;
    

  }

  public function created(OrderCallCenter $orderCallCenter)
  {




  }

  /**
   * Handle the OrderCallCenter "updated" event.
   *
   * @param  \App\Models\OrderCallCenter  $orderCallCenter
   * @return void
   */
  public function updated(OrderCallCenter $orderCallCenter)
  {
    //
  }

  /**
   * Handle the OrderCallCenter "deleted" event.
   *
   * @param  \App\Models\OrderCallCenter  $orderCallCenter
   * @return void
   */
  public function deleted(OrderCallCenter $orderCallCenter)
  {
    //
  }

  /**
   * Handle the OrderCallCenter "restored" event.
   *
   * @param  \App\Models\OrderCallCenter  $orderCallCenter
   * @return void
   */
  public function restored(OrderCallCenter $orderCallCenter)
  {
    //
  }

  /**
   * Handle the OrderCallCenter "force deleted" event.
   *
   * @param  \App\Models\OrderCallCenter  $orderCallCenter
   * @return void
   */
  public function forceDeleted(OrderCallCenter $orderCallCenter)
  {
    //
  }
}
