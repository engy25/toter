<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Service extends Model implements TranslatableContract
{

  protected $table = 'services';
  public $timestamps = true;

  protected $guarded = [];

  use SoftDeletes, HasFactory, Translatable;
  public $translatedAttributes = ['name'];

  protected $dates = ['deleted_at'];

  public function item()
  {
    return $this->belongsTo(Item::class);
  }
  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(ServiceTranslation::class);
  }


}
