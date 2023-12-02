<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Helpers\Helpers;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Ingredient extends Model implements TranslatableContract {

	protected $table = 'ingredients';
	public $timestamps = true;

	use SoftDeletes,HasFactory,Translatable;
  public $translatedAttributes = ['name'];
	protected $dates = ['deleted_at'];
  protected $guarded = [];
  public $helper;
  public function __construct()
  {
      $this->helper= new Helpers();
  }

  public function getImageAttribute()
  {
    return asset('storage/images/ingredients/' . $this->attributes['image']);
  }
  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/ingredients/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/ingredients/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/ingredients/');
      $this->attributes['image'] = $image;
    }
  }

  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(IngredientTranslation::class);
  }

  public function options()
  {
    return $this->morphMany(CartItemOption::class, 'optionable');
  }

  public function item()
  {
    return $this->belongsTo(Item::class);
  }
  public function store()
  {
    return $this->belongsTo(Store::class);
  }

}
