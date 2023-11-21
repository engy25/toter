<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class StoreCategory extends Model implements TranslatableContract
{
  use SoftDeletes, HasFactory, Translatable;
  protected $table = 'store_categories';
  public $timestamps = true;
  protected $dates = ['deleted_at'];
  protected $guarded = [];

  public $translatedAttributes = ['name','description'];

  public function store()
  {
    return $this->belongsTo(Store::class);
  }
  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(StoreCategoryTranslation::class);
  }

}
