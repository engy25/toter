<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PreferenceTranslation extends Model {

	protected $table = 'preference_translations';
	public $timestamps = true;

	use HasFactory;
  protected $guarded = [];


}
