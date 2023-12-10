<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {

	protected $table = 'order_items';
	public $timestamps = true;

	use HasFactory;
  protected $guarded = [];
	protected $dates = ['deleted_at'];

  public function order(){
    return $this->belongsTo(Order::class);
  }

  public function item()
{
    return $this->belongsTo(Item::class);
}

}
