<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
class ServiceTranslation extends Model {

  use HasFactory;

	protected $table = 'service_translations';
	public $timestamps = false;
  protected $guarded=[];

}
