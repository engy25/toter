<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class OfferTranslation extends Model {

  use HasFactory;
	protected $table = 'offer_tanslations';
	public $timestamps = false;
  protected $guarded = [];
}
