<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Addon extends Model implements TranslatableContract
{

  protected $table = 'addons';
  public $timestamps = true;

  use SoftDeletes, HasFactory, Translatable;
  protected $guarded = [];

  protected $dates = ['deleted_at'];

  public function getImageAttribute()
  {
    return asset('storage/images/addons/' . $this->attributes['image']);
  }
  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/addons/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/addons/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/addons/');
      $this->attributes['image'] = $image;
    }
  }

  public function options()
  {
    return $this->morphMany(CartItemOption::class, 'optionable');
  }


}
