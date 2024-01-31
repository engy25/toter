<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\Orders\{SimpleOrderResource, OrderResource, OrderItemResource, OrderItemButlersResource};
use App\Http\Resources\Api\Delivery\{OrderDetailsResource, OrderButlersResource, SimpleOrderButlerUserResource};
use App\Http\Requests\Api\User\{OrderRequestId, TypeRequest, AddOrderRequest};
use App\Models\OrderCallcenter;
use App\Models\PointUser;
use App\Models\Scopes\ItemScope;
use Illuminate\Http\Request;
use App\Models\{Order, User, OrderButler, OfferUser, OrderItem, OrderStatus, StoreDistrict, Address, Item, Store, Coupon, CouponUser, Ingredient, StatusTranslation};
use App\Helpers\helpers;
use App\Services\StatusService;
use App\Events\OrderCompleted;

use App\Traits\OrderTrait;

class OderController extends Controller
{
  use OrderTrait;
  public $helper;
  public $statusService;
  public function __construct()
  {
    $this->helper = new Helpers();
    $this->statusService = new StatusService();

  }
  /**
   * the offer applied automatically then when you add coupon add
   */
  public function store(AddOrderRequest $request)
  {
    \DB::beginTransaction();
    try {
      $driver = new User();


      $order_cart_data = [];
      $sub_total = 0;
      $sub_total_after_discount_offer = 0;
      $offerId = null;

      $sum = 0;
      $total_points = 0;
      $free_delivery = 0; // Assume free delivery until proven otherwise
      // \DB::beginTransaction();
      // try {
      /** Check all the items from the same store and if all items are available */
      if (!$this->checkItemsFromTheSameStore($request->items)) {

        return $this->helper->responseJson(
          'failed',
          trans('api.items_must_belong_to_the_same_store'),
          422,
          null
        );
      }
      foreach ($request->items as $item) {

        $validationResult = $this->validateOrderItem($item);
        if ($validationResult !== null) {
          return $validationResult;
        }

        $couponId = ($request->coupon_id != null) ? $request->coupon_id : null;

        $itemSubTotal = $this->calculateSubTotal($couponId, $item);

        // Handle the case where calculateSubTotal returns 401 or 422 if needed
        if ($itemSubTotal === 401) {
          return $this->helper->responseJson(
            'failed',
            trans('api.invalid_item_by_point'),
            422,
            null
          );
        } elseif ($itemSubTotal === 422) {
          return $this->helper->responseJson('failed', trans('api.coupon_not_valid'), 422, null);
        } elseif (is_float($itemSubTotal[0]) && $itemSubTotal[0] < 0 ) {
          return $this->helper->responseJson('failed', trans('api.coupon_not_valid_you_must_pay_more'), 422, null);
        }




        $sub_total += $itemSubTotal[0];
        // dd($sub_total);
        $total_points += $itemSubTotal[1];
        // dd($total_points);
        $free_delivery = $itemSubTotal[2];
        // dd($free_delivery);
        $sub_total_after_discount_offer += $itemSubTotal[3];
        // dd($sub_total_after_discount_offer);
        $offerId = $itemSubTotal[4];


      }


      // dd($sub_total);

      $sum += $sub_total_after_discount_offer;

      /**check the district is in the store */

      $storeId = Item::withoutGlobalScope(new ItemScope)->whereId(collect($request->items)->pluck("item_id")->first())->value("store_id");
      $deliveryTime = Store::whereId($storeId)->value('delivery_time');
      $deliveryCharge = StoreDistrict::where("district_id", $request->district_id)->where("store_id", $storeId)->value('delivery_charge');

      $driverId = ($driver->assignDriverToOrder($storeId) == null) ? null : $driver->assignDriverToOrder($storeId)->id;

      // check if the the user use offer and this offer is freedelivery
      if ($free_delivery == 1) {
        $deliveryCharge = 0;
      }
      $sum += $deliveryCharge;


      // Check if the district ID is associated with the store
      if (!$this->checkDistrictIdAssociatedToTheStore($storeId, $request->district_id)) {
        return $this->helper->responseJson(
          'failed',
          trans('api.invalid_district_for_store'),
          422,
          null
        );
      }


      $order_cart_data += [
        "user_id" => auth("api")->user()->id,
        "store_id" => $storeId,
        "district_id" => $request->district_id,
        "delivery_charge" => $deliveryCharge,
        "payment_type" => $request->payment_type,
        "transaction_id" => $request->transaction_id,
        "address_id" => $request->address_id,
        "delivery_time" => $deliveryTime,
        "sum" => $sum,
        "points" => $total_points,
        "sub_total" => $sub_total,
        "total" => $sub_total + $deliveryCharge,
        "offer_id" => $offerId

      ];


      /**store the order */
      $order = Order::create($order_cart_data);
      $statusPendingId = StatusTranslation::where("name", "pending")->value("status_id");
      // Create a new status for the order
      OrderStatus::create([
        "status_id" => $statusPendingId,
        "ordereable_id" => $order->id, // Explicitly set the ordereable_id
        "ordereable_type" => "App\Models\Order"
      ]);
      $order->update(["driver_id" => $driverId]);
      /**store order Items */

      foreach ($request->items as $item) {
        $orderItem = OrderItem::create([
          'ordereable_id' => $order->id,
          'ordereable_type' => 'App\Models\Order',
          'item_id' => $item['item_id'],
          'size_id' => $item['size_id'] ?? null,
          'option_id' => $item['option_id'] ?? null,
          'preference_id' => $item['preference_id'] ?? null,
          'gift_id' => $item['gift_id'] ?? null,
          'qty' => $item['qty'],
          'notes' => $item['notes'] ?? null,
        ]);
        if (isset($item['addingredients']) && count($item['addingredients'])) {
          $addingredients = json_encode($item['addingredients']);
          $orderItem->update(["addingredients" => $addingredients]);
        }

        if (isset($item['remove_ingredients']) && count($item['remove_ingredients'])) {
          $remove_ingredients = json_encode($item['remove_ingredients']);
          $orderItem->update(["remove_ingredients" => $remove_ingredients]);
        }

        if (isset($item['services']) && count($item['services'])) {
          $services = json_encode($item['services']);
          $orderItem->update(["services" => $services]);
        }

        if (isset($item['addons']) && count($item['addons'])) {
          $addons = json_encode($item['addons']);
          $orderItem->update(["addons" => $addons]);
        }
        if (isset($item['drinks']) && count($item['drinks'])) {
          $drinks = json_encode($item['drinks']);
          $orderItem->update(["drinks" => $drinks]);
        }
        if (isset($item['sides']) && count($item['sides'])) {
          $sides = json_encode($item['sides']);
          $orderItem->update(["sides" => $sides]);
        }


      }
      /**
       * if the store make points after certain number of the orders give the points to the user
       */
      event(new OrderCompleted($order));

      \DB::commit();

      return $this->helper->responseJson('success', trans('api.order_create_success'), (int) 200, null);


    } catch (\Exception $e) {
      \DB::rollBack();
      return $this->helper->responseJson('fail', trans('api.auth_something_went_wrong'), 422, null);

    }





  }













  public function getOrders(TypeRequest $request)
  {
    $user_id = auth('api')->user()->id;

    $statusCancel = $this->statusService->getStatusIdByName("cancell");
    $statusFinish = $this->statusService->getStatusIdByName("finish");
    $statusPending = $this->statusService->getStatusIdByName("pending");
    $statusConfirm = $this->statusService->getStatusIdByName("confirm");
    $statusOnOTheRoad = $this->statusService->getStatusIdByName("on_the_road");

    switch ($request->type) {
      case 'active':
        $statuses = [$statusPending, $statusOnOTheRoad, $statusConfirm];
        break;
      case 'history':
        $statuses = [$statusFinish];
        break;
      case 'cancel':
        $statuses = [$statusCancel];
        break;
      default:
        // Handle invalid type
        break;
    }

    $orderTypes = ['App\Models\Order', 'App\Models\OrderCallcenter', 'App\Models\OrderButler'];
    $result = [];

    foreach ($orderTypes as $orderType) {
      $orders = $orderType::whereIn('status_id', $statuses)
        ->where('user_id', $user_id)
        ->get();

      if ($orderType === 'App\Models\Order') {
        $result['orders'] = SimpleOrderResource::collection($orders);
      } elseif ($orderType === 'App\Models\OrderCallcenter') {
        $result['ordercallcenters'] = SimpleOrderResource::collection($orders);
      } elseif ($orderType === 'App\Models\OrderButler') {
        $result['orderbutlers'] = SimpleOrderButlerUserResource::collection($orders);
      }
    }

    return $this->helper->responseJson(
      'success',
      trans('api.order_retrieved_success'),
      200,
      [
        'data' => $result,
      ]
    );
  }




  public function orderDetails(OrderRequestId $request)
  {

    $order = [];
    $user_id = auth("api")->user()->id;


    $orderType = ucfirst($request->type);
    $orderModel = "App\\Models\\" . $orderType;

    $order = $orderModel::where('id', $request->order_id)->where('user_id', $user_id)->first();
    if ($order == null) {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        401,
        null
      );
    }

    $orderItems = $order->orderItems()->get();





    $orderResource = (strcasecmp($orderType, "Order") === 0 || strcasecmp($orderType, "orderCallcenter") === 0)
      ? OrderDetailsResource::make($order)
      : OrderButlersResource::make($order);


    $orderItemResourceClass = (strcasecmp($orderType, "Order") === 0 || strcasecmp($orderType, "orderCallcenter") === 0)
      ? OrderItemResource::class
      : OrderItemButlersResource::class;


    $orderItemResource = $orderItemResourceClass::collection($orderItems ?? []);


    return $this->helper->responseJson(
      'success',
      trans('api.order_retreived_success'),
      200,

      [
        "order" => $orderResource,
        'items' => $orderItemResource
      ]


    );





  }

  /**
   * the user cancel the order in case the order is pending [return the offer if applied and coupon]
   */
  public function cancelOrder(OrderRequestId $request)
  {

    $userId = auth('api')->user()->id;

    $statusCancel = $this->statusService->getStatusIdByName("cancell");
    $statusPending = $this->statusService->getStatusIdByName("pending ");

    $orderType = ucfirst($request->type);
    $orderModel = "App\\Models\\" . $orderType;

    $order = $orderModel::whereId($request->order_id)
      ->where("user_id", $userId)
      ->where("status_id", $statusPending)
      ->first();


    if (!$order) {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        404,
        null
      );
    } elseif ($order->status_id == $statusPending) {

      //if there is points return it if there is offer i return it if there is coupon return it
      $points = 0;

      if ($order->points != 0) {
        /**return the points */
        $pointRow = PointUser::where("user_id", $userId)->where("expired_at", '>=', date('Y-m-d'))->orderBy('expired_at', 'desc')->first();
        $pointEarned = $pointRow->point_earned;
        $sum = $pointEarned + $order->points;

        $pointRow->update(["point_earned" => $sum]);
      }

      if ($order->coupon_id != null) {

        $couponUser = CouponUser::where("user_id", $userId)->where("coupon_id", $order->coupon_id)->first();
        $couponUser->update(["is_used" => $couponUser->is_used - 1]);

      }
      if ($order->offer_id != null) {
        $offerUser = OfferUser::Where("user_id", $userId)->where("offer_id", $order->offer_id)->first();
        $offerUser->update(["order_count_of_user" => $offerUser->order_count_of_user + 1]);

      }

      /**update the status */
      $order->update(["status_id" => $statusCancel]);

      OrderStatus::create([
        "status_id" => $statusCancel,
        "ordereable_id" => $order->id, // Explicitly set the ordereable_id
        "ordereable_type" => $orderModel
      ]);

      $orders = Order::where('status_id', $statusCancel)->where('user_id', auth('api')->user()->id)->get();
      $ordercallcenters = OrderCallcenter::where('status_id', $statusCancel)->where('user_id', auth('api')->user()->id)->get();
      $orderbutlers = OrderButler::where('status_id', $statusCancel)->where('user_id', auth('api')->user()->id)->get();


      return $this->helper->responseJson(
        'success',
        trans('api.order_cancell_success'),
        200,
        [
          'orders' => SimpleOrderResource::collection($orders),
          'ordercallcenters' => SimpleOrderResource::collection($ordercallcenters),
          'orderbutlers' => SimpleOrderButlerUserResource::collection($orderbutlers)
        ]
      );


    } elseif ($order->status_id == $statusCancel) {
      return $this->helper->responseJson('failed', trans('api.order_cancell_succes'), 422, null);

    } else {
      return $this->helper->responseJson('failed', trans('api.order_cannot-cancel'), 422, null);
    }

  }









  // 'ordercallcenters' =>
  //   SimpleOrderResource::collection($ordercallcenters),





}
