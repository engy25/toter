<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model {

	protected $table = 'favourites';
	public $timestamps = true;

	use HasFactory;
  protected $guarded = [];


	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function favoriteable()
	{
		return $this->morphTo();
	}

}
