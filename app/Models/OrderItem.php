<?php

namespace App\Models;

use App\Models\Scopes\ItemScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

  protected $table = 'order_items';
  public $timestamps = true;

  use HasFactory;
  protected $guarded = [];
  protected $casts = [
    'addingredients' => 'array',
    'options' => 'array',
    'drinks' => 'array',
    'sides' => 'array',
    'services' => 'array',
    'remove_ingredients' => 'array',
    'addons' => 'array'


  ];



  public function getAddonsAttribute($value)
  {
    $val = json_decode($value);
    return $value ? Addon::whereIn('id', $val)->get() : [];
  }

  public function getRemoveIngredientsAttribute($value)
  {
    $val = json_decode($value);
    return $value ? Ingredient::whereIn('id', $val)->get() : [];
  }


  public function getServicesAttribute($value)
  {
    $val = json_decode($value);
    return $value ? Service::whereIn('id', $val)->get() : [];
  }

  public function getSidesAttribute($value)
  {
    $val = json_decode($value);
    return $value ? Side::whereIn('id', $val)->get() : [];
  }
  public function getDrinksAttribute($value)
  {
    $val = json_decode($value);
    return $value ? Drink::whereIn('id', $val)->get() : [];
  }
  public function getAddingredientsAttribute($value)
  {
    $val = json_decode($value);

    return $value ? Ingredient::whereIn('id', $val)->get() : [];
  }

  public function getOptionsAttribute($value)
  {
    $val = json_decode($value);

    return $value ? Option::whereIn('id', $val)->get() : [];
  }

  public function item()
  {
    return $this->belongsTo(Item::class)->withoutGlobalScope(ItemScope::class);
  }

  public function size()
  {
    return $this->belongsTo(Size::class);
  }

  public function preference()
  {
    return $this->belongsTo(Preference::class);
  }

  public function option()
  {
    return $this->belongsTo(Option::class);
  }

  public function gift()
  {
    return $this->belongsTo(ItemGift::class, "gift_id");
  }


  public function ordereable()
  {
    return $this->morphTo();
  }

}
