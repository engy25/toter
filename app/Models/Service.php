<?php

namespace App\Models;

use App\Models\Scopes\ItemScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Service extends Model implements TranslatableContract
{

  protected $table = 'services';
  public $timestamps = true;

  protected $guarded = [];

  use  HasFactory, Translatable;
  public $translatedAttributes = ['name'];


  public function item()
  {
    return $this->belongsTo(Item::class)->withoutGlobalScope(ItemScope::class);
  }
  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(ServiceTranslation::class);
  }
  public function store()
  {
    return $this->belongsTo(Store::class);
  }

  public function options()
  {
    return $this->morphMany(CartItemOption::class, 'optionable');
  }
  public function getcurrencyAttribute()
  {
    $default_currency = Currency::where("default", 1)->first();
    $currency_name = CurrencyTranslation::where("currency_id", $default_currency->id)->first();
    return $currency_name->name;

  }
}
