<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Api\User\AddToCartRequest;
use App\Models\{Cart, Item, Drink, Service, Ingredient, CartItemOption, Addon, Side};
use App\Helpers\Helpers;

class CartController extends Controller
{
  //
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();

  }


  // protected function itemSatisfiesConditions($item_id, $size_id = null,
  //   $option_id = null,
  //   $preference_id = null, $gift_id = null,
  //   $add_ingredients,$remove_ingredients)
  // // $services, $addons, $preferences, $days, $drinks, $sides)
  // {

  //   $item = Item::find($item_id);

  //   $hasSize = $size_id != null ? $item->sizes()->where('id', $size_id)->exists() : true;
  //   $hasOption = $option_id != null ? $item->options()->where('id', $option_id)->exists() : true;
  //   $hasPreference = $preference_id ? $item->preferences()->where('id', $preference_id)->exists() : true;
  //   $hasGift = $gift_id != null ? $item->gifts()->where('id', $gift_id)->exists() : true;

  //   /**check ingredients exists in this item */

  //   if($add_ingredients)
  //   {
  //     foreach($add_ingredients as $add_ingredient)
  //     {

  //       if(!$item->Addingredients()->whereId($add_ingredient)->exists()){

  //         return $this->helper->responseJson('failed', trans('api.invalid_ingredient'), 422, null);
  //       }
  //     }
  //   }


  //   return $hasSize && $hasOption && $hasPreference && $hasGift;


  // }

  protected function itemSatisfiesConditions($item_id, $size_id = null,
    $option_id = null,
    $preference_id = null, $gift_id = null,
    $add_ingredients, $remove_ingredients, $services, $drinks, $sides, $addons)
  {
    $item = Item::find($item_id);

    $hasSize = $size_id != null ? $item->sizes()->where('id', $size_id)->exists() : true;
    $hasOption = $option_id != null ? $item->options()->where('id', $option_id)->exists() : true;
    $hasPreference = $preference_id ? $item->preferences()->where('id', $preference_id)->exists() : true;
    $hasGift = $gift_id != null ? $item->gifts()->where('id', $gift_id)->exists() : true;

    /**check  Add ingredients exists in this item */

    if ($add_ingredients) {

      foreach ($add_ingredients as $add_ingredient) {

        if (!$item->addingredients()->whereId($add_ingredient)->exists()) {

          return false;
        }
      }
    }

    /**check  Remove ingredients exists in this item */

    if ($remove_ingredients) {

      foreach ($remove_ingredients as $remove_ingredient) {

        if (!$item->Removeingredients()->whereId($remove_ingredient)->exists()) {

          return false;
        }
      }
    }

    /**check Services exists in this item */

    if ($services) {

      foreach ($services as $service) {

        if (!$item->services()->whereId($service)->exists()) {

          return false;
        }
      }
    }

    /**check  Drinks exists in this item */

    if ($drinks) {

      foreach ($drinks as $drink) {

        if (!$item->drinks()->whereId($drink)->exists()) {

          return false;
        }
      }
    }

    /**check   sides exists in this item */

    if ($sides) {

      foreach ($sides as $side) {

        if (!$item->sides()->whereId($side)->exists()) {

          return false;
        }
      }
    }

    /**check  Addons exists in this item */

    if ($addons) {

      foreach ($addons as $addon) {
        // dd($item->addons()->get());
        dd($item->addons()->where("pivot_addon_id",$addon)->exists());
        if (!$item->addons()->where("pivot_addon_id",$addon)->exists()) {
          dd(1);

          return false;
        }else{
          dd(2);
        }
      }
    }

    return $hasSize && $hasOption && $hasPreference && $hasGift;
  }

  public function store(AddToCartRequest $request)
  {
    $item_id = $request->item_id;
    $add_ingredients = $request->input("add_ingredients", []);
    $remove_ingredients = $request->input("remove_ingredients", []);
    $services = $request->input("services", []);
    $size_id = $request->size_id;
    $option_id = $request->option_id;
    $preference_id = $request->preference_id;
    $gift_id = $request->gift_id;
    $drinks = $request->drinks;
    $sides = $request->sides;
    $addons = $request->addons;
    $item = Item::find($item_id);


    // Check if the item satisfies conditions
    if (!$this->itemSatisfiesConditions($item_id, $size_id, $option_id, $preference_id, $gift_id, $add_ingredients, $remove_ingredients, $services, $drinks, $sides, $addons)) {
      return $this->helper->responseJson('failed', trans('api.invalid_details_in_this_item'), 422, null);
    } else {
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
      if ($add_ingredients) {
        foreach ($add_ingredients as $add_ingredient) {
          $the_add_ingredient = Ingredient::find($add_ingredient);
          CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Ingredient", "optionable_id" => $the_add_ingredient->id, "price" => $the_add_ingredient->price]);
        }
      }

      if ($remove_ingredients) {

        foreach ($remove_ingredients as $remove_ingredient) {
          $the_remove_ingredient = Ingredient::find($remove_ingredient);
          CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Ingredient", "optionable_id" => $the_remove_ingredient->id, "price" => $the_remove_ingredient->price]);
        }
      }

      if ($services) {
        foreach ($services as $service) {
          $the_service = Service::find($service);
          CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Service", "optionable_id" => $the_service->id, "price" => $the_service->price]);
        }
      }

      if ($addons) {
        foreach ($addons as $addon) {

          $the_addon = Addon::find($addon);
          CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Addon", "optionable_id" => $the_addon->id, "price" => $the_addon->price]);
        }
      }



      if ($drinks) {
        foreach ($drinks as $drink) {
          $the_drink = Drink::find($drink);
          CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Drink", "optionable_id" => $the_drink->id, "price" => $the_drink->price]);
        }
      }


      if ($sides) {
        foreach ($sides as $side) {
          $the_side = Side::find($side);
          CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Side", "optionable_id" => $the_side->id, "price" => $the_side->price]);
        }
      }












    }
  }




}
