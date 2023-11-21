<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

	protected $table = 'settings';
	public $timestamps = true;

	use SoftDeletes,HasFactory;

	protected $dates = ['deleted_at'];

  protected $guarded=[];

}
