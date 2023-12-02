<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Http\Resources\Api\User\{StoreResource, SimpleItemResource, SimpleStoreResource};
use App\Models\{Store, Item};


class StoreController extends Controller
{
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }


  public function show($id, $tag_id = 0)
  {
    $store = Store::whereId($id)->first();

    if (!$store) {
      return $this->helper->responseJson('failed', trans('api.store_not_found'), 404, null);
    }

    /**items that belongs to this store */
    $items = Item::with(["orderItems", "category"])->where("store_id", $id);

    /**items_popular */
    $items_popular = $items->get()->filter(function ($item) {
      return $item->status == trans('api.popular');
    });

    if ($tag_id == 0) {
      /** */
      $the_first_tag = $store->tags()->pluck("id")->first();
    } else {
      $the_first_tag = $tag_id;
    }

    /**items that exist in the store */
    $items_belongs_to_tag = $items->where("category_id", $the_first_tag)->get();

    $response = [];
    $response['store'] = StoreResource::make($store);
    $response['popular_items'] = SimpleItemResource::collection($items_popular);
    $response['items'] = SimpleItemResource::collection($items_belongs_to_tag);

    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      (object) ["response" => (object) $response]
    );
  }


  public function nearestStore(Request $request)
  {
    $nearest_stores = SimpleStoreResource::collection(Store::
      nearest($request->lat, $request->lng)->paginate(15))->response()->getData(true);
      return $this->helper->responseJson(
        'success',
        trans('api.auth_data_retreive_success'),
        200,
         ["store" => $nearest_stores]
      );

  }






}
