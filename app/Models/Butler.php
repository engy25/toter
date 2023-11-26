<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helpers;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Butler extends Model implements TranslatableContract
{
  use HasFactory, Translatable;

  public $translatedAttributes = ['name', 'description'];
  protected $guarded = [];

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function getImageAttribute()
  {
    return asset('storage/images/butlers/' . $this->attributes['image']);
  }
  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/butlers/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/butlers/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/butlers/');
      $this->attributes['image'] = $image;
    }
  }

  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(ButlerTranslation::class);
  }


  public function admin()
  {
    return $this->belongsTo(User::class);
  }


  public function defaultCurrency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function toCurrency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function section()
  {
    return $this->belongsTo(Section::class);
  }
}
