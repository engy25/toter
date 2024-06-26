<?php

namespace App\Models;

use App\Models\Scopes\ItemScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Helpers\Helpers;

class Size extends Model implements TranslatableContract
{

  use  HasFactory, Translatable;
  protected $table = 'sizes';
  public $timestamps = true;


  protected $guarded = [];

  public $translatedAttributes = ['name'];

  public $helper;


  public function getImageAttribute()
  {
    return asset('storage/images/sides/' . $this->attributes['image']);
  }


  public function item()
  {
    return $this->belongsTo(Item::class)->withoutGlobalScope(ItemScope::class);
  }
  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(SizeTranslation::class);
  }
  public function store()
  {
    return $this->belongsTo(Store::class);
  }

  public function getcurrencyAttribute()
  {
    $default_currency = Currency::where("default", 1)->first();
    $currency_name = CurrencyTranslation::where("currency_id", $default_currency->id)->first();
    return $currency_name->name;

  }
}
