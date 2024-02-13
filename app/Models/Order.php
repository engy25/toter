<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\EventListener\AddRequestFormatsListener;

class Order extends Model
{

  protected $table = 'orders';
  public $timestamps = true;

  use HasFactory;
  protected $guarded = [];
  protected static function booted()
  {
    static::observe(OrderObserver::class);
  }


  public function user()
  {
    return $this->belongsTo(User::class, "user_id");
  }

  public function delivery()
  {
    return $this->belongsTo(User::class, "driver_id");
  }
  public function vendor()
  {
    return $this->belongsTo(User::class, "vendor_id");
  }


  public function offer()
  {
    return $this->belongsTo(Offer::class);
  }

  public function defaultCurrency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function address()
  {
    return $this->belongsTo(Address::class,"address_id");
  }



  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }


  public function deliveryTrack()
{
    return $this->morphOne(Delivery::class, 'ordereable');
}



  public function statuses()
  {
    return $this->morphToMany(Status::class, 'ordereable', 'order_statuses', 'ordereable_id', 'status_id')
      ->withTimestamps();
  }




  public function store()
  {
    return $this->belongsTo(Store::class);
  }

  public function status()
  {
    return $this->belongsTo(Status::class);
  }

  public function size()
  {
    return $this->belongsTo(Size::class);
  }
  public function gift()
  {
    return $this->belongsTo(ItemGift::class);
  }

  public function option()
  {
    return $this->belongsTo(Option::class);
  }

  public function preference()
  {
    return $this->belongsTo(Preference::class);
  }
  // public function item()
  // {
  //   return $this->belongsTo(Item::class);
  // }


  public function orderItems()
  {
    return $this->morphMany(OrderItem::class, 'ordereable');
  }
  public function currency()
  {
    return $this->belongsTo(Currency::class, "default_currency_id");
  }

  public function district()
  {
    return $this->belongsTo(District::class);
  }

}
