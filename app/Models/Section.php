<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Helpers\Helpers;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Section extends Model implements TranslatableContract
{

  protected $table = 'sections';
  public $timestamps = false;
  protected $guarded = [];
  use SoftDeletes, HasFactory, Translatable;
  public $translatedAttributes = ['name', 'description'];

  protected $dates = ['deleted_at'];


  public function subsections()
  {
    return $this->hasMany(Subsection::class);
  }

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function getImageAttribute()
  {
    return asset('storage/images/sections/' . $this->attributes['image']);
  }
  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/sections/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/sections/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/sections/');
      $this->attributes['image'] = $image;
    }
  }


  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(SectionTranslation::class);
  }

  public function stores()
  {
      return $this->hasMany(Store::class, 'section_id');
  }

  public function scopeSectionsWithSurroundedStores($query, $user_lat, $user_lng)
  {
      $user_lat = (float) $user_lat;
      $user_lng = (float) $user_lng;
      $stores = Store::Surrounded($user_lat, $user_lng)->get();
      $additionalSectionIds=[16,15,6];
      $storeIds =array_merge($stores->pluck('section_id')->toArray(),$additionalSectionIds);
      return $query->whereIn('id', $storeIds);
  }

  public function scopeValid($query)
  {
      $query->whereNotIn('id',[1,15,6,16,4,7]);
  }






}
