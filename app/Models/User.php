<?php

namespace App\Models;

use App\Models\Scopes\ItemScope;

use App\Helpers\Helpers;
use Illuminate\Support\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Scopes\UserScope;

class User extends Authenticatable
{

  protected $table = 'users';
  public $timestamps = true;

  use HasApiTokens, HasFactory, Notifiable, HasRoles;


  protected $guarded = [];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
    //'password' => 'hashed',
  ];

  protected static function booted()
  {
    static::addGlobalScope(new UserScope);

    static::created(function ($user) {
      $user->checkAndUpdateTier();
    });
  }
  public function checkAndUpdateTier()
  {
    // Check the number of orders for the user this month
    $orderCount = Order::where("user_id", $this->id)
      ->where('created_at', '>=', now()->startOfMonth())
      ->count();

    if ($orderCount >= 10) {
      // Update the user to the golden tier
      $this->update(['tier_id' => '2']);
    }
  }



  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/user/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/user/' . $this->attributes['image']));
        }
      }

      $helper = new Helpers();
      $image = $helper->upload_single_file($value, 'app/public/images/user/');



      $this->attributes['image'] = $image;
    }
  }


  public function getImageAttribute()
  {
    $image = isset($this->attributes['image']) && $this->attributes['image'] ? 'storage/images/user/' . $this->attributes['image'] : asset('https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y');
    return asset($image);
  }


  public function setPasswordAttribute($value)
  {
    if ($value) {
      $this->attributes['password'] = bcrypt($value);
    }
  }


  public function store() {
    return $this->belongsTo(Store::class);
  }

  public function addresses()
  {
    return $this->hasMany(Address::class);
  }

  public function reviews()
  {
    return $this->morphMany(Review::class, 'reviewable');
  }

  public function searchHistories()
  {
    return $this->hasMany(SearchHistory::class);
  }

  public function itemFavourites()
  {
    return $this->morphedByMany(Item::class, "favoriteable", "favourites")->withoutGlobalScope(ItemScope::class);
  }




  public function storeFavourites()
  {
    return $this->morphedByMany(Store::class, "favoriteable", "favourites");
  }


  public function coupons()
  {
    return $this->hasOne(Coupon::class, 'coupon_users', 'user_id', 'coupon_id');
  }

  public function notifeable()
  {
    return $this->morphMany(Notification::class, 'notifeable');
  }

  public function tier()
  {
    return $this->belongsTo(Tier::class);
  }

  public function teirPoints()
  {
    return $this->morphedByMany(Tier::class, 'pointeable', 'point_users');
  }

  public function storePoints()
  {
    return $this->morphedByMany(Store::class, 'pointeable', 'point_users');
  }

  public function punchcardPoints()
  {
    return $this->morphedByMany(User::class, 'pointeable', 'point_users');
  }

  public function offerPoints()
  {
    return $this->morphedByMany(Offer::class, 'pointeable', 'point_users');
  }

  public function devices()
  {

    return $this->hasMany(Device::class);
  }


  public function deliveryOrderCallcenter()
  {
    return $this->hasMany(OrderCallcenter::class, "delivery_id");
  }


  public function userOrderCallCenter()
  {
    return $this->hasMany(OrderCallcenter::class, "user_id");
  }

  public function callCenterOrderCallCenter()
  {
    return $this->hasMany(OrderCallcenter::class, "callcenter_id");
  }


  public function userOrders()
  {
    return $this->hasMany(Order::class, "user_id");
  }

  public function deliveryOrders()
  {
    return $this->hasMany(Order::class, "driver_id");
  }

  public function userOrderButlers()
  {
    return $this->hasMany(OrderButler::class, "user_id");
  }

  public function deliveryOrderButlers()
  {
    return $this->hasMany(OrderButler::class, "driver_id");
  }

  public function count_orders_created_this_month()
  {

    return $this->userOrders()->where('created_at', '>=', Carbon::now()->month)
      ->count();


  }


  public function providers()
  {
    return $this->hasMany(Provider::class);
  }


  public function points()
  {
    return $this->hasMany(PointUser::class, "user_id");
  }

  public function userPoints()
  {
    $user_id = auth('api')->id();
    /**of the tier */
    $point_user = PointUser::where("user_id", $user_id)->where("expired_at", '>=', date('Y-m-d'))->sum('point_earned');
    //  $offer_point = OfferUser::where("user_id", $user_id)->where("expire_at", '>=', date('Y-m-d'))->sum('point_earned');


    $points = $point_user;

    return (int) $points;
  }



  public function userExpiredPointsCount()
  {
    $user_id = auth('api')->id();
    $point_user = PointUser::where("user_id", $user_id)->where("expired_at", '<', date('Y-m-d'))->sum('point_expired');
    $offer_point = OfferUser::where("user_id", $user_id)->where("expire_at", '<', date('Y-m-d'))->sum('point_expired');


    $points = $point_user + $offer_point;

    return (int) $points;
  }


  public function userUsedPointsCount()
  {
    $user_id = auth('api')->id();
    $point_user = PointUser::where("user_id", $user_id)->where("expired_at", '>=', date('Y-m-d'))->sum('point_used');
    $offer_point = OfferUser::where("user_id", $user_id)->where("expire_at", '>=', date('Y-m-d'))->sum('point_used');


    $points = $point_user + $offer_point;

    return (int) $points;
  }


  public function scopeNearest($query, $lat, $lng)
  {
    $lat = (float) $lat;
    $lng = (float) $lng;
    $space_search_by_kilos = 10000;
    $query->select(\DB::raw("*,
              (6371 * ACOS(COS(RADIANS($lat))
              * COS(RADIANS(lat))
              * COS(RADIANS($lng) - RADIANS(lng))
              + SIN(RADIANS($lat))
              * SIN(RADIANS(lat)))) AS distance"))
      ->having('distance', '<=', $space_search_by_kilos)
      ->orderBy('distance', 'asc')->get();
  }




  public function assignDriverToOrder($storeId)
  {

    $role_delivery = Role::where("name", "Delivery")->first();
    $delivery = User::where("role_id", $role_delivery->id);

    $store = Store::whereId($storeId)->first();
    $sectionName=SectionTranslation::where("name","Food")->first();

    if($store->section_id==$sectionName->section_id)
    {

      return null;
    }


    $currentDayName = Carbon::now()->format('l');
    $day = DayTranslation::where("name", $currentDayName)->first();
    $dayId = $day->day_id;

    $currentTime = Carbon::now()->format('H:i:s');

    /**get the Query deliveries within working hours and if the delivery doesnot have scheduled  in this day
     * get the users with schedules if doesnot have schedules get the delivery only
     * */
    $usersQuery = User::where("role_id", $role_delivery->id)
      ->where(function ($query) use ($dayId, $currentTime) {
        $query->where(function ($subQuery) use ($dayId, $currentTime) {
          $subQuery->whereHas("schedules", function ($scheduleQuery) use ($dayId, $currentTime) {
            $scheduleQuery->where("day_id", $dayId)
              ->where("from_time", "<=", $currentTime)
              ->where("to_time", ">=", $currentTime);
          });
        })
          ->orWhere(function ($subQuery) use ($dayId) {
            $subQuery->whereHas("schedules", function ($scheduleQuery) use ($dayId) {
              $scheduleQuery->where("day_id", $dayId);
            });
          })
          ->orWhereDoesntHave("schedules"); // Users without schedules
      });



    // $usersQuery = User::where("role_id", $role_delivery->id);


    // Check if the Nearest scope exists and if the store has latitude and longitude
    if (method_exists($usersQuery->getModel(), 'Nearest') && $store->lat && $store->lng) {

      $usersQuery->Nearest($store->lat, $store->lng);
    }


    $the_nearest_empty_driver = $usersQuery->whereDoesntHave("deliveryOrders")
      ->whereDoesntHave("deliveryOrderButlers")->whereDoesntHave("deliveryOrderCallcenter")->first();

    $the_nearest_the_least_loaded_driver = User::with(["deliveryOrders", "deliveryOrderButlers", "deliveryOrderCallcenter"])
      ->where("role_id", $role_delivery->id)

      ->when(method_exists($usersQuery->getModel(), 'scopeNearest') && $store->lat && $store->lng, function ($query) use ($store) {
        return $query->Nearest($store->lat, $store->lng);
      })
      ->withCount(["deliveryOrders", "deliveryOrderButlers", "deliveryOrderCallcenter"])
      ->orderByRaw("delivery_orders_count + delivery_order_butlers_count + delivery_order_callcenter_count")
      ->first();



    if ($the_nearest_empty_driver) {


      return $the_nearest_empty_driver;
    }

    if (!$the_nearest_empty_driver) {
      if ($the_nearest_the_least_loaded_driver != null) {

        return $the_nearest_the_least_loaded_driver;
      } else {


        return User::with(["deliveryOrders", "deliveryOrderButlers", "deliveryOrderCallcenter"])
          ->where("role_id", $role_delivery->id)
          ->withCount(["deliveryOrders", "deliveryOrderButlers", "deliveryOrderCallcenter"])
          ->orderByRaw("delivery_orders_count + delivery_order_butlers_count + delivery_order_callcenter_count")
          ->first();
      }
    }
  }

  public function assignDriverToOrderCallCenter($storeId)
  {

    $role_delivery = Role::where("name", "Delivery")->first();
    $delivery = User::where("role_id", $role_delivery->id);

    $store = Store::whereId($storeId)->first();

    $currentDayName = Carbon::now()->format('l');
    $day = DayTranslation::where("name", $currentDayName)->first();
    $dayId = $day->day_id;

    $currentTime = Carbon::now()->format('H:i:s');

    /**get the Query deliveries within working hours and if the delivery doesnot have scheduled  in this day
     * get the users with schedules if doesnot have schedules get the delivery only
     * */
    $usersQuery = User::where("role_id", $role_delivery->id)
      ->where(function ($query) use ($dayId, $currentTime) {
        $query->where(function ($subQuery) use ($dayId, $currentTime) {
          $subQuery->whereHas("schedules", function ($scheduleQuery) use ($dayId, $currentTime) {
            $scheduleQuery->where("day_id", $dayId)
              ->where("from_time", "<=", $currentTime)
              ->where("to_time", ">=", $currentTime);
          });
        })
          ->orWhere(function ($subQuery) use ($dayId) {
            $subQuery->whereHas("schedules", function ($scheduleQuery) use ($dayId) {
              $scheduleQuery->where("day_id", $dayId);
            });
          })
          ->orWhereDoesntHave("schedules"); // Users without schedules
      });



    // $usersQuery = User::where("role_id", $role_delivery->id);


    // Check if the Nearest scope exists and if the store has latitude and longitude
    if (method_exists($usersQuery->getModel(), 'Nearest') && $store->lat && $store->lng) {

      $usersQuery->Nearest($store->lat, $store->lng);
    }


    $the_nearest_empty_driver = $usersQuery->whereDoesntHave("deliveryOrders")
      ->whereDoesntHave("deliveryOrderButlers")->whereDoesntHave("deliveryOrderCallcenter")->first();

    $the_nearest_the_least_loaded_driver = User::with(["deliveryOrders", "deliveryOrderButlers", "deliveryOrderCallcenter"])
      ->where("role_id", $role_delivery->id)

      ->when(method_exists($usersQuery->getModel(), 'scopeNearest') && $store->lat && $store->lng, function ($query) use ($store) {
        return $query->Nearest($store->lat, $store->lng);
      })
      ->withCount(["deliveryOrders", "deliveryOrderButlers", "deliveryOrderCallcenter"])
      ->orderByRaw("delivery_orders_count + delivery_order_butlers_count + delivery_order_callcenter_count")
      ->first();



    if ($the_nearest_empty_driver) {


      return $the_nearest_empty_driver;
    }

    if (!$the_nearest_empty_driver) {
      if ($the_nearest_the_least_loaded_driver != null) {

        return $the_nearest_the_least_loaded_driver;
      } else {


        return User::with(["deliveryOrders", "deliveryOrderButlers", "deliveryOrderCallcenter"])
          ->where("role_id", $role_delivery->id)
          ->withCount(["deliveryOrders", "deliveryOrderButlers", "deliveryOrderCallcenter"])
          ->orderByRaw("delivery_orders_count + delivery_order_butlers_count + delivery_order_callcenter_count")
          ->first();
      }
    }
  }


  public function assignDriverToOrderButler(OrderButler $order)
  {
    $role_delivery = Role::where("name", "Delivery")->first();
    $delivery = User::where("role_id", $role_delivery->id);
    // dd($order->from_address);
    $from_address = Address::whereId($order->from_address)->first();


    $usersQuery = User::where("role_id", $role_delivery->id);

    // Check if the Nearest scope exists and if the store has latitude and longitude
    if (method_exists($usersQuery->getModel(), 'scopeNearest') && $from_address->lat && $from_address->lng) {
      $usersQuery->Nearest($from_address->lat, $from_address->lng);
    }


    $the_nearest_empty_driver = $usersQuery->whereDoesntHave("deliveryOrders")
      ->whereDoesntHave("deliveryOrderButlers")->whereDoesntHave("deliveryOrderCallCenter")->first();

    $the_nearest_the_least_loaded_driver = User::with(["deliveryOrders", "deliveryOrderButlers","deliveryOrderCallCenter"])
      ->where("role_id", $role_delivery->id)

      ->when(method_exists($usersQuery->getModel(), 'scopeNearest') && $from_address->lat && $from_address->lng, function ($query) use ($from_address) {
        return $query->Nearest($from_address->lat, $from_address->lng);
      })
      ->withCount(["deliveryOrders", "deliveryOrderButlers", "deliveryOrderCallcenter"])
      ->orderByRaw("delivery_orders_count + delivery_order_butlers_count + delivery_order_callcenter_count")
      ->first();


    if ($the_nearest_empty_driver) {
      return $the_nearest_empty_driver;
    }

    if (!$the_nearest_empty_driver) {
      if ($the_nearest_the_least_loaded_driver != null) {
        return $the_nearest_the_least_loaded_driver;
      } else {
        return User::with(["deliveryOrders", "deliveryOrderButlers","deliveryOrderCallCenter"])
          ->where("role_id", $role_delivery->id)
          ->withCount(["deliveryOrders", "deliveryOrderButlers", "deliveryOrderCallcenter"])
          ->orderByRaw("delivery_orders_count + delivery_order_butlers_count + delivery_order_callcenter_count")
          ->first();
      }



    }



  }


  public function schedules()
  {
    return $this->hasMany(DeliverySchedule::class, "delivery_id");
  }




  /**
   *The Deliveries are currently available (not assigned to any order)
   * and are within their working hours based on the schedules stored in the delivery_schedules table
   */
  public static function GetAllDriverToOrders()
  {

    $delivery = User::role("Delivery", "api");

    $currentDayName = Carbon::now()->format('l');
    $day = DayTranslation::where("name", $currentDayName)->first();
    $dayId = $day->day_id;

    $currentTime = Carbon::now()->format('H:i:s');

    /**get the Query users within working hours */
    $userWithingTheirWorkingHoursQuery = User::whereHas("schedules", function ($query) use ($dayId, $currentTime) {
      $query->where("day_id", $dayId)
        ->where("from_time", "<=", $currentTime)
        ->where("to_time", ">=", $currentTime);
    });


    /**get the users that  empty now and donot have any orders */
    $userEmpty = $userWithingTheirWorkingHoursQuery->whereDoesntHave("deliveryOrders")
      ->whereDoesntHave("deliveryOrderButlers")->whereDoesntHave("deliveryOrderCallCenter")->get();

    if ($userEmpty->count() > 0) {
      return $userEmpty;
    }

    // If no empty users, get the user with the least orders
    $userWithLeastOrders = User::withCount(['deliveryOrders', 'deliveryOrderButlers', 'deliveryOrderCallcenter'])
      ->whereHas("schedules", function ($query) use ($dayId, $currentTime) {
        $query->where("day_id", $dayId)
          ->where("from_time", "<=", $currentTime)
          ->where("to_time", ">=", $currentTime);
      })
      ->orderBy('delivery_orders_count')
      ->orderBy('delivery_order_butlers_count')
      ->orderBy('delivery_order_callcenter_count')
      ->get();

    return $userWithLeastOrders;

  }
  /**
   * get the orders count of the delivery
   */
  public static function deliveryOrdersCount($userId)
  {
    $user = User::withCount('deliveryOrders', 'deliveryOrderCallcenter', 'deliveryOrderButlers')->find($userId);
    $deliveryOrdersCount = $user->delivery_orders_count;
    $deliveryOrderCallcenterCount = $user->delivery_order_callcenter_count;
    $deliveryOrderButlersCount = $user->delivery_order_butlers_count;

    return [
      'deliveryOrdersCount' => $deliveryOrdersCount,
      'deliveryOrderCallcenterCount' => $deliveryOrderCallcenterCount,
      'deliveryOrderButlersCount' => $deliveryOrderButlersCount,
    ];
  }

  public static function totalNumberOfOrders($userId)
  {

    $user = User::withCount('deliveryOrders', 'deliveryOrderCallcenter', 'deliveryOrderButlers')->find($userId);


    $deliveryOrdersCount = $user->delivery_orders_count;

    $deliveryOrderCallcenterCount = $user->delivery_order_callcenter_count;
    $deliveryOrderButlersCount = $user->delivery_order_butlers_count;
    return $deliveryOrdersCount + $deliveryOrderCallcenterCount + $deliveryOrderButlersCount;


  }

  public static function total_orders_at_the_end_of_the_month($userId)
  {

    $user = User::find($userId);
    $endOfMonth = Carbon::now()->endOfMonth();
    $startOfMonth = Carbon::now()->startOfMonth();

    $deliveryOrdersCount = $user->deliveryOrders()->where('created_at', "<=", $endOfMonth)->where('created_at', '>=', $startOfMonth)->count();


    $deliveryOrderCallcenterCount = $user->deliveryOrderCallcenter()->where('created_at', "<=", $endOfMonth)->where('created_at', '>=', $startOfMonth)->count();
    $deliveryOrderButlersCount = $user->deliveryOrderButlers()->where('created_at', "<=", $endOfMonth)->where('created_at', '>=', $startOfMonth)->count();


    return $deliveryOrdersCount + $deliveryOrderCallcenterCount + $deliveryOrderButlersCount;


  }











}
