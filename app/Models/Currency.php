<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Currency extends Model implements TranslatableContract {

	protected $table = 'currencies';
	public $timestamps = true;

  use SoftDeletes, HasFactory, Translatable;
  protected $guarded = [];
  public $translatedAttributes = ['name'];

	protected $dates = ['deleted_at'];

	public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(CurrencyTranslation::class);
	}

}
