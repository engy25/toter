<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\User\UpdateCartRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\AddToCartRequest;
use App\Models\{Cart, Item, Drink, Service, Ingredient, CartItemOption, Addon, Side};
use App\Helpers\Helpers;
use App\Http\Resources\Api\User\Carts\CartResource;

class CartController extends Controller
{
  //
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();

  }





  protected function itemSatisfiesConditions($item, $size_id = null, $option_id = null, $preference_id = null, $gift_id = null, $add_ingredients, $remove_ingredients, $services, $drinks, $sides, $addons)
  {
    $hasSize = $size_id ? $item->sizes()->where('id', $size_id)->exists() : true;
    $hasOption = $option_id ? $item->options()->where('id', $option_id)->exists() : true;
    $hasPreference = $preference_id ? $item->preferences()->where('id', $preference_id)->exists() : true;
    $hasGift = $gift_id ? $item->gifts()->where('id', $gift_id)->exists() : true;


    // Check Add ingredients
    if ($add_ingredients && !$this->checkOptionsExist($item, 'Addingredients', $add_ingredients)) {
      return false;
    }

    // Check Remove ingredients
    if ($remove_ingredients && !$this->checkOptionsExist($item, 'Removeingredients', $remove_ingredients)) {
      return false;
    }

    // Check Services
    if ($services && !$this->checkOptionsExist($item, 'services', $services)) {
      return false;
    }

    // Check Drinks
    if ($drinks && !$this->checkDrinksExist($item, $drinks)) {
      // return false;
      return false;

    }

    // Check Sides
    if ($sides && !$this->checkOptionsExist($item, 'sides', $sides)) {
      return false;
    }

    // Check Addons
    if ($addons && !$this->checkAddonsExist($item, $addons)) {

      return false;
    }

    return $hasSize && $hasOption && $hasPreference && $hasGift;
  }
  /**
   * check option exists in item
   */
  private function checkOptionsExist($item, $relation, $options)
  {
    foreach ($options as $option) {
      if (!$item->{$relation}()->whereId($option)->exists()) {
        return false;
      }
    }

    return true;
  }



  /**
   * to ckeck the drinks exists or not and this drinks exist in this item or not
   */
  private function checkDrinksExist($item, $drinks)
  {
    foreach ($drinks as $drink) {

      if (!$item->drinks()->wherePivot('drink_id', $drink)->exists()) {
        // If a drink doesn't exist, return false
        return false;
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
    foreach ($addons as $addon) {
      if (!$item->addons()->wherePivot("addon_id", $addon)->exists()) {
        // If a addon doesn't exist, return false
        return false;
      }
    }
    //if all the addons exist, return true
    return true;
  }




  /**
   * to store the cart
   */
  public function store(AddToCartRequest $request)
  {
    \DB::beginTransaction();
    try {
      $item = Item::find($request->item_id);

      // Check if the item satisfies conditions
      if (!$this->itemSatisfiesConditions($item, $request->size_id, $request->option_id, $request->preference_id, $request->gift_id, $request->add_ingredients, $request->remove_ingredients, $request->services, $request->drinks, $request->sides, $request->addons)) {
        return $this->helper->responseJson('failed', trans('api.invalid_details_in_this_item'), 422, null);
      }



      // Create the cart
      $cart = Cart::create([
        "item_id" => $request->item_id,
        "user_id" => auth("api")->user()->id,
        "size_id" => $request->size_id,
        "qty" => $request->qty,
        "preference_id" => $request->preference_id,
        "option_id" => $request->option_id,
        "notes" => $request->notes,
        "gift_id" => $request->gift_id,
        "store_id" => $item->store_id
      ]);

      // Process cart options
      $this->processCartOptions($cart, 'addingredients', $request->add_ingredients, "Ingredient");
      $this->processCartOptions($cart, 'removeingredients', $request->remove_ingredients, "Ingredient");
      $this->processCartOptions($cart, 'services', $request->services, "Service");
      $this->processCartOptions($cart, 'drinks', $request->drinks, "Drink");
      $this->processCartOptions($cart, 'sides', $request->sides, "Side");
      $this->processCartOptions($cart, 'addons', $request->addons, "Addon");

      // //  the totalCart function to calculate the total
      // dd($this->helper->totalCart(
      //   $request->item_id,
      //   $request->qty,
      //   $request->size_id,
      //   $request->option_id,
      //   $request->preference_id,

      //   $request->add_ingredients,
      //   $request->remove_ingredients,
      //   $request->services,
      //   $request->drinks,
      //   $request->sides,
      //   $request->addons
      // ));


      return $this->helper->responseJson('success', trans('api.cart_added_successfully'), 200, null);

    } catch (\Exception $e) {
      \DB::rollBack();
      return $this->helper->responseJson('fail', trans('api.auth_something_went_wrong'), 500, null);

    }

  }

  /**
   * to store the options of the cart in cartItemOptions table
   */
  private function processCartOptions($cart, $relation, $options, $model)
  {
    if ($options) {
      foreach ($options as $option) {

        $optionModel = app("App\\Models\\" . ucfirst($model))->find($option);

        if ($optionModel) {
          $cart_item = CartItemOption::create([
            "cart_id" => $cart->id,
            "optionable_type" => "App\\Models\\" . ucfirst($model),
            "optionable_id" => $optionModel->id,
            "price" => $optionModel->price
          ]);

        }
      }
    }


  }

  /***display cart */

  public function getCart()
  {
    $userId = auth("api")->user()->id;
    $carts = Cart::with("cartItems")->where("user_id", $userId)->get();
    return $this->helper->responseJson(
      'success',
      trans('api.order_retreived_success'),
      200,
      [
        'carts' => CartResource::collection($carts),

      ]
    );
  }

  /**
   * update the qty of the cart
   */
  public function updateCartQty(UpdateCartRequest $request)
  {

    $cart = Cart::with('cartItems')->find($request->id);
    if (!$cart) {
      return $this->helper->responseJson('failed', trans('api.cart_not_found'), 404, null);
    }
    $currentQty = $cart->qty;

    $incrementQty = $request->qty;
    $newQty = $currentQty + $incrementQty;
    
    $cart->update(["qty" => $newQty]);

    return $this->helper->responseJson('success', trans('api.cart_updated_successfully'), 200, null);


  }





















}
