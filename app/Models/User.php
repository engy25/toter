<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helpers;
use Illuminate\Support\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {

  protected $table = 'users';
  public $timestamps = true;

  use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

  public $helper;
  public function __construct() {
    $this->helper = new Helpers();
  }
  protected $dates = ['deleted_at'];
  protected $guarded = [];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
    //'password' => 'hashed',
  ];

  protected static function booted() {
    static::created(function ($user) {
      // Check the number of orders for the user this month
      $orderCount = Order::where("user_id", $user->id)
        ->where('created_at', '>=', Carbon::now()->month)->count();
      if($orderCount >= 10) {
        // Update the user to the golden tier
        $user->update(['tier_id' => '2']);
      }

    });

  }

  public function setImageAttribute($value) {
    if($value && $value->isValid()) {
      if(isset($this->attributes['image']) && $this->attributes['image']) {


        if(file_exists(storage_path('app/public/images/user/'.$this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/user/'.$this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/user/');
      $this->attributes['image'] = $image;
    }
  }


  public function getImageAttribute() {
    $image = isset($this->attributes['image']) && $this->attributes['image'] ? 'storage/images/user/'.$this->attributes['image'] : asset('https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y');
    return asset($image);
  }


  public function setPasswordAttribute($value) {
    if($value) {
      $this->attributes['password'] = bcrypt($value);
    }
  }


  // public function role() {
  //   return $this->belongsTo(Role::class);
  // }

  public function addresses() {
    return $this->hasMany(Address::class);
  }

  public function reviews() {
    return $this->morphMany(Review::class, 'reviewable');
  }

  public function searchHistories() {
    return $this->hasMany(SearchHistory::class);
  }

  public function coupons() {
    return $this->hasOne(Coupon::class, 'coupon_users', 'user_id', 'coupon_id');
  }

  public function notifeable() {
    return $this->morphMany(Notification::class, 'notifeable');
  }

  public function tier() {
    return $this->belongsTo(Tier::class);
  }

  public function teirPoints() {
    return $this->morphedByMany(Tier::class, 'pointeable', 'point_users');
  }

  public function storePoints() {
    return $this->morphedByMany(Store::class, 'pointeable', 'point_users');
  }

  public function punchcardPoints() {
    return $this->morphedByMany(User::class, 'pointeable', 'point_users');
  }

  public function offerPoints() {
    return $this->morphedByMany(Offer::class, 'pointeable', 'point_users');
  }

  public function devices() {

    return $this->hasMany(Device::class);
  }

  public function userOrders() {
    return $this->hasMany(Order::class, "user_id");
  }

  public function deliveryOrders() {
    return $this->hasMany(Order::class, "driver_id");
  }

  public function userOrderButlers() {
    return $this->hasMany(OrderButler::class, "user_id");
  }

  public function deliveryOrderButlers() {
    return $this->hasMany(OrderButler::class, "driver_id");
  }

  public function count_orders_created_this_month() {

    return $this->userOrders()->where('created_at', '>=', Carbon::now()->month)
      ->count();


  }


  public function providers() {
    return $this->hasMany(Provider::class);
  }



  public function userPoints() {
    $user_id = auth('api')->id();
    $point_user = PointUser::where("user_id", $user_id)->where("expired_at", '>=', date('Y-m-d'))->sum('point_earned');
    $offer_point = OfferUser::where("user_id", $user_id)->where("expire_at", '>=', date('Y-m-d'))->sum('point_earned');


    $points = $point_user + $offer_point;

    return (int)$points;
  }

  public function userExpiredPointsCount() {
    $user_id = auth('api')->id();
    $point_user = PointUser::where("user_id", $user_id)->where("expired_at", '<', date('Y-m-d'))->sum('point_expired');
    $offer_point = OfferUser::where("user_id", $user_id)->where("expire_at", '<', date('Y-m-d'))->sum('point_expired');


    $points = $point_user + $offer_point;

    return (int)$points;
  }


  public function userUsedPointsCount() {
    $user_id = auth('api')->id();
    $point_user = PointUser::where("user_id", $user_id)->where("expired_at", '>=', date('Y-m-d'))->sum('point_used');
    $offer_point = OfferUser::where("user_id", $user_id)->where("expire_at", '>=', date('Y-m-d'))->sum('point_used');


    $points = $point_user + $offer_point;

    return (int)$points;
  }


  public function scopeNearest($query, $lat, $lng) {
    $lat = (float)$lat;
    $lng = (float)$lng;
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




  public function assignDriverToOrder(Order $order) {
    $role_delivery = Role::where("name", "Delivery")->first();
    $delivery = User::where("role_id", $role_delivery->id);
    $store = Store::whereId($order->store_id)->first();

    $usersQuery = User::where("role_id", $role_delivery->id);

    // Check if the Nearest scope exists and if the store has latitude and longitude
    if(method_exists($usersQuery->getModel(), 'scopeNearest') && $store->lat && $store->lng) {
      $usersQuery->Nearest($store->lat, $store->lng);
    }


    $the_nearest_empty_driver = $usersQuery->whereDoesntHave("deliveryOrders")
      ->whereDoesntHave("deliveryOrderButlers")->first();

    $the_nearest_the_least_loaded_driver = User::with(["deliveryOrders", "deliveryOrderButlers"])
      ->where("role_id", $role_delivery->id)

      ->when(method_exists($usersQuery->getModel(), 'scopeNearest') && $store->lat && $store->lng, function ($query) use ($store) {
        return $query->Nearest($store->lat, $store->lng);
      })
      ->withCount(["deliveryOrders", "deliveryOrderButlers"])
      ->orderByRaw("delivery_orders_count + delivery_order_butlers_count")
      ->first();



    if($the_nearest_empty_driver) {
      return $the_nearest_empty_driver;
    }

    if(!$the_nearest_empty_driver) {
      if($the_nearest_the_least_loaded_driver != null) {
        return $the_nearest_the_least_loaded_driver;
      } else {
        return User::with(["deliveryOrders", "deliveryOrderButlers"])
          ->where("role_id", $role_delivery->id)
          ->withCount(["deliveryOrders", "deliveryOrderButlers"])
          ->orderByRaw("delivery_orders_count + delivery_order_butlers_count")
          ->first();
      }
    }
  }




  public function assignDriverToOrderButler(OrderButler $order) {
    $role_delivery = Role::where("name", "Delivery")->first();
    $delivery = User::where("role_id", $role_delivery->id);
    // dd($order->from_address);
    $from_address = Address::whereId($order->from_address)->first();


    $usersQuery = User::where("role_id", $role_delivery->id);

    // Check if the Nearest scope exists and if the store has latitude and longitude
    if(method_exists($usersQuery->getModel(), 'scopeNearest') && $from_address->lat && $from_address->lng) {
      $usersQuery->Nearest($from_address->lat, $from_address->lng);
    }


    $the_nearest_empty_driver = $usersQuery->whereDoesntHave("deliveryOrders")
      ->whereDoesntHave("deliveryOrderButlers")->first();

    $the_nearest_the_least_loaded_driver = User::with(["deliveryOrders", "deliveryOrderButlers"])
      ->where("role_id", $role_delivery->id)

      ->when(method_exists($usersQuery->getModel(), 'scopeNearest') && $from_address->lat && $from_address->lng, function ($query) use ($from_address) {
        return $query->Nearest($from_address->lat, $from_address->lng);
      })
      ->withCount(["deliveryOrders", "deliveryOrderButlers"])
      ->orderByRaw("delivery_orders_count + delivery_order_butlers_count")
      ->first();


    if($the_nearest_empty_driver) {
      return $the_nearest_empty_driver;
    }

    if(!$the_nearest_empty_driver) {
      if($the_nearest_the_least_loaded_driver != null) {
        return $the_nearest_the_least_loaded_driver;
      } else {
        return User::with(["deliveryOrders", "deliveryOrderButlers"])
          ->where("role_id", $role_delivery->id)
          ->withCount(["deliveryOrders", "deliveryOrderButlers"])
          ->orderByRaw("delivery_orders_count + delivery_order_butlers_count")
          ->first();
      }



    }



  }


}
