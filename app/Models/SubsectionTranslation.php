<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class SubsectionTranslation extends Model {
  use HasFactory;
  protected $guarded=[];
	protected $table = 'subsection_translations';
	public $timestamps = false;


}
