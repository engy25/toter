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






  // protected function itemSatisfiesConditions($item_id, $size_id = null, $option_id = null, $preference_id = null, $gift_id = null, $add_ingredients, $remove_ingredients, $services, $drinks, $sides, $addons)
  // {
  //   $item = Item::find($item_id);

  //   $hasSize = $size_id != null ? $item->sizes()->where('id', $size_id)->exists() : true;
  //   $hasOption = $option_id != null ? $item->options()->where('id', $option_id)->exists() : true;
  //   $hasPreference = $preference_id ? $item->preferences()->where('id', $preference_id)->exists() : true;
  //   $hasGift = $gift_id != null ? $item->gifts()->where('id', $gift_id)->exists() : true;

  //   /**check  Add ingredients exists in this item */

  //   if ($add_ingredients) {

  //     foreach ($add_ingredients as $add_ingredient) {

  //       if (!$item->addingredients()->whereId($add_ingredient)->exists()) {

  //         return false;
  //       }
  //     }
  //   }

  //   /**check  Remove ingredients exists in this item */

  //   if ($remove_ingredients) {

  //     foreach ($remove_ingredients as $remove_ingredient) {

  //       if (!$item->Removeingredients()->whereId($remove_ingredient)->exists()) {

  //         return false;
  //       }
  //     }
  //   }

  //   /**check Services exists in this item */

  //   if ($services) {

  //     foreach ($services as $service) {

  //       if (!$item->services()->whereId($service)->exists()) {

  //         return false;
  //       }
  //     }
  //   }

  //   /**check  Drinks exists in this item */

  //   if ($drinks) {

  //     foreach ($drinks as $drink) {

  //       if (!$item->drinks()->whereId($drink)->exists()) {

  //         return false;
  //       }
  //     }
  //   }

  //   /**check   sides exists in this item */

  //   if ($sides) {

  //     foreach ($sides as $side) {

  //       if (!$item->sides()->whereId($side)->exists()) {

  //         return false;
  //       }
  //     }
  //   }

  //   /**check  Addons exists in this item */

  //   if ($addons) {

  //     foreach ($addons as $addon) {
  //       // dd($item->addons()->get());
  //       // dd($item->addons()->where("addon_id",$addon)->get());
  //       if (!$item->addons()->where("addon_id", $addon)->exists()) {

  //         return false;
  //       } else {

  //       }
  //     }
  //   }

  //   return $hasSize && $hasOption && $hasPreference && $hasGift;
  // }

  // public function totalCart($item_id, $size_id = null, $option_id = null, $preference_id = null, $gift_id = null, $add_ingredients, $remove_ingredients, $services, $drinks, $sides, $addons)
  // {


  // }



  // public function store(AddToCartRequest $request)
  // {
  //   $item_id = $request->item_id;
  //   $add_ingredients = $request->input("add_ingredients", []);
  //   $remove_ingredients = $request->input("remove_ingredients", []);
  //   $services = $request->input("services", []);
  //   $size_id = $request->size_id;
  //   $option_id = $request->option_id;
  //   $preference_id = $request->preference_id;
  //   $gift_id = $request->gift_id;
  //   $drinks = $request->drinks;
  //   $sides = $request->sides;
  //   $addons = $request->addons;
  //   $item = Item::find($item_id);


  //   // Check if the item satisfies conditions
  //   if (!$this->itemSatisfiesConditions($item_id, $size_id, $option_id, $preference_id, $gift_id, $add_ingredients, $remove_ingredients, $services, $drinks, $sides, $addons)) {
  //     return $this->helper->responseJson('failed', trans('api.invalid_details_in_this_item'), 422, null);
  //   } else {
  //     $cart = Cart::create([
  //       "item_id" => $request->item_id,
  //       "user_id" => auth("api")->user()->id,
  //       "size_id" => $request->size_id,
  //       "qty" => $request->qty,
  //       "preference_id" => $request->preference_id,
  //       "option_id" => $request->option_id,
  //       "notes" => $request->notes,
  //       "gift_id" => $request->gift_id,
  //       "store_id" => $item->store_id

  //     ]);
  //     if ($add_ingredients) {
  //       foreach ($add_ingredients as $add_ingredient) {
  //         $the_add_ingredient = Ingredient::find($add_ingredient);
  //         CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Ingredient", "optionable_id" => $the_add_ingredient->id, "price" => $the_add_ingredient->price]);
  //       }
  //     }

  //     if ($remove_ingredients) {

  //       foreach ($remove_ingredients as $remove_ingredient) {
  //         $the_remove_ingredient = Ingredient::find($remove_ingredient);
  //         CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Ingredient", "optionable_id" => $the_remove_ingredient->id, "price" => $the_remove_ingredient->price]);
  //       }
  //     }

  //     if ($services) {
  //       foreach ($services as $service) {
  //         $the_service = Service::find($service);
  //         CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Service", "optionable_id" => $the_service->id, "price" => $the_service->price]);
  //       }
  //     }

  //     if ($addons) {
  //       foreach ($addons as $addon) {
  //         $the_addon = Addon::find($addon);
  //         CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Addon", "optionable_id" => $the_addon->id, "price" => $the_addon->price]);
  //       }
  //     }

  //     if ($drinks) {
  //       foreach ($drinks as $drink) {
  //         $the_drink = Drink::find($drink);
  //         CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Drink", "optionable_id" => $the_drink->id, "price" => $the_drink->price]);
  //       }
  //     }


  //     if ($sides) {
  //       foreach ($sides as $side) {
  //         $the_side = Side::find($side);
  //         CartItemOption::create(["cart_id" => $cart->id, "optionable_type" => "App\Models\Side", "optionable_id" => $the_side->id, "price" => $the_side->price]);
  //       }
  //     }





  //   }
  // }



















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
    if ($drinks && !$this->checkOptionsExist($item, 'drinks', $drinks)) {
      return false;
    }

    // Check Sides
    if ($sides && !$this->checkOptionsExist($item, 'sides', $sides)) {
      return false;
    }

    // Check Addons
    if ($addons && !$this->checkOptionsExist($item, 'addons', $addons)) {
      return false;
    }

    return $hasSize && $hasOption && $hasPreference && $hasGift;
  }

  private function checkOptionsExist($item, $relation, $options)
  {
    foreach ($options as $option) {
      if (!$item->{$relation}()->whereId($option)->exists()) {
        return false;
      }
    }

    return true;
  }

  public function totalCart($item_id, $size_id = null, $option_id = null, $preference_id = null, $gift_id = null, $add_ingredients, $remove_ingredients, $services, $drinks, $sides, $addons)
  {
    // Implement your cart total calculation logic here
  }

  public function store(AddToCartRequest $request)
  {
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
   dd( $this->processCartOptions($cart, 'addingredients', $request->add_ingredients,"Ingredient"));
    $this->processCartOptions($cart, 'removeingredients', $request->remove_ingredients,"Ingredient");
    $this->processCartOptions($cart, 'services', $request->services,"Service");
    $this->processCartOptions($cart, 'drinks', $request->drinks,"Drink");
    $this->processCartOptions($cart, 'sides', $request->sides,"Side");
    $this->processCartOptions($cart, 'addons', $request->addons,"Addon");

    // You can call the totalCart function here to calculate the total

    return $this->helper->responseJson('success', trans('api.cart_added_successfully'), 200, null);
  }

  private function processCartOptions($cart, $relation, $options,$model)
  {
    foreach ($options as $option) {

      $optionModel = app("App\\Models\\" . ucfirst($model))->find($option);

      if ($optionModel) {
        $cart_item=CartItemOption::create([
          "cart_id" => $cart->id,
          "optionable_type" => "App\\Models\\" . ucfirst($model),
          "optionable_id" => $optionModel->id,
          "price" => $optionModel->price
        ]);

      }
      dd($cart_item);
    }
  }


















}
