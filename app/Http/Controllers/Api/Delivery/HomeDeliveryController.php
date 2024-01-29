<?php

namespace App\Http\Controllers\Api\Delivery;

use App\Http\Controllers\Controller;
use App\Models\OrderButler;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\{Order, User};
use App\Services\StatusService;
use App\Http\Resources\Api\Delivery\{SimpleOrderUserResource,SimpleOrderButlerUserResource};

class HomeDeliveryController extends Controller
{
  //
  public $helper;
  public $statusService;
  public function __construct()
  {
    $this->helper = new Helpers();
    $this->statusService = new StatusService();

  }

  public function index()
  {
    $userId = auth("api")->user()->id;
    $totalNumberOfOrders = User::totalNumberOfOrders($userId);
    $total_orders_at_the_end_of_the_month = User::total_orders_at_the_end_of_the_month($userId);
    $statusPending = $this->statusService->getStatusIdByName('pending');


    $orders = Order::where("driver_id", $userId)->where("status_id", $statusPending)->take(PAGINATION_COUNT)->get();
    $orderButlers = OrderButler::where("driver_id", $userId)->where("status_id", $statusPending)->take(PAGINATION_COUNT)->get();

    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      [
        "data" => [
          "status" => 1,
          "TotalNumberOfOrders" => $totalNumberOfOrders,
          "total_orders_at_the_end_of_the_month" => $total_orders_at_the_end_of_the_month,
          "Orders" => SimpleOrderUserResource::collection($orders),
          "OrderButlers"=> SimpleOrderButlerUserResource::collection($orderButlers)
        ]
      ]
    );
  }

}
