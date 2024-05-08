<?php

namespace App\Traits;
use App\Models\{
  User,
  Item,
  Coupon,
  Store,
  Offer,
  CouponUser,
  CouponItem
};
use App\Models\Scopes\ItemScope;
use App\Helpers\Helpers;
trait OrderTrait
{

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

  public static function applyCouponDiscountToItem($coupon, $item)
  {

    $Itemprice = $item->price; //200


    $coupon = Coupon::live()
      ->whereId($coupon->id)
      ->where("store_id", $item->store_id)
      ->where('max_user_used_code', '>=', 'user_used_code_count')
      ->first();


    if (!$coupon) {
      // Coupon not found
      return 422;
    }


    // Check if there's a related coupon item
    $couponItem = CouponItem::where(['item_id' => $item->id, 'coupon_id' => $coupon->id])->first();

    if (!$couponItem) {
      // No associated coupon item found for the item
      return $Itemprice;

    }

    $user_id = auth('api')->user()->id;

    // Check if the user has already used this coupon
    $couponUser = CouponUser::where(["user_id" => $user_id, "coupon_id" => $coupon->id])->first();


    if (!$couponUser) {
      // User has not used this coupon before
      CouponUser::create(["user_id" => $user_id, 'is_used' => 1, "coupon_id" => $coupon->id]);
    } else {
      // User has used this coupon before
      CouponUser::where(["user_id" => $user_id, "coupon_id" => $coupon->id])->increment('is_used',1);;
    }


    // Apply coupon discount
    if ($coupon->discount_percentage != null) {
      $percentage = $coupon->discount_percentage / 100;
      $coupon_discount = $Itemprice * $percentage;
      $Itemprice -= $coupon_discount;

    } else {

      $Itemprice -= $coupon->price;

    }

    // Update coupon statistics
    $coupon->update([
      'user_used_code_count' => $coupon->user_used_code_count + 1,
    ]);

    return $Itemprice;
  }


   /**
   * Calculate the total price of options
   */
  public static function calculateOptionsPrice($item, $relation, $options)
  {
    $totalPrice = 0;
    if ($options) {

      foreach ($options as $option) {
        $optionPrice = $item->{$relation}()->where("id", $option)->value('price');
        $totalPrice += $optionPrice ?: 0;


      }
    }
    return $totalPrice;
  }

    /**
   * Calculate the total price of drinks
   */
  public static function calculateDrinksPrice($item, $drinks)
  {
    $price = 0;
    if ($drinks) {

      foreach ($drinks as $drink) {
        $drinkPrice = $item->drinks()->wherePivot('drink_id', $drink)->value('price');
        $price += $drinkPrice ?: 0;
      }

    }
    return $price;
  }
  /**
   * Calculate the total price of addons
   */
  public static function calculateAddonsPrice($item, $addons)
  {
    $price = 0;
    if ($addons) {
      foreach ($addons as $addon) {
        $addonPrice = $item->addons()->wherePivot("addon_id", $addon)->value('price');

        $price += $addonPrice ?: 0;

      }
    }


    return $price;
  }




  public static function totalCart($couponId = null, $item_id, $qty, $size_id = null, $option_id = null, $preference_id = null, $add_ingredients, $remove_ingredients, $services, $drinks, $sides, $addons)
  {
    $total_price = 0;
    $points = 0;
    $freeDelivery = 0;
    $discount = 0;
    $subTotalAfterOfferDiscount = 0;
    $response = null; // Initialize the $response variable
    $user_id = auth("api")->user()->id;
    $offerId = null;
    $theUserPoint = auth('api')->user()->userPoints();


    $user = User::with(['points'])->findOrFail($user_id);


    $item = Item::withoutGlobalScope(new ItemScope)->with('sizes', 'options', 'preferences')->findOrFail($item_id);


    $store = Store::findOrFail($item->store_id);

    $itemPoints = (int) $item->points * $qty;


    // // Check if the item can be bought by points
    if ($itemPoints > 1) {
      /**check if the user have enoughp points */
      if ($itemPoints <= $theUserPoint) {
        $points += $itemPoints;
        $remainingItemPoints = $itemPoints;

        while ($remainingItemPoints > 0) {
          $maxUserPoints = $user->points()->where("point_earned", '>=', $remainingItemPoints)->first();

          if ($maxUserPoints !== null) {
            // Sufficient points in a single row
            $maxUserPoints->update([
              "point_earned" => $maxUserPoints->point_earned - $remainingItemPoints,
              "point_used" => $maxUserPoints->point_used + $remainingItemPoints,
            ]);
            $remainingItemPoints = 0; // Item points fully utilized
          } else {
            // No single row with enough points, find a row with the maximum point_earned
            $maxPointEarnedRow = $user->points()->where('point_earned', $user->points()->max('point_earned'))->first();


            if ($maxPointEarnedRow !== null) {
              $pointsToDeduct = min($remainingItemPoints, $maxPointEarnedRow->point_earned);

              $maxPointEarnedRow->update([
                "point_earned" => $maxPointEarnedRow->point_earned - $pointsToDeduct,
                "point_used" => $maxPointEarnedRow->point_used + $pointsToDeduct,
              ]);

              $remainingItemPoints -= $pointsToDeduct;


            } else {

              return Helpers::responseJson(
                'failed',
                trans('api.items_must_belong_to_the_same_store'),
                422,
                null
              );
            }

          }
        }
      } else {
        return 401;

      }


    }


    /**try to buy by the points in tier*/

    $checkOffer = Offer::Valid()
      ->where("store_id", $item->store_id)
      ->whereRelation("offerUsers", "user_id", $user_id)->first();



    $checkOffer = tap($checkOffer, function ($offer) use ($item, $qty, &$response, &$discount, &$freeDelivery,$theUserPoint, &$offerId) {
      if ($offer && $offer->offerUsers->isNotEmpty() && $offer->required_points <= $theUserPoint && $offer->order_counts > $offer->offerUsers->first()->order_count_of_user) {



        // Update count order of the offerUsers
        $offer->offerUsers()->update([
          "order_count_of_user" => (int) $offer->offerUsers->first()->order_count_of_user + 1,
        ]);

        // Set free_delivery to 1 if the offer has free_delivery equal to 1
        $freeDelivery = $offer->free_delivery == 1 ? 1 : 0;
        $discount = (int) $offer->discount_percentage;
        $offerId = $offer->id;
      }

    });




    if ($couponId != null) {
      $coupon = Coupon::whereId($couponId)->first();

      $applyCouponDiscount = self::applyCouponDiscountToItem($coupon, $item);

      if ($applyCouponDiscount == 422) {
        return 422;
      }

      $total_price += self::applyCouponDiscountToItem($coupon, $item);



    } else {
      $total_price += $item->price;
    }

    // Calculate prices for size, option, preference, and gift
    $total_price += $size_id ? $item->sizes()->where('id', $size_id)->value('price') : 0;
    $total_price += $option_id ? $item->options()->where("id", $option_id)->value("price") : 0;
    $total_price += $preference_id ? $item->preferences()->where("id", $preference_id)->value('price') : 0;


    // Check Add ingredients
    $total_price += self::calculateOptionsPrice($item, 'Addingredients', $add_ingredients);

    // Check remove ingredients
    $total_price += self::calculateOptionsPrice($item, 'Removeingredients', $remove_ingredients);

    // Check Services
    $total_price += self::calculateOptionsPrice($item, 'services', $services);

    // Check Drinks
    $total_price += self::calculateDrinksPrice($item, $drinks);

    // Check Sides
    $total_price += self::calculateOptionsPrice($item, 'sides', $sides);

    // Check Addons
    $total_price += self::calculateAddonsPrice($item, $addons);
    // dd($total_price); ->163.5

    $total_price *= $qty;
    // dd($total_price); ->490.5



    $percentage = $discount / 100;
    $subTotalAfterOfferDiscount = $total_price;
    $offer_discount = $subTotalAfterOfferDiscount * $percentage;
    $subTotalAfterOfferDiscount = $subTotalAfterOfferDiscount - $offer_discount;

    return [$total_price, $points, $freeDelivery, $subTotalAfterOfferDiscount, $offerId];
  }

    /**calculate subtotal */
    private function calculateSubTotal($couponId = null, $item)
    {

      $sub_total = $this->totalCart(
        $couponId,
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



}
