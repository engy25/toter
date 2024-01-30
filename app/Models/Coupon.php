<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model {

	protected $table = 'coupons';
	public $timestamps = false;

	use HasFactory;

  protected $guarded = [];



  public function scopeLive($query)
  {
    $query->where("expire_date",'>=',date('Y-m-d'))->where("is_active",1);
  }

	public function users()
	{
		return $this->belongsToMany(User::class, 'coupon_users', 'coupon_id', 'user_id');
	}

	public function store()
	{
		return $this->belongsTo(Store::Class);
	}
  public function items()
  {
    return $this->belongsToMany(Item::class, 'coupon_items', 'coupon_id', 'item_id');
  }

}
