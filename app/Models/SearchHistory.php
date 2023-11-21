<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model {

	protected $table = 'search_histories';
	public $timestamps = true;

	use SoftDeletes,HasFactory;

	protected $dates = ['deleted_at'];
  protected $guarded = [];
	public function user()
	{
		return $this->belongsTo(User::class);
	}

}
