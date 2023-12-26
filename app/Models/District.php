<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class District extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $guarded=[];
    public $translatedAttributes = ['name'];


  protected static function boot()
  {
    parent::boot();
    static::deleting(function ($district) {
      /***check if the city related to any other table */

      if ($district->stores()->count() > 0) {
        return false;
      } else {
        return true;
      }
    });
  }

  public function stores()
  {
    return $this->belongsToMany(Store::class,"store_districts","district_id","store_id")->withPivot("delivery_charge","id");

  }
    public function city()
    {
      return $this->belongsTo(City::class);
    }
    public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
      return $this->hasMany(DistrictTranslation::class);
    }
    public function nameTranslation($locale)
    {
      $translation = $this->translations->where('locale', $locale)->first();

      return $translation ? $translation->name : $this->name;
    }

}
