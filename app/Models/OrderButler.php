<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\OrderButlerObserver;

class OrderButler extends Model
{
  use HasFactory;
  protected $guarded = [];

  protected static function booted()
  {
    static::observe(OrderButlerObserver::class);

  }

  public function admin()
  {
    return $this->belongsTo(User::class, "admin_id");
  }

  public function user()
  {
    return $this->belongsTo(User::class, "user_id");
  }

  public function driver()
  {
    return $this->belongsTo(User::class, "driver_id");
  }


  public function fromAddress()
  {
    return $this->belongsTo(Address::class, "from_address");
  }

  public function toAddress()
  {
    return $this->belongsTo(Address::class, "to_address");
  }

  public function coupon()
  {
    return $this->belongsTo(Coupon::class, "coupon_id");
  }



  public function butler()
  {
    return $this->belongsTo(Butler::class, "butler_id");
  }

  /**
   * this currency that the app have
   */
  public function defaultCurrency()
  {
    return $this->belongsTo(Currency::class, "default_currency_id");
  }


  /**
   * this currency that user paid
   */
  public function toCurrency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function orderItems()
  {
    return $this->hasMany(OrderButlerItem::class, "order_id");

  }

  public function status()
  {
    return $this->belongsTo(Status::class);

  }


  public function district()
  {
    return $this->belongsTo(CompanyDistrict::class,"district_id");

  }

  public function statuses()
  {
    return $this->morphToMany(Status::class, 'ordereable', 'order_statuses', 'ordereable_id', 'status_id')
      ->withTimestamps();
  }

  public function deliveryTrack()
  {
    return $this->morphOne(Delivery::class, 'ordereable','ordereable_id');

  }

}
