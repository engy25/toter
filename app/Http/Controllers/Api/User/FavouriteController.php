<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Scopes\ItemScope;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Http\Resources\Api\User\{SimpleItemResource, SimpleStoreResource};
use App\Models\{Item,Store};

class FavouriteController extends Controller
{
  //

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function index($sort)
  {
    $user = auth('api')->user()->load(["itemFavourites", "storeFavourites"]);

    if ($sort == 'item') {
      $itemFavourites = $user->itemFavourites;
      return $this->helper->responseJson(
        'success',
        trans('api.auth_data_retreive_success'),
        200,
        ["item" => SimpleItemResource::collection($itemFavourites)]
      );
    }

    if ($sort == 'store') {
      $storeFavourites = $user->storeFavourites;
      return $this->helper->responseJson(
        'success',
        trans('api.auth_data_retreive_success'),
        200,
        ["store" => SimpleStoreResource::collection($storeFavourites)]
      );
    }

  }

  public function addItemToFavorite($id)
  {
    $item = Item::withoutGlobalScope(ItemScope::class)->find($id);
    if (!$item) {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        404,
        null
      );
    }

    if ($item->favourites()->whereUserId(auth('api')->user()->id)->exists()) {
      // If the item is already in favorites, remove it
      $item->favourites()->whereUserId(auth('api')->user()->id)->delete();
      $message = __('api.product_favourite_delete_success');
    } else {
      // If the item is not in favorites, add it
      $item->favourites()->whereUserId(auth('api')->user()->id)->create(['user_id' => auth('api')->user()->id]);
      $message = __('api.product_favourite_added_success');
    }

    // Reload the user with the updated itemFavourites relationship
    $user = auth('api')->user()->load(["itemFavourites"]);
    $itemFavourites = $user->itemFavourites;

    return $this->helper->responseJson(
      'success',
      $message,
      200,
      ["item" => SimpleItemResource::collection($itemFavourites)]
    );


  }

  public function addStoreToFavorite($id)
  {
    $store = Store::find($id);
    if (!$store) {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        404,
        null
      );
    }

    if ($store->favourites()->whereUserId(auth('api')->user()->id)->exists()) {
      // If the store is already in favorites, remove it
      $store->favourites()->whereUserId(auth('api')->user()->id)->delete();
      $message = __('api.product_favourite_delete_success');
    } else {
      // If the store is not in favorites, add it
      $store->favourites()->whereUserId(auth('api')->user()->id)->create(['user_id' => auth('api')->user()->id]);
      $message = __('api.product_favourite_added_success');
    }

    // Reload the user with the updated itemFavourites relationship
    $user = auth('api')->user()->load(["storeFavourites"]);
    $storeFavourites = $user->storeFavourites;

    return $this->helper->responseJson(
      'success',
      $message,
      200,
      ["store" => SimpleStoreResource::collection($storeFavourites)]
    );


  }
}
