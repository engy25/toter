<?php

namespace App\Observers;

use App\Models\{OrderButler, Role, User,Status,OrderStatus};
use App\Models\StatusTranslation;
use Illuminate\Support\Str;

class OrderButlerObserver
{
  /**
   * Handle the OrderButler "created" event.
   *
   * @param  \App\Models\OrderButler  $orderButler
   * @return void
   */
  public function creating(OrderButler $orderButler)
  {
    //
    $roleAdminId = Role::where("name", "Admin")->first()->id;
    $roleDeliveryId=Role::where("name", "Delivery")->first()->id;
    $status_pending=StatusTranslation::where("name","pending")->first();
    $driver=new User();


    $orderButler->order_number = Str::random(10); // generates a random string of length 10
    //$orderButler->admin_id = User::where("role_id", $roleAdminId);
    $orderButler->user_id = auth("api")->user()->id;
    $orderButler->status_id = $status_pending->status_id;

    $orderButler->driver_id=$driver->assignDriverToOrderButler($orderButler)->id;


  }


  /**
   * Handle the OrderButler "updated" event.
   *
   * @param  \App\Models\OrderButler  $orderButler
   * @return void
   */


  /**
   * Handle the OrderButler "deleted" event.
   *
   * @param  \App\Models\OrderButler  $orderButler
   * @return void
   */
  public function deleted(OrderButler $orderButler)
  {
    //
  }

  /**
   * Handle the OrderButler "restored" event.
   *
   * @param  \App\Models\OrderButler  $orderButler
   * @return void
   */
  public function restored(OrderButler $orderButler)
  {
    //
  }

  /**
   * Handle the OrderButler "force deleted" event.
   *
   * @param  \App\Models\OrderButler  $orderButler
   * @return void
   */
  public function forceDeleted(OrderButler $orderButler)
  {
    //
  }
}
