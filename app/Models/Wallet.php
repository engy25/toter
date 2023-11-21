<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Wallet extends Model {

	protected $table = 'wallets';
	public $timestamps = true;
  use HasFactory,SoftDeletes;


	protected $dates = ['deleted_at'];

}
