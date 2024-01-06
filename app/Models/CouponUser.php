<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model {

	protected $table = 'coupon_users';
	public $timestamps = true;

	use HasFactory;
  protected $guarded = [];

}
