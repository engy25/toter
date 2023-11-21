<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\EventListener\AddRequestFormatsListener;
class Order extends Model {

	protected $table = 'orders';
	public $timestamps = true;

	use SoftDeletes,HasFactory;
  protected $guarded = [];
	protected $dates = ['deleted_at'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function delivery()
  {
    return $this->belongsTo(User::class);
  }

  public function address()
  {
    return $this->belongsTo(Address::class);
  }

  public function offer()
  {
    return $this->belongsTo(Offer::class);
  }

  public function defaultCurrency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function from_address()
  {
    return $this->belongsTo(Address::class);
  }

  public function to_address()
  {
    return $this->belongsTo(Address::class);
  }

  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }

	public function statuses()
	{
		return $this->belongsToMany(Status::class, 'order_statuses', 'order_id', 'status_id')->withTimestamps();
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
  public function item()
  {
    return $this->belongsTo(Item::class);
  }


}
