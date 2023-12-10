<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantDelivery extends Model
{
  use HasFactory;
  protected $guarded = [];
  public function delivery()
  {
    return $this->belongsTo(User::class);
  }

  public function restaurant()
  {
    return $this->belongsTo(Store::class,"restaurant_id");

  }
}
