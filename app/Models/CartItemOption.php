<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CartItemOption extends Model
{

  protected $table = 'cart_item_options';
  public $timestamps = true;

  use SoftDeletes, HasFactory;

  protected $guarded = [];
  protected $dates = ['deleted_at'];

  public function optionable()
  {
    return $this->morphTo();
  }

  public function cart()
  {
    return $this->belongsTo(Cart::class);

  }

}
