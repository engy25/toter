<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Address extends Model {

	protected $table = 'addresses';
	public $timestamps = true;

	use SoftDeletes,HasFactory;

	protected $dates = ['deleted_at'];
  protected $guarded=[];
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

}
