<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Helpers\Helpers;
use Illuminate\Support\Carbon;

class Tier extends Model implements TranslatableContract
{
  use SoftDeletes, HasFactory, Translatable;

  protected $table = 'tiers';
  public $timestamps = true;
  protected $dates = ['deleted_at'];
  public $translatedAttributes = ['name', 'description'];
  protected $guarded = [];


  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function getImageAttribute()
  {
    return asset('storage/images/tiers/' . $this->attributes['image']);
  }
  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/tiers/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/tiers/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/tiers/');
      $this->attributes['image'] = $image;
    }
  }

  public function points()
  {
    return $this->morphMany(PointUser::class, 'pointeable');
  }
  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(TierTranslation::class);
  }

  public function currency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function count_orders_created_this_month()
  {

    return \DB::table('orders')->where('user_id', auth('api')->user()->id)->where('created_at', '>=', Carbon::now()->month)->count();


  }

  public function userPoints()
  {
      $user_id = auth('api')->id();
      $point_user = PointUser::where("user_id", $user_id)->sum('point_earned');
      return (int)$point_user;
  }



}
