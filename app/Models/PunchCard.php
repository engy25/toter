<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PunchCard extends Model {

	protected $table = 'punchcards';
	public $timestamps = true;

	use SoftDeletes,HasFactory;
  protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function points()
	{
		return $this->morphMany(PointUser, 'pointeable');
	}

}
