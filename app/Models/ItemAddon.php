<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ItemAddon extends Model {

	protected $table = 'item_addons';
	public $timestamps = true;

	use  HasFactory;
  protected $guarded = [];


}
