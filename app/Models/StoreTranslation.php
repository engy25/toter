<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class StoreTranslation extends Model {
	use HasFactory;
	protected $table = 'store_translations';
	public $timestamps = false;

  protected $guarded = [];

}
