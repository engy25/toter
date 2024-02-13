<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\{OrderButler, CompanyDistrict, OrderStatus, OrderButlerItem, Coupon, CouponUser, Butler, StatusTranslation, OrderButlerStatus, Store};
use App\Http\Requests\Api\User\{AddOrderButlerRequest, ApplyCouponRequest};
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Api\User\{CouponResource};


class OderButlerController extends Controller
{
  //
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();

  }

  /**
      * Undocumented function
      *
      *Apply Coupon On Cart

      * @param ApplyCouponRequest $request
      * @return void
      */
  public function applyCoupon(ApplyCouponRequest $request)
  {
    $coupon = Coupon::where('code', $request->code)->where("store_id", $request->store_id)->where('max_user_used_code', '>=', 'user_used_code_count')->first();

    if (!$coupon) {

      return $this->helper->responseJson('failed', trans('api.coupon_not_found'), 422, null);

    }

    if (Coupon::where('code', $request->code)->where("store_id", $request->store_id)->where('max_user_used_code', '>=', 'user_used_code_count')->live()->first()) {

      $coupon_user = CouponUser::firstOrCreate(['coupon_id' => $coupon->id, 'user_id' => auth('api')->user()->id, "is_used" => 0]);

      return $this->helper->responseJson('succcess', trans('api.coupon_applied_success'), 200, ['coupon' => new CouponResource($coupon)]);

    } else {


      return $this->helper->responseJson('failed', trans('api.coupon_is_expired'), 422, null);
    }


  }

  public function store(AddOrderButlerRequest $request)
  {
    \DB::beginTransaction();
    try {
      $butler_id = $request->butler_id;
      $butler = Butler::findOrFail($butler_id);
      //  $deliveryCharge = CompanyDistrict::where("id", $request->district_id)->value("delivery_charge");


      $couponId = null;
      $total=0;
      $sum = 0;

      $sub_total = (double) $request->expected_cost;


      // Check if coupon exists
      if ($request->coupon_id != null) {

        $coupon = Coupon::live()->where("id", $request->coupon_id)->first();


        $sum = $this->applyCouponDiscount($coupon, $sub_total);

        if ($sum === 422) {
          return $this->helper->responseJson('failed', trans('api.coupon_not_valid'), 422, null);
        } elseif (is_float($sum) && $sum < 0) {
          return $this->helper->responseJson('failed', trans('api.coupon_not_valid_you_must_pay_more'), 422, null);
        }

        $couponId = $request->coupon_id;

      }


      $deliveryCharge = $request->expected_delivery_charge;
      //$sum += (double) $deliveryCharge + $butler->service_charge;
      $sum += (double) $deliveryCharge + $butler->service_charge;
      $total= $sub_total + $deliveryCharge;

      $order_data = [
        "user_id" => auth("api")->user()->id,
        "from_address" => $request->from_address_id,
        "to_address" => $request->to_address_id,
        "from_driver_instructions" => $request->from_driver_instructions,
        "to_driver_instructions" => $request->to_driver_instructions,
        'payment_type' => $request->payment_type,
        'transaction_id' => $request->transaction_id,
        "order" => $request->order,
        "delivery_time" => $butler->delivery_time,
        "expected_delivery_charge" => $request->expected_delivery_charge,
        "expected_cost" => $request->expected_cost,
        "district_id" => $request->district_id,
        "coupon_id" => $couponId,
        "admin_id" => $butler->admin_id,
        "butler_id" => $butler->id,
        "sub_total" => $sub_total,
        "sum" => $sum,
        "total" => $total,
        "service_charge" => $butler->service_charge,
        "delivery_charge"=>$request->expected_delivery_charge,
        // "delivery_charge" => $deliveryCharge
      ];


      $order = OrderButler::create($order_data);

      if (is_array($request->items)) {


        foreach ($request->items as $item)

          $order->orderItems()->create([
            "order_id" => $order->id,
            "item" => $item["item"],
            "image" => $item["image"] ?? null,
          ]);
      }

      $status_pending = StatusTranslation::where("name", "pending")->first();

      // Create a new status for the order
      OrderStatus::create([
        "status_id" => $status_pending->status_id,
        "ordereable_id" => $order->id, // Explicitly set the ordereable_id
        "ordereable_type" => "App\Models\OrderButler"
      ]);

      \DB::commit();
      return $this->helper->responseJson('success', trans('api.order_create_success'), (int) 200, null);


    } catch (\Exception $e) {
      \DB::rollBack();
      return $this->helper->responseJson('fail', trans('api.auth_something_went_wrong'), 422, null);

    }


  }
  public static function applyCouponDiscount($coupon, $subtotal)
  {

    $subTotal = $subtotal;


    $coupon = Coupon::live()
      ->whereId($coupon->id)
      ->whereNull('store_id') // Check if store_id is null
      ->where('max_user_used_code', '>=', 'user_used_code_count')
      ->first();


    if (!$coupon) {
      // Coupon not found
      return 422;
    }

    $user_id = auth('api')->user()->id;

    // Check if the user has already used this coupon
    $couponUser = CouponUser::where(["user_id" => $user_id, "coupon_id" => $coupon->id])->first();


    if (!$couponUser) {
      // User has not used this coupon before
      CouponUser::create(["user_id" => $user_id, 'is_used' => 1, "coupon_id" => $coupon->id]);
    } else {
      // User has used this coupon before
      CouponUser::where(["user_id" => $user_id, "coupon_id" => $coupon->id])->increment('is_used', 1);
      ;
    }


    // Apply coupon discount
    if ($coupon->discount_percentage != null) {
      $percentage = $coupon->discount_percentage / 100;
      $coupon_discount = $subTotal * $percentage;
      $subTotal -= $coupon_discount;

    } else {

      $subTotal -= $coupon->price;

    }

    // Update coupon statistics
    $coupon->update([
      'user_used_code_count' => $coupon->user_used_code_count + 1,
    ]);

    return $subTotal;
  }
















}
