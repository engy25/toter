<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Helpers\Helpers;

class Country extends Model implements TranslatableContract

{

  protected $table = 'countries';
  public $timestamps = true;

  use SoftDeletes, HasFactory, Translatable;

  public $translatedAttributes = ['name'];

  protected $dates = ['deleted_at'];
  protected $guarded = [];

  public $helper;
  public function __construct()
  {
      $this->helper= new Helpers();
  }

  public function getFlagAttribute()
  {
    return asset('storage/images/countryFlag/' . $this->attributes['flag']);
  }
  public function setFlagAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['flag']) && $this->attributes['flag']) {


        if (file_exists(storage_path('app/public/images/countryFlag/' . $this->attributes['flag']))) {
          \File::delete(storage_path('app/public/images/countryFlag/' . $this->attributes['flag']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/countryFlag/');
      $this->attributes['flag'] = $image;
    }
  }

  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
      return $this->hasMany(CountryTranslation::class);
  }
  public function currency()
  {
    return $this->belongsTo(Currency::class);
  }





}
