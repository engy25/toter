<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class SideTranslation extends Model
{

  use HasFactory;
  protected $guarded = [];
  protected $table = 'side_translations';
  public $timestamps = false;

}
