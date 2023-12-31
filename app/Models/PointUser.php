<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PointUser extends Model {

	protected $table = 'point_users';
	public $timestamps = true;
  protected $guarded = [];
	use HasFactory;



	public function pointeable()
	{
		return $this->morphTo();
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

}
