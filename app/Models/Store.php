<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Helpers\Helpers;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Store extends Model implements TranslatableContract
{

  use SoftDeletes, HasFactory, Translatable;
  protected $table = 'stores';
  public $timestamps = true;
  protected $guarded = [];
  public $translatedAttributes = ['name', 'description'];

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function getImageAttribute()
  {
    return asset('storage/images/stores/' . $this->attributes['image']);
  }
  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/stores/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/stores/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/stores/');
      $this->attributes['image'] = $image;
    }
  }

  protected $dates = ['deleted_at'];

  public function points()
  {
    return $this->morphMany(PointUser::class, 'pointeable');
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

  public function storeCategories()
  {
    return $this->hasMany(StoreCategory::class);
  }

  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(StoreTranslation::class);
  }

}
