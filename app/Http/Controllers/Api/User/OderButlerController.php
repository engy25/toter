<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\{OrderButler, OrderButlerItem, Coupon, CouponUser, Butler, StatusTranslation, OrderButlerStatus,Store};
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
    $coupon = Coupon::where('code', $request->code)->where('max_user_used_code', '>=', 'user_used_code_count')->first();

    if (!$coupon) {

      return $this->helper->responseJson('failed', trans('api.coupon_not_found'), 422, null);

    }

    if (Coupon::where('code', $request->code)->where('max_user_used_code', '>=', 'user_used_code_count')->live()->first()) {



      $coupon_user = CouponUser::firstOrCreate(['coupon_id' => $coupon->id, 'user_id' => auth('api')->user()->id, "is_used" => 0]);
      //$coupon->update(['user_used_code_count'=>$coupon->user_used_code_count +1]);
      return $this->helper->responseJson('succcess', trans('api.coupon_applied_success'), 200, ['coupon' => new CouponResource($coupon)]);

    } else {


      return $this->helper->responseJson('failed', trans('api.coupon_is_expired'), 422, null);
    }




  }



  public function store(AddOrderButlerRequest $request)
  {

    try {
      $butler_id = $request->butler_id;
      $butler = Butler::findOrFail($butler_id);


      $sub_total =(double) $request->expected_delivery_charge +(double) $request->expected_cost;

      $order_data = [
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
        // "default_currency_id" => $butler->default_currency_id,
        // "exchange_rate" => $butler->exchange_rate,
        // "to_currency_id" => $butler->to_currency_id,
        "admin_id" => $butler->admin_id,
        "butler_id" => $butler->id,
      ];

      // Check if coupon exists
      if ($request->coupon_id) {
        $coupon = Coupon::live()
          ->whereId($request->coupon_id)
          ->where('max_user_used_code', '>=', 'user_used_code_count')
          ->first();

        if ($coupon) {
          $this->helper->applyCouponDiscount($coupon, $order_data, $sub_total);
        }
      } else {
        $order_data["sub_total"] = $sub_total;
        $order_data["total"] = $sub_total;
      }



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
      OrderButlerStatus::create(["order_id" => $order->id, "status_id" => $status_pending->status_id]);

      return $this->helper->responseJson('success', trans('api.order_create_success'), 200, null);
    } catch (Exception $e) {
      return $this->helper->responseJson('failed', trans('api.auth_something_went_wrong'), 422, null);
    }
  }
















}
