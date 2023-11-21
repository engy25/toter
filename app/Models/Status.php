<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Status extends Model implements TranslatableContract {
  use SoftDeletes, HasFactory, Translatable;
	protected $table = 'statuses';
	public $timestamps = true;

  protected $guarded=[];
  public $translatedAttributes = ['name','description'];

	protected $dates = ['deleted_at'];

	public function orders()
	{
		return $this->belongsToMany(Order::class, 'order_statuses', 'status_id', 'order_id')->withTimestamps();
	}


  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(StatusTranslation::class);
  }
}
