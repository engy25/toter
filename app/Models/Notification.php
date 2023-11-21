<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class Notification extends Model {

	protected $table = 'notifications';
	public $timestamps = true;

	use SoftDeletes,HasFactory;
  protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function notifeable()
	{
		return $this->morphTo();
	}

}
