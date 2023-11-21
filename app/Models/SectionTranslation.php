<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SectionTranslation extends Model {

  use HasFactory;
  protected $guarded = [];
	protected $table = 'section_translations';
	public $timestamps = false;

}
