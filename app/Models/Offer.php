<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helpers;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Offer extends Model implements TranslatableContract {

	protected $table = 'offers';
	public $timestamps = true;

	use SoftDeletes,HasFactory,Translatable;
  public $translatedAttributes = ['name','description'];
  protected $guarded = [];
  public $helper;
  public function __construct()
  {
      $this->helper= new Helpers();
  }
	protected $dates = ['deleted_at'];

	public function points()
	{
		return $this->morphMany(PointStore::class, 'pointeable');
	}


  public function getImageAttribute()
  {
    return asset('storage/images/offers/' . $this->attributes['image']);
  }
  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/offers/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/offers/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/offers/');
      $this->attributes['image'] = $image;
    }
  }

  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(OfferTranslation::class);
  }

}
