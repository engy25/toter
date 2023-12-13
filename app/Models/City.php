<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Helpers\Helpers;

class City extends Model implements TranslatableContract
{
  use HasFactory, Translatable;
  protected $guarded = [];


  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($city) {
      /***check if the city related to any other table */

      if ($city->districts()->count() > 0) {
        return false;
      } else {
        return true;
      }
    });
  }


  public $translatedAttributes = ['name'];
  public function nameTranslation($locale)
  {
    $translation = $this->translations->where('locale', $locale)->first();

    return $translation ? $translation->name : $this->name;
  }
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
