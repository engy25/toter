<?php

namespace App\Http\Controllers\Api\Delivery;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Http\Resources\Api\User\Orders\{OrderItemResource, OrderItemButlersResource};
use App\Models\{Order, User, Notification, OrderCallcenter, OrderButler, Device, Delivery, OrderStatus};
use App\Services\StatusService;
use App\Http\Resources\Api\Delivery\{SimpleOrderUserResource, OrderDetailsResource, SimpleOrderButlerUserResource, orderButlersResource, CombinedDataResource};
use App\Http\Requests\Api\Delivery\{AcceptTypeRequest, UpdateLocationRequest};
use App\Events\DeliveryUpdatedLocation;

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
    $orderCallcenters = OrderCallcenter::where("delivery_id", $userId)->where("status_id", $statusPending)->take(PAGINATION_COUNT)->get();

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
          "OrderButlers" => SimpleOrderButlerUserResource::collection($orderButlers),
          "OrderCallCenters" => SimpleOrderUserResource::collection($orderCallcenters)
        ]
      ]
    );
  }


  public function acceptOrder(AcceptTypeRequest $request)
  {
    $userId = auth("api")->user()->id;
    $statusPending = $this->statusService->getStatusIdByName('pending');
    $statusConfirm = $this->statusService->getStatusIdByName('confirm ');
    $orderType = ucfirst($request->type);

    // $orderModel = 'App\Models\';
    $orderModel = "App\\Models\\" . $orderType;


    $deliveryName = ($orderType === "OrderButler" || $orderType === "Order") ? "driver_id" : "delivery_id";
    // dd($deliveryName);


    $order = $orderModel::whereId($request->id)
      ->where([$deliveryName => $userId])
      ->where("status_id", $statusPending)
      ->first();

    if ($order !== null) {
      $updatedRows = \DB::table((new $orderModel)->getTable())
        ->where('id', $request->id)
        ->where($deliveryName, $userId)
        ->where('status_id', $statusPending)
        ->update(['status_id' => $statusConfirm]);

      // Create a new status for the order
      OrderStatus::create([
        "status_id" => $statusConfirm,
        "ordereable_id" => $order->id,
        "ordereable_type" => $orderModel
      ]);

      return $this->helper->responseJson(
        'success',
        trans('api.you_accepted_the_order_successfully'),
        200,
        null
      );
    } else {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        401,
        null
      );
    }

  }

  public function cancelOrder(AcceptTypeRequest $request)
  {

    $userId = auth("api")->user()->id;
    $admins = User::role("Admin")->pluck("id")->toArray();

    $driver = new User();
    $statusPending = $this->statusService->getStatusIdByName('pending');
    // \DB::beginTransaction();
    // try {
    $orderType = ucfirst($request->type);

    $orderModel = "App\\Models\\" . $orderType;



    $deliveryName = (strcasecmp($orderType, "Order") == 0 || strcasecmp($orderType, "OrderButler") == 0) ? "driver_id" : "delivery_id";


    $order = $orderModel::whereId($request->id)
      ->where([$deliveryName => $userId])
      ->where("status_id", $statusPending)
      ->first();



    if ($order !== null) {
      $deliveryid = (strcasecmp($orderType, "Order") == 0 || strcasecmp($orderType, "orderCallcenter") == 0) ? $driver->assignDriverToOrder($order->store_id)->id : $driver->assignDriverToOrderButler($order)->id;


      $updatedRows = \DB::table((new $orderModel)->getTable())
        ->where('id', $request->id)
        ->where($deliveryName, $userId)
        ->where('status_id', $statusPending)
        ->update([$deliveryName => $deliveryid]);


      // lcobucci/jose

      /**
       * send notification to Admin
       */






      foreach ($admins as $admin) {
        $adminMessage = [
          "title_ar" => "هذا الدليفري الغي الطلب ",
          "title_en" => "The Delivery Cancelled The Order",
          "body_ar" => "الدليفري " . $userId . ".$order->order_number قام بالغاء الطلب ",
          "body_en" => "The Delivery" . $userId . "Cancelled The Order. $order->order_number",
        ];


        $newsNotification = new Notification;

        $newsNotification
          ->setTranslations('title', [
            'ar' => $adminMessage['title_ar'],
            'en' => $adminMessage['title_en'],
          ])
          ->setTranslations('data', [
            'ar' => $adminMessage['body_ar'],
            'en' => $adminMessage['body_en'],
          ])
          ->user_id = $admin; // Assuming $admin is the user ID

        $newsNotification->notifiable_type = $orderModel;
        $newsNotification->notifiable_id = $order->id;

        $newsNotification->save();


      }


      /**send notification to the delivery */

      $deviceId = Device::where("user_id", $userId)->pluck("device_token")->toArray();
      if (isset($deviceId)) {
        $userMessage = [
          "title_ar" => "تم الغاء الطلب ",
          "title_en" => "You Cancelled The order",
          "body_ar" => "تم الغاء الطلب بنجاح وبالفعل تم ترحيله الي دليفري اخر",
          "body_en" => "The order was successfully canceled and has already been transferred to another delivery ",
        ];
        $this->helper->androidPushNotification($deviceId, $userMessage);


        Notification::create([
          'user_id' => $userId,
          'title' => json_encode(['en' => $userMessage['title_en'], 'ar' => $userMessage['title_ar']]),
          'data' => json_encode(['en' => $userMessage['body_en'], 'ar' => $userMessage['body_ar']]),
          'notifiable_type' => $orderModel,
          'notifiable_id' => $order->id,
        ]);
      }




      \DB::commit();

      return $this->helper->responseJson(
        'success',
        trans('api.you_cancelled_the_order_successfully'),
        200,
        null
      );
    } else {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        401,
        null
      );
    }


    // } catch (\Exception $e) {
    //   \DB::rollBack();
    //   return $this->helper->responseJson('fail', trans('api.auth_failed'), 422, null);

    // }

  }

  public function indexHomeShow()
  {
    $userId = auth("api")->user()->id;

    $statusPending = $this->statusService->getStatusIdByName('pending');

    $orders = Order::where("driver_id", $userId)->where("status_id", $statusPending)->get();
    $orderButlers = OrderButler::where("driver_id", $userId)->where("status_id", $statusPending)->get();
    $orderCallcenters = OrderCallcenter::where("delivery_id", $userId)->where("status_id", $statusPending)->get();

    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      [
        [
          "Orders" => SimpleOrderUserResource::collection($orders),
          "OrderButlers" => SimpleOrderButlerUserResource::collection($orderButlers),
          "OrderCallCenters" => SimpleOrderUserResource::collection($orderCallcenters)
        ]
      ]
    );
  }


  public function orderDetails(AcceptTypeRequest $request)
  {
    $order = [];
    $userId = auth("api")->user()->id;
    $orderType = ucfirst($request->type);
    $orderModel = "App\\Models\\" . $orderType;

    $deliveryName = ($orderType === "OrderButler" || $orderType === "Order") ? "driver_id" : "delivery_id";


    $order = $orderModel::where('id', $request->id)->first();
    $orderItems = $order->orderItems()->get();


    if ($order == null) {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        401,
        null
      );
    }


    $orderResource = (strcasecmp($orderType, "Order") === 0 || strcasecmp($orderType, "orderCallcenter") === 0)
      ? OrderDetailsResource::make($order)
      : OrderButlersResource::make($order);


    $orderItemResourceClass = (strcasecmp($orderType, "Order") === 0 || strcasecmp($orderType, "orderCallcenter") === 0)
      ? OrderItemResource::class
      : OrderItemButlersResource::class;

    $orderItemResource = $orderItemResourceClass::collection($orderItems ?? []);


    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      [
        "order" => $orderResource,
        'items' => $orderItemResource
      ]

    );
  }

  public function updateLocation(UpdateLocationRequest $request)
  {

    $deliveryId = auth("api")->user()->id;
    $statusFinish = $this->statusService->getStatusIdByName('finish');
    $statusCancel = $this->statusService->getStatusIdByName('cancell');
    $orderType = ucfirst($request->type);
    $orderModel = "App\\Models\\" . $orderType;


    $order = $orderModel::whereId($request->id)->whereNot("status_id", [$statusCancel, $statusFinish])->first();
    if (!$order) {
      return $this->helper->responseJson('failed', trans('api.not_found'), 422, null);
    }

    $delivery = Delivery::where("ordereable_type", $orderModel)->where("ordereable_id", $request->id)->where("delivery_id", $deliveryId)->first();

    if (!$delivery) {
      $delivery->create([
        "lat" => $request->lat,
        "lng" => $request->lng,
        "ordereable_type" => $orderModel,
        "ordereable_id" => $request->id,
        "status_id" => $order->status_id,
        "delivery_id" => $deliveryId
      ]);
    }

    $delivery->update([
      "lat" => $request->lat,
      "lng" => $request->lng
    ]);
    event(new DeliveryUpdatedLocation($request->lng, $request->lat));
    return $delivery;
  }


}
