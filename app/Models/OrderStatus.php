<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model {

	protected $table = 'order_statuses';
	public $timestamps = true;

	use SoftDeletes,HasFactory;

	protected $dates = ['deleted_at'];
  protected $guarded = [];
  public function ordereable()
	{
		return $this->morphTo();
	}
}
