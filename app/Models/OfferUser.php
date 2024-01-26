<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class OfferUser extends Model {

	protected $table = 'offer_users';
	public $timestamps = true;

	use HasFactory;
  protected $guarded = [];
	//protected $dates = ['deleted_at'];

  public function scopeValid($query)
  {
    $query->whereDate('expire_at', '>=', date('Y-m-d'));
  }

}
