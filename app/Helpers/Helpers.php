<?php

namespace App\Helpers;

use Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\{
  Device,
  Notification

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
      if ($limit){
          $description = \Illuminate\Support\Str::limit($description, $limit);
      }
      if ($stripSpace){
          $description = str_replace(' ', '', $description);
      }
      return $description ?? '';
  }

}
