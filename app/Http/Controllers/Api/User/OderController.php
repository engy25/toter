<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\Orders\{SimpleOrderResource, OrderResource, OrderItemResource};
use App\Http\Requests\Api\User\{OrderRequestId, TypeRequest, AddOrderRequest};
use App\Models\PointUser;
use App\Models\Scopes\ItemScope;
use Illuminate\Http\Request;
use App\Models\{Order, User, OrderButler, OfferUser, OrderItem, OrderStatus, StoreDistrict, Address, Item, Store, Coupon, CouponUser, Ingredient, StatusTranslation};
use App\Helpers\helpers;
use App\Services\StatusService;
use App\Events\OrderCompleted;
class OderController extends Controller
{
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

        $itemSubTotal = $this->calculateSubTotal($item);


        /**check if the user buy the item by points and donot have point */
        if ($itemSubTotal == false) {
          return $this->helper->responseJson(
            'failed',
            trans('api.invalid_item_by_point'),
            422,
            null
          );
        }

        $sub_total += $itemSubTotal[0];
        $total_points += $itemSubTotal[1];

        $free_delivery = $itemSubTotal[2];
        $sub_total_after_discount_offer += $itemSubTotal[3];
        $offerId = $itemSubTotal[4];


      }
      // dd($sub_total); //520,5
      // dd($sub_total_after_discount_offer); //495.975
      // dd($free_delivery); //1

      $sum += $sub_total_after_discount_offer;

      /**check the district is in the store */

      $storeId = Item::withoutGlobalScope(new ItemScope)->whereId(collect($request->items)->pluck("item_id")->first())->value("store_id");
      $deliveryTime = Store::whereId($storeId)->value('delivery_time');
      $deliveryCharge = StoreDistrict::where("district_id", $request->district_id)->where("store_id", $storeId)->value('delivery_charge');

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

      /**check if the user send coupon */

      if ($request->coupon_id != null) {
        $coupon = Coupon::live()->whereId($request->coupon_id)->where('max_user_used_code', '>=', 'user_used_code_count')->first();
        if ($coupon) {
          $couponUser = CouponUser::where(["user_id" => auth('api')->user()->id, "coupon_id" => $request->coupon_id])->first();
          if ($couponUser != null) {
            CouponUser::where(["user_id" => auth('api')->user()->id, "coupon_id" => $request->coupon_id])->update(['is_used' => 1]);
            $this->helper->applyCouponDiscount($coupon, $order_cart_data, $sum);
          } else {
            CouponUser::create(["user_id" => auth('api')->user()->id, 'is_used' => 1, "coupon_id" => $request->coupon_id]);

            $this->helper->applyCouponDiscount($coupon, $order_cart_data, $sum);
          }




        } else {
          /**coupon not found */
          return $this->helper->responseJson('failed', trans('api.coupon_not_found'), 422, null);
        }

      }

      /**check if the user send offer */


      // $order_cart_data["total"] += $deliveryCharge;
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
      $order->update(["driver_id" => $driver->assignDriverToOrder($order, $storeId)->id]);
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
      event(new OrderCompleted($order));

      \DB::commit();

      return $this->helper->responseJson('success', trans('api.order_create_success'), (int) 200, null);


    } catch (\Exception $e) {
      \DB::rollBack();
      return $this->helper->responseJson('fail', trans('api.auth_something_went_wrong'), 422, null);

    }





  }



  /**
   * chekc the all items belongs to the same store
   */
  private function checkItemsFromTheSameStore($items)
  {
    $storeIds = [];
    $itemIds = collect($items)->pluck("item_id");



    foreach ($itemIds as $itemId) {

      $storeIds[] = Item::withoutGlobalScope(new ItemScope)->where('id', $itemId)->value('store_id');

    }

    $uniqueStoreIds = array_unique($storeIds);
    // dd($uniqueStoreIds);
    // dd(count($uniqueStoreIds) === 1);
    return count($uniqueStoreIds) === 1;

  }
  /**
   * calidate the order Item
   */
  public function validateOrderItem($item)
  {
    // Check if the provided size_id is valid for the item
    $sizeId = $item['size_id'] ?? null;
    if ($sizeId && !$this->checkOptionIdForItem($item['item_id'], "sizes", $sizeId)) {
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_size_id_for_item'),
        422,
        null
      );
    }

    // Check if the provided gift_id is valid for the item
    $giftId = $item['gift_id'] ?? null;

    if ($giftId && !$this->checkOptionIdForItem($item['item_id'], "gifts", $giftId)) {
      // dd($giftId);
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_gift_id_for_item'),
        422,
        null
      );
    }

    // Check if the provided option_id is valid for the item
    $optionId = $item["option_id"] ?? null;
    if ($optionId && !$this->checkOptionIdForItem($item['item_id'], "options", $optionId)) {
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_option_id_for_item'),
        422,
        null
      );
    }

    // Check if the provided preference_id is valid for the item
    $preferenceId = $item["preference_id"] ?? null;
    if ($preferenceId && !$this->checkOptionIdForItem($item['item_id'], "preferences", $preferenceId)) {
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_preference_id_for_item'),
        422,
        null
      );
    }

    // Check if Addingredients are valid for each item
    if (isset($item['addingredients']) && !$this->checkOptionsExist(Item::withoutGlobalScope(new ItemScope)->findOrFail($item['item_id']), 'Addingredients', $item['addingredients'])) {
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_add_ingredients_for_item'),
        422,
        null
      );
    }

    // Check if removeingredients are valid for each item
    if (isset($item['remove_ingredients']) && !$this->checkOptionsExist(Item::withoutGlobalScope(new ItemScope)->findOrFail($item['item_id']), 'Removeingredients', $item['remove_ingredients'])) {
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_remove_ingredients_for_item'),
        422,
        null
      );
    }

    // Check if sides are valid for each item
    if (isset($item['sides']) && !$this->checkOptionsExist(Item::withoutGlobalScope(new ItemScope)->findOrFail($item['item_id']), 'sides', $item['sides'])) {
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_sides_for_item'),
        422,
        null
      );
    }

    // Check if services are valid for each item
    if (isset($item['services']) && !$this->checkOptionsExist(Item::withoutGlobalScope(new ItemScope)->findOrFail($item['item_id']), 'services', $item['services'])) {
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_services_for_item'),
        422,
        null
      );
    }

    // Check if preferences are valid for each item
    if (isset($item['preferences']) && !$this->checkOptionsExist(Item::withoutGlobalScope(new ItemScope)->findOrFail($item['item_id']), 'preferences', $item['preferences'])) {
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_preferences_for_item'),
        422,
        null
      );
    }

    // Check if addons are valid for each item
    if (isset($item['addons']) && !$this->checkAddonsExist(Item::withoutGlobalScope(new ItemScope)->findOrFail($item['item_id']), $item['addons'])) {
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_addons_for_item'),
        422,
        null
      );
    }


    // Check if drinks are valid for each item
    if (isset($item['drinks']) && !$this->checkDrinksExist(Item::withoutGlobalScope(new ItemScope)->findOrFail($item['item_id']), $item['drinks'])) {
      return $this->helper->responseJson(
        'failed',
        trans('api.invalid_drinks_for_item'),
        422,
        null
      );
    }

    return null; // Validation passed
  }

  /**
   * check district is associated with the store
   */
  private function checkDistrictIdAssociatedToTheStore($storeId, $districtId)
  {

    if (
      !Store::whereId($storeId)->whereHas('districts', function ($query) use ($districtId) {
        $query->where('districts.id', $districtId);
      })->exists()
    ) {
      return false;
    } else {
      return true;
    }
  }

  /**calculate subtotal */
  private function calculateSubTotal($item)
  {

    $sub_total = $this->helper->totalCart(
      $item['item_id'],
      $item['qty'],
      $item['size_id'] ?? null,
      $item['option_id'] ?? null,
      $item['preference_id'] ?? null,
      $item['addingredients'] ?? null,
      $item['remove_ingredients'] ?? null,
      $item['services'] ?? null,
      $item['drinks'] ?? null,
      $item['sides'] ?? null,
      $item['addons'] ?? null
    );





    return $sub_total;
  }


  /**
   * check option exists in item
   */
  private function checkOptionsExist($item, $relation, $options)
  {
    if ($options) {
      foreach ($options as $option) {

        if (!$item->{$relation}()->whereId($option)->exists()) {
          return false;
        }
      }
    }

    return true;
  }

  /**
   * to ckeck the drinks exists or not and this drinks exist in this item or not
   */
  private function checkDrinksExist($item, $drinks)
  {
    if ($drinks) {
      foreach ($drinks as $drink) {

        if (!$item->drinks()->wherePivot('drink_id', $drink)->exists()) {
          // If a drink doesn't exist, return false
          return false;
        }
      }
    }

    // If all drinks exist, return true
    return true;
  }



  /**
   * to ckeck the addons exists or not and this addon exist in this item or not
   */
  private function checkAddonsExist($item, $addons)
  {
    if ($addons) {

      foreach ($addons as $addon) {
        if (!$item->addons()->wherePivot("addon_id", $addon)->exists()) {
          // If a addon doesn't exist, return false
          return false;
        }
      }
    }

    //if all the addons exist, return true
    return true;
  }

  private function checkOptionIdForItem($itemId, $relation, $optionId)
  {
    $item = Item::withoutGlobalScope(new ItemScope)->find($itemId);
    // dd($item);
    // dd($item->gifts()->where('id', 4)->exists());
    return $item && $item->{$relation}()->where('id', $optionId)->exists();
  }


  public function getOrders(TypeRequest $request)
  {
    $orders = [];
    $user_id = auth('api')->user()->id;
    //***check type */
    $statusCancel = $this->statusService->getStatusIdByName("cancell");
    $statusFinish = $this->statusService->getStatusIdByName("finish");
    $statusPending = $this->statusService->getStatusIdByName("pending");
    $statusConfirm = $this->statusService->getStatusIdByName("confirm");
    $statusOnOTheRoad = $this->statusService->getStatusIdByName("on_the_road");


    if ($request->type == "active") {
      /**order Active */

      $orders = Order::whereIn('status_id', [$statusPending, $statusOnOTheRoad, $statusConfirm])->where('user_id', $user_id)->cursor();


    }
    if ($request->type == "history") {
      /**order History */


      $orders = Order::where('status_id', $statusFinish)->where('user_id', $user_id)->get();

    }
    if ($request->type == "cancel") {
      /**order Cancel */

      $orders = Order::where('status_id', $statusCancel)->where('user_id', $user_id)->get();


    }

    return $this->helper->responseJson(
      'success',
      trans('api.order_retreived_success'),
      200,
      ['orders' => SimpleOrderResource::collection($orders)]
    );



  }

  public function orderDetails(OrderRequestId $request)
  {
    $user_id = auth('api')->user()->id;

    $order = Order::where('id', $request->order_id)->where('user_id', $user_id)->first();
    $items = $order->orderItems()->get();

    return $this->helper->responseJson(
      'success',
      trans('api.order_retreived_success'),
      200,
      [
        'data' => [
          'order' => OrderResource::make($order),
          'items' => OrderItemResource::collection($items),
        ]
      ]
    );


  }

  /**
   * the user cancel the order in case the order is pending [return the offer if applied and coupon]
   */
  public function cancelOrder($id)
  {
    $order = Order::find($id);
    $userId = auth('api')->user()->id;
    $statusCancel = $this->statusService->getStatusIdByName("cancell");
    $statusPending = $this->statusService->getStatusIdByName("pending ");
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
        $sum= $pointEarned + $order->points;

        $pointRow->update(["point_earned" =>$sum]);
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
        "ordereable_type" => "App\Models\Order"
      ]);

      $orders = Order::where('status_id',$statusCancel)->where('user_id', auth('api')->user()->id)->get();


      return $this->helper->responseJson(
        'success',
        trans('api.order_cancell_success'),
        200,
        ['orders' => SimpleOrderResource::collection($orders)]
      );


    } elseif ($order->status_id == $statusCancel) {
      return $this->helper->responseJson('failed', trans('api.order_cancell_succes'), 422, null);

    } else {
      return $this->helper->responseJson('failed', trans('api.order_cannot-cancel'), 422, null);
    }

  }















}
