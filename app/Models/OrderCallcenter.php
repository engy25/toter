<?php

namespace App\Models;

use App\Observers\OrderCallCenterObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCallcenter extends Model
{
  use HasFactory;
  protected $guarded = [];

  protected static function booted()
  {
    static::observe(OrderCallCenterObserver::class);
  }


  public function store()
  {
    return $this->belongsTo(Store::class, "store_id");
  }


  public function user()
  {
    return $this->belongsTo(User::class, "user_id");
  }

  public function vendor()
  {
    return $this->belongsTo(User::class, "vendor_id");
  }

  public function delivery()
  {
    return $this->belongsTo(User::class, "delivery_id");
  }

  public function callcenter()
  {
    return $this->belongsTo(User::class, "callcenter_id");
  }


  public function address()
  {
    return $this->belongsTo(Address::class, "address_id");
  }

  public function status()
  {
    return $this->belongsTo(Status::class);
  }
  public function orderItems()
  {
    return $this->morphMany(OrderItem::class, 'ordereable');
  }
  public function statuses()
  {
      return $this->morphToMany(Status::class, 'ordereable', 'order_statuses', 'ordereable_id', 'status_id')
          ->withTimestamps();
  }
  public function currency()
  {
    return $this->belongsTo(Currency::class, "currency_id");
  }

}
