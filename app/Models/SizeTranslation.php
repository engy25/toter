<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeTranslation extends Model
{
  use HasFactory;

  protected $guarded = [];
  protected $table = 'size_translations';
  public $timestamps = false;

}
