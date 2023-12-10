<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Helpers\Helpers;
class City extends  Model implements TranslatableContract
{
  use  HasFactory, Translatable;
  protected $guarded = [];

  public function country()
  {
    return $this->belongsTo(Country::class);
  }

  public function districts()
  {
    return $this->hasMany(District::class);
  }

  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
      return $this->hasMany(CityTranslation::class);
  }
}
