<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Drink extends Model implements TranslatableContract{

	protected $table = 'drinks';
	public $timestamps = true;

  use SoftDeletes, HasFactory, Translatable;

  public $translatedAttributes = ['name'];

	protected $dates = ['deleted_at'];
  protected $guarded = [];
	public function items()
	{
		return $this->belongsToMany(Item::class, 'item_drinks', 'drink_id', 'item_id');
	}
  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(DrinkTranslation::class);
	}

  public function options()
  {
    return $this->morphMany(CartItemOption::class, 'optionable');
  }

}
