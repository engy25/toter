<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Item};
use App\Helpers\Helpers;
use App\Http\Resources\Api\User\ItemResource;

class ItemController extends Controller
{
  //

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }


  public function show(Request $request)
  {
    $item = Item::with(["drinks", "sides", "addons", "gifts", "Removeingredients", "Removeingredients", "services", "options", "preferences"])->find($request->item_id);
    if (!$item) {
      return $this->helper->responseJson(
        'failed',
        trans('api.store_not_found'),
        404,
        null
      );
    }

    $response = ItemResource::make($item);

    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      ["item" => $response]
    );

  }
}
