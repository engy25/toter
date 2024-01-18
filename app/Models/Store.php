<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;
use App\Helpers\Helpers;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Store extends Model implements TranslatableContract
{

  use  HasFactory, Translatable;
  protected $table = 'stores';
  public $timestamps = true;
  protected $guarded = [];
  public $translatedAttributes = ['name', 'description'];


  protected static function boot()
  {
      parent::boot();

      static::deleting(function ($store) {
          /***check if the subsection related to any other table */
          if ($store->districts()->count() >0|| $store->points()->count() > 0 || $store->tags()->count() > 0
           || $store->items()->count() > 0  || $store->favourites()->count() > 0
           || $store->reviews()->count() > 0                 ) {
              // There are related records in either offers or stores
              return false;
          } else {
              // No related records, proceed with deletion
              $store->weekHours()->delete();
               $store->translations()->delete();
              return true;
          }
      });



  }


  public function getImageAttribute()
  {
    return asset('storage/images/stores/' . $this->attributes['image']);
  }




  public function points()
  {
    return $this->morphMany(PointUser::class, 'pointeable');
  }

  public function pointstore()
  {
    return $this->hasOne(PointStore::class);
  }
  public function admin()
  {
    return $this->belongsTo(User::class);
  }

  public function sub_section()
  {
    return $this->belongsTo(Subsection::class);
  }

  public function defaultCurrency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function toCurrency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function tags()
  {
    return $this->hasMany(StoreCategory::class);
  }

  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(StoreTranslation::class);
  }
  public function weekHours()
  {
    return $this->hasMany(Weekhour::class);
  }

  public function getcurrencyIsoCodeAttribute()
  {
    $default_currency = Currency::where("default", 1)->first();

    return $default_currency->isocose;

  }



  public function scopeNearest($query, $lat, $lng)
  {
    $lat = (float) $lat;
    $lng = (float) $lng;
    $space_search_by_kilos = 10000;
    $query->select(\DB::raw("*,
              (6371 * ACOS(COS(RADIANS($lat))
              * COS(RADIANS(lat))
              * COS(RADIANS($lng) - RADIANS(lng))
              + SIN(RADIANS($lat))
              * SIN(RADIANS(lat)))) AS distance"))
      ->having('distance', '<=', $space_search_by_kilos)
      ->orderBy('distance', 'asc')->get();
  }

  public function scopeSurrounded($query, $lat, $lng)
  {
    $lat = (float) $lat;
    $lng = (float) $lng;
    $space_search_by_kilos = 100000;
    $query->select(\DB::raw("*,
              (6371 * ACOS(COS(RADIANS($lat))
              * COS(RADIANS(lat))
              * COS(RADIANS($lng) - RADIANS(lng))
              + SIN(RADIANS($lat))
              * SIN(RADIANS(lat)))) AS distance"))
      ->having('distance', '<=', $space_search_by_kilos)
      ->orderBy('distance', 'asc')->get();
  }


  public function section()
  {
    return $this->belongsto(Section::class);
  }

  public function items()
  {
    return $this->hasMany(Item::class);
  }

  public function drinks()
  {
    return $this->hasMany(Drink::class);
  }
  public function addons()
  {
    return $this->hasMany(Addon::class);
  }


  public function Addingredients()
  {
    return $this->hasMany(Ingredient::class)->where("add", 1);
  }

  public function Removeingredients()
  {
    return $this->hasMany(Ingredient::class)->where("add", 0);
  }
  public function favourites()
  {
    return $this->morphMany(Favourite::class, 'favoriteable');
  }


  public function reviews()
  {
    return $this->morphMany(Review::class, 'reviewable');
  }

  public function offer()
  {
    return $this->hasOne(Offer::class);
  }


  public function getStatusValueAttribute()
  {
    $todayName = Carbon::parse(now())->dayName;
    $lang = app()->getLocale();


    $weekHourRestaurantToday = Weekhour::where(['weekhours.store_id' => $this->id])
      ->join('days', 'days.id', 'weekhours.day_id')
      ->join('day_translations as dTrans', 'dTrans.day_id', 'days.id')
      ->where(['dTrans.locale' => $lang, 'dTrans.name' => $todayName])
      ->where(['name' => $todayName])
      ->select([
        'weekhours.from',
        'weekhours.to',
      ])->first();

    return now()->format('H:i:s') < ($weekHourRestaurantToday->to ?? null) && now()->format('H:i:s') > ($weekHourRestaurantToday->from ?? null) ? trans('api.open') : trans('api.close');
  }

  public function getTodayWorkingHoursAttribute()
  {
    $todayName = Carbon::parse(now())->dayName;
    $lang = app()->getLocale();

    $weekHourRestaurantToday = Weekhour::where(['weekhours.store_id' => $this->id])
      ->join('days', 'days.id', 'weekhours.day_id')
      ->join('day_translations as dTrans', 'dTrans.day_id', 'days.id')
      ->where(['dTrans.locale' => $lang, 'dTrans.name' => $todayName])
      ->select([
        'weekhours.from',
        'weekhours.to',
      ])->first();

    $weekHourRestaurantToday = Carbon::parse($weekHourRestaurantToday->from)->format('g:i A') . ' - ' . Carbon::parse($weekHourRestaurantToday->to)->format('g:i A');
    return $weekHourRestaurantToday;
  }

  public function getcurrencyAttribute()
  {
    $default_currency = Currency::where("default", 1)->first();
    $currency_name = CurrencyTranslation::where("currency_id", $default_currency->id)->first();
    return $currency_name->name;

  }
  public function getcurrencyIdAttribute()
  {
    $default_currency = Currency::where("default", 1)->first();

    return $$default_currency->id;

  }

  public function districts()
  {
    return $this->belongsToMany(District::class,"store_districts","store_id","district_id")->withPivot("delivery_charge","id");

  }

}
