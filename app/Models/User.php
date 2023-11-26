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

class User extends Authenticatable
{

  protected $table = 'users';
  public $timestamps = true;

  use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

  public $helper;
  public function __construct()
  {
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

  protected static function booted()
  {
    static::created(function ($user) {
      // Check the number of orders for the user this month
      $orderCount = Order::where("user_id", $user->id)
        ->where('created_at', '>=', Carbon::now()->month)->count();
      if ($orderCount >= 10) {
        // Update the user to the golden tier
        $user->update(['tier_id' => '2']);
      }

    });

  }

  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/user/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/user/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/user/');
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


  public function role()
  {
    return $this->belongsTo(Role::class);
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

  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  public function count_orders_created_this_month()
  {

    return $this->orders()->where('created_at', '>=', Carbon::now()->month)
      ->count();


  }


  public function providers()
  {
    return $this->hasMany(Provider::class);
  }



}
