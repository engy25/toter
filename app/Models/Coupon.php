<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {

	protected $table = 'coupons';
	public $timestamps = true;

	use SoftDeletes,HasFactory;

  protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function users()
	{
		return $this->belongsToMany(User::class, 'coupon_users', 'coupon_id', 'user_id');
	}

	public function store()
	{
		return $this->belongsTo(Store::Class);
	}

}
