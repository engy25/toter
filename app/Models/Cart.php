<?php

namespace App\Models;

use App\Models\Scopes\ItemScope;
use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{

  protected $table = 'carts';
  public $timestamps = true;

  use SoftDeletes, HasFactory;
  protected $guarded = [];
  protected $dates = ['deleted_at'];

  /**
   * observer class //events
   */
  // protected static function booted()
  // {
  //   // static::creating(function(Cart $cart){
  //   //   $cart->id=Str::uuid();

  //   // });
  //   static::observe(CartObserver::class);
  // }
  public function cartItems()
  {
    return $this->hasMany(CartItemOption::class);
  }
  public function store()
  {
    return $this->belongsTo(Store::class);
  }




  public function user()
  {
    return $this->belongsTo(User::class);
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
    return $this->belongsTo(Item::class)->withoutGlobalScope(ItemScope::class);
  }




}
