<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddToReviewRequest;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\{Review, Order, OrderItem};
use App\Http\Resources\Api\User\ReviewResource;

class ReviewController extends Controller
{


  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }


  public function add(AddToReviewRequest $request)
  {
    $user = auth('api')->user();
    $reviewableType = 'App\Models\\' . ucfirst($request->type);
    $type = $request->type;
    $id = $request->reviewable_id;

    $isOrder = 0;
    /**
     * To prevent user add reviews
     * if not make store order
     */
    if ($request->type == 'store') {
      $isOrder = Order::where(['user_id' => $user->id, 'status_id' => 4, 'store_id' => $request->reviewable_id])->count();

    }

    if ($request->type == 'item') {
      $isOrder = Order::where(['user_id' => $user->id, 'status_id' => 4])
        ->join('order_items', 'order_items.order_id', 'orders.id')
        ->where(['item_id' => $request->reviewable_id])->count();
    }

    if (!$isOrder) {
      return $this->helper->responseJson('failed', trans('api.reviews_not_allowed'), 422, null);
    }

    $rate = Review::updateOrCreate([
      'user_id' => $user->id,
      'reviewable_id' => $request->reviewable_id,
      'reviewable_type' => $reviewableType
    ], [
      'rating' => $request->rating,
      'comment' => $request->comment
    ]);

    $avg = $this->rate_avg($request->reviewable_id, $request->type);
   

    $reviews = Review::where('reviewable_type', $reviewableType)->latest('updated_at')->paginate(15);
    $reviews_count = Review::where('reviewable_type', $reviewableType)->count();

    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      [
        "data" => [
          "reviews" => ReviewResource::collection($reviews)->response()->getData(true),
          "reviews_count" => $reviews_count,
          'rate_avg' => $this->rate_avg($id, $type),

        ]
      ]
    );
  }


  public function show(Request $request)
  {
    $id = $request->id;
    $type = $request->type;
    $reviewable_types = ["offer", "store", "item"];
    if (!in_array($type, $reviewable_types)) {
      return $this->helper->responseJson('failed', trans('api.not_found'), 404, null);

    }
    $reviewable_types = 'App\Models\\' . ucfirst($type);

    $reviews = Review::where('reviewable_type', $reviewable_types)
      ->where('reviewable_id', $id)->latest('updated_at')->paginate(15);

    $reviews_count = Review::where('reviewable_type', $reviewable_types)
      ->where('reviewable_id', $id)->count();



    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      [
        "data" => [
          "reviews" => ReviewResource::collection($reviews)->response()->getData(true),
          "reviews_count" => $reviews_count,
          'rate_avg' => $this->rate_avg($id, $type),

        ]
      ]
    );
  }


  protected function rate_avg($id, $type)
  {
    $reviewableType = 'App\Models\\' . ucfirst($type);
    $avg = round(Review::where('reviewable_type', $reviewableType)->where('reviewable_id', $id)->avg('rating'), 2);
    return $avg;
  }


}
