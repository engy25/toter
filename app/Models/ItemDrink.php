<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
class ItemDrink extends Model {
use HasFactory;
	protected $table = 'item_drinks';
	public $timestamps = true;
  protected $guarded = [];
}
