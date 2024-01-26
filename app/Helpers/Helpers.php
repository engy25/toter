<?php

namespace App\Helpers;


use App\Models\Scopes\ItemScope;
use Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\{
  Device,
  Notification,
  User,
  Cart,
  Item,
  Drink,
  Service,
  Ingredient,
  CartItemOption,
  Addon,
  Side,
  Coupon,
  Store,
  Offer

};

use Illuminate\Support\Str;

class Helpers
{
  /**
   * helper function associated to dashboard
   */
  public static function appClasses()
  {

    $data = config('custom.custom');


    // default data array
    $DefaultData = [
      'myLayout' => 'vertical',
      'myTheme' => 'theme-default',
      'myStyle' => 'light',
      'myRTLSupport' => true,
      'myRTLMode' => true,
      'hasCustomizer' => true,
      'showDropdownOnHover' => true,
      'displayCustomizer' => true,
      'menuFixed' => true,
      'menuCollapsed' => false,
      'navbarFixed' => true,
      'footerFixed' => false,
      'menuFlipped' => false,
      // 'menuOffcanvas' => false,
      'customizerControls' => [
        'rtl',
        'style',
        'layoutType',
        'showDropdownOnHover',
        'layoutNavbarFixed',
        'layoutFooterFixed',
        'themes',
      ],
      //   'defaultLanguage'=>'en',
    ];

    // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
    $data = array_merge($DefaultData, $data);

    // All options available in the template
    $allOptions = [
      'myLayout' => ['vertical', 'horizontal', 'blank'],
      'menuCollapsed' => [true, false],
      'hasCustomizer' => [true, false],
      'showDropdownOnHover' => [true, false],
      'displayCustomizer' => [true, false],
      'myStyle' => ['light', 'dark'],
      'myTheme' => ['theme-default', 'theme-bordered', 'theme-semi-dark'],
      'myRTLSupport' => [true, false],
      'myRTLMode' => [true, false],
      'menuFixed' => [true, false],
      'navbarFixed' => [true, false],
      'footerFixed' => [true, false],
      'menuFlipped' => [true, false],
      // 'menuOffcanvas' => [true, false],
      'customizerControls' => [],
      // 'defaultLanguage'=>array('en'=>'en','fr'=>'fr','de'=>'de','pt'=>'pt'),
    ];

    //if myLayout value empty or not match with default options in custom.php config file then set a default value
    foreach ($allOptions as $key => $value) {
      if (array_key_exists($key, $DefaultData)) {
        if (gettype($DefaultData[$key]) === gettype($data[$key])) {
          // data key should be string
          if (is_string($data[$key])) {
            // data key should not be empty
            if (isset($data[$key]) && $data[$key] !== null) {
              // data key should not be exist inside allOptions array's sub array
              if (!array_key_exists($data[$key], $value)) {
                // ensure that passed value should be match with any of allOptions array value
                $result = array_search($data[$key], $value, 'strict');
                if (empty($result) && $result !== 0) {
                  $data[$key] = $DefaultData[$key];
                }
              }
            } else {
              // if data key not set or
              $data[$key] = $DefaultData[$key];
            }
          }
        } else {
          $data[$key] = $DefaultData[$key];
        }
      }
    }
    //layout classes
    $layoutClasses = [
      'layout' => $data['myLayout'],
      'theme' => $data['myTheme'],
      'style' => $data['myStyle'],
      'rtlSupport' => $data['myRTLSupport'],
      'rtlMode' => $data['myRTLMode'],
      'textDirection' => $data['myRTLMode'],
      'menuCollapsed' => $data['menuCollapsed'],
      'hasCustomizer' => $data['hasCustomizer'],
      'showDropdownOnHover' => $data['showDropdownOnHover'],
      'displayCustomizer' => $data['displayCustomizer'],
      'menuFixed' => $data['menuFixed'],
      'navbarFixed' => $data['navbarFixed'],
      'footerFixed' => $data['footerFixed'],
      'menuFlipped' => $data['menuFlipped'],
      // 'menuOffcanvas' => $data['menuOffcanvas'],
      'customizerControls' => $data['customizerControls'],
    ];

    // sidebar Collapsed
    if ($layoutClasses['menuCollapsed'] == true) {
      $layoutClasses['menuCollapsed'] = 'layout-menu-collapsed';
    }

    // Menu Fixed
    if ($layoutClasses['menuFixed'] == true) {
      $layoutClasses['menuFixed'] = 'layout-menu-fixed';
    }

    // Navbar Fixed
    if ($layoutClasses['navbarFixed'] == true) {
      $layoutClasses['navbarFixed'] = 'layout-navbar-fixed';
    }

    // Footer Fixed
    if ($layoutClasses['footerFixed'] == true) {
      $layoutClasses['footerFixed'] = 'layout-footer-fixed';
    }

    // Menu Flipped
    if ($layoutClasses['menuFlipped'] == true) {
      $layoutClasses['menuFlipped'] = 'layout-menu-flipped';
    }

    // Menu Offcanvas
    // if ($layoutClasses['menuOffcanvas'] == true) {
    //   $layoutClasses['menuOffcanvas'] = 'layout-menu-offcanvas';
    // }

    // RTL Supported template
    if ($layoutClasses['rtlSupport'] == true) {
      $layoutClasses['rtlSupport'] = '/rtl';
    }

    // RTL Layout/Mode
    if (app()->getLocale() === 'en') {
      $layoutClasses['rtlMode'] = 'ltr';
      $layoutClasses['textDirection'] = 'ltr';
    } else {
      $layoutClasses['rtlMode'] = 'rtl';
      $layoutClasses['textDirection'] = 'rtl';
    }

    // Show DropdownOnHover for Horizontal Menu
    if ($layoutClasses['showDropdownOnHover'] == true) {
      $layoutClasses['showDropdownOnHover'] = 'true';
    } else {
      $layoutClasses['showDropdownOnHover'] = 'false';
    }

    // To hide/show display customizer UI, not js
    if ($layoutClasses['displayCustomizer'] == true) {
      $layoutClasses['displayCustomizer'] = 'true';
    } else {
      $layoutClasses['displayCustomizer'] = 'false';
    }

    return $layoutClasses;
  }

  public static function updatePageConfig($pageConfigs)
  {
    $demo = 'custom';
    if (isset($pageConfigs)) {
      if (count($pageConfigs) > 0) {
        foreach ($pageConfigs as $config => $val) {
          Config::set('custom.' . $demo . '.' . $config, $val);
        }
      }
    }
  }

  /**
   * helper function associated to controllers
   */

  static function responseJson($result, $message, $status_code, $data)
  {
    $response =
      [
        'result' => $result,
        'message' => $message,
        'status' => (int) $status_code,
        'data' => $data,

      ];


    return response()->json($response, (int) $status_code);
  }

  function upload_single_file($request_file, $path)
  {

    $name = time() . '_' . $this->generate_random_file_name() . '.' . $request_file->getClientOriginalExtension();
    $request_file->move(storage_path($path), $name);
    return $name;
  }



  function generate_random_file_name($length = 12)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $generate_random_image_key = '';
    for ($i = 0; $i < $length; $i++) {
      $generate_random_image_key .= $characters[rand(0, $charactersLength - 1)];
    }
    return $generate_random_image_key;
  }




  /**
   * Undocumented function
   *Get The distance Between User And Products
   * @param [type] $startLat
   * @param [type] $startLng
   * @param [type] $endLat
   * @param [type] $endLng
   * @param [type] $unit
   * @return void
   *
   */

  static function distance($lat1, $lon1, $lat2, $lon2, $unit = 'K')
  {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }

  static function paginate($items, $perPage = 5, $page = null)
  {
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $total = count($items);
    $currentpage = $page;
    $offset = ($currentpage * $perPage) - $perPage;
    $itemstoshow = array_slice($items, $offset, $perPage);
    return new LengthAwarePaginator($itemstoshow, $total, $perPage);
  }

  static function getCurrency()
  {
    /**check user exists or not */
    $currency = "USD";
    /*
    if(auth('api')->check())
    {
    $currency_id_of_user=auth('api')->user()->currency_id;

    $currency=Currency::whereId($currency_id_of_user)->first();

    return $currency->name;
    }else{
    return $currency;
    }
    */
    return $currency;
  }
  // public static function index()
  // {
  //     $models = [
  //         Category::class,
  //         Package::class,
  //         Product::class,
  //         Order::class,
  //         User::class,
  //         Country::class,
  //         CollectionModel::class,
  //     ];

  //     $counts = array_reduce($models, function ($accumulator, $model) {
  //         $accumulator[] = $model::count();
  //         return $accumulator;
  //     }, []);

  //     $counts[] = Product::where('is_active', 0)->count();
  //     $counts[] = Product::where('is_offered', 1)->count();
  //     $counts[] = User::where('user_type', 'Delivery')->count();

  //     return $counts;
  // }





  function androidPushNotification(array $device_id, array $message)
  {


    $fcmNotification = [];


    $Appname = "هناك اشعار جديد";

    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    //    dd($device_id);

    if (count($device_id) > 1) {
      $fcmNotification['registration_ids'] = array_values($device_id);
    } else {
      //        dd(($device_id)[0]);
      //        $fcmNotification['to'] = $device_id[0];
      $fcmNotification['to'] = array_values($device_id)[0];
    }



    #EDIT#

    foreach ($device_id as $item) {
      $lang = Device::where('device_token', $item)->first();
    }



    //    dd($lang->user->lang);

    //    if(app()->getLocale() == 'ar')
    #END EDIT#
    if ($lang->user->lang == 'ar') {
      $notification = [
        'title' => $message['title_ar'] ?? $Appname,
        'body' => $message['body_ar'],
        'icon' => $message['icon'] ?? 'myIcon',
        'sound' => $message['sound'] ?? 'mySound',
        'clickaction' => $message['clickaction'] ?? 'FLUTTER_NOTIFICATION_CLICK'
      ];
    } else {
      $notification = [
        'title' => $message['title_en'] ?? $Appname,
        'body' => $message['body_en'],
        'icon' => $message['icon'] ?? 'myIcon',
        'sound' => $message['sound'] ?? 'mySound',
        'clickaction' => $message['clickaction'] ?? 'FLUTTER_NOTIFICATION_CLICK'
      ];
    }

    //    $notification = [
    //        'title' => $message['title'] ?? $Appname,
    //        'body' => $message['body'],
    //        'icon' =>  $message['icon'] ?? 'myIcon',
    //        'sound' =>  $message['sound'] ?? 'mySound',
    //        'clickaction' => $message['clickaction'] ?? 'FLUTTER_NOTIFICATION_CLICK'
    //    ];

    //    dd($notification);
    //
    $extraNotificationData = [
      "message" => $notification,
      "page" => $message['page'] ?? 'page'
    ];


    $fcmNotification['notification'] = $notification;
    $fcmNotification['data'] = $extraNotificationData;


    $headers = [
      'Authorization: key=' . env("FIREBASE_KEY"),
      'Content-Type: application/json'
    ];


    //         dd($fcmNotification);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fcmUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }


  function sendNotification($message, $user_id)
  {

    $device_id = Device::where('user_id', $user_id)->pluck('device_token')->toArray();
    if (!empty($device_id)) {
      $this->androidPushNotification($device_id, $message);
      Notification::create([
        'user_id' => $user_id,
        'title' => ['en' => $message['title_en'], 'ar' => $message['title_ar']],
        'data' => ['en' => $message['body_en'], 'ar' => $message['body_ar']],
      ]);

    }
  }


  function apiCode()
  {
    $code = rand(1231, 7879);
    return $code;
  }

  // Helper function
  function sendSMS($to, $message)
  {
    $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    $twilio->messages->create(
      $to,
      [
        'from' => env('TWILIO_PHONE_NUMBER'),
        'body' => $message,
      ]
    );
  }
  public static function stripText($text, int $limit = null, $stripSpace = false)
  {
    $description = strip_tags(html_entity_decode($text));
    $description = preg_replace('/\s\s+/', ' ', $description);
    if ($limit) {
      $description = \Illuminate\Support\Str::limit($description, $limit);
    }
    if ($stripSpace) {
      $description = str_replace(' ', '', $description);
    }
    return $description ?? '';
  }

  public static function applyCouponDiscount($coupon, &$order_data, $sum)
  {
    $percentage = $coupon->discount_percentage / 100;

    $coupon_discount = $sum * $percentage;

    $order_data["sum"] = $sum - $coupon_discount;
    // $order_data["sub_total"] = $order_data["total"];
    $order_data['coupon_id'] = $coupon->id;
    // dd($order_data);

    $coupon->update([
      'user_used_code_count' => $coupon->user_used_code_count + 1,
    ]);

  }

  public static function applyOffer(&$order_data, $sub_total)
  {


  }

  /**
   * get the count of each orders that delivery make based on the date
   */
  public static function deliveryOrdersCount($deliveryId, $date)
  {

    // Retrieve the delivery
    $delivery = User::with('deliveryOrders', 'deliveryOrderCallcenter', 'deliveryOrderButlers')->find($deliveryId);

    // Filter orders based on the provided date
    $filteredOrders = $delivery->deliveryOrders->filter(function ($order) use ($date) {

      return $order->created_at->format('d-m-Y') == $date;
    });

    // Count the filtered orders
    $deliveryOrdersCount = $filteredOrders->count();

    // Similarly, filter and count for deliveryOrderCallcenter and deliveryOrderButlers
    $filteredCallcenterOrders = $delivery->deliveryOrderCallcenter->filter(function ($order) use ($date) {
      return $order->created_at->format('d-m-Y') == $date;
    });

    $deliveryOrderCallcenterCount = $filteredCallcenterOrders->count();

    $filteredButlersOrders = $delivery->deliveryOrderButlers->filter(function ($order) use ($date) {
      return $order->created_at->format('d-m-Y') == $date;
    });

    $deliveryOrderButlersCount = $filteredButlersOrders->count();

    return [
      'deliveryOrdersCount' => $deliveryOrdersCount,
      'deliveryOrderCallcenterCount' => $deliveryOrderCallcenterCount,
      'deliveryOrderButlersCount' => $deliveryOrderButlersCount,
    ];
  }



  public static function totalCart($item_id, $qty, $size_id = null, $option_id = null, $preference_id = null, $add_ingredients, $remove_ingredients, $services, $drinks, $sides, $addons)
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
              $points += $itemPoints;

            } else {

              return self::responseJson(
                'failed',
                trans('api.items_must_belong_to_the_same_store'),
                422,
                null
              );
            }

          }
        }
      } else {
        return false;


      }






    }






    /**try to buy by the points in tier*/

    $checkOffer = Offer::Valid()
      ->where("store_id", $item->store_id)
      ->whereRelation("offerUsers", "user_id", $user_id)->first();





    $checkOffer = tap($checkOffer, function ($offer) use ($item, $qty, &$response, &$discount, &$freeDelivery, &$offerId) {
      if ($offer && $offer->offerUsers->isNotEmpty() && $offer->order_counts > $offer->offerUsers->first()->order_count_of_user) {


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


    $total_price += $item->price;
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


}
