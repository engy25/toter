<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Helpers\Helpers;

class Drink extends Model implements TranslatableContract
{

  protected $table = 'drinks';
  public $timestamps = true;

  use SoftDeletes, HasFactory, Translatable;

  public $translatedAttributes = ['name'];
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  protected $dates = ['deleted_at'];
  protected $guarded = [];

  public function getImageAttribute()
  {
    return asset('storage/images/drinks/' . $this->attributes['image']);
  }
  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/drinks/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/drinks/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/drinks/');
      $this->attributes['image'] = $image;
    }
  }

  public function options()
  {
    return $this->morphMany(CartItemOption::class, 'optionable');
  }
  public function items()
  {
    return $this->belongsToMany(Item::class, 'item_drinks', 'drink_id', 'item_id');
  }
  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(DrinkTranslation::class);
  }

  public function store()
  {
    return $this->belongsTo(Store::class);
  }



}
