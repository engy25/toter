<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Day extends Model implements TranslatableContract
{
  use HasFactory,Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded=[];
    public function days()
    {
      return $this->belongsToMany(Item::class, 'item_days', 'day_id', 'item_id');
    }


  public function options()
  {
    return $this->morphMany(CartItemOption::class, 'optionable');
  }

    public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
      return $this->hasMany(DayTranslation::class);
    }
    public function deliverySchedules()
    {
        return $this->hasMany(DeliverySchedule::class, 'day_id');
    }
}
