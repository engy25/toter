<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTranslation extends Model
{
  use HasFactory;

  protected $guarded = [];
  protected $table = 'status_translations';
  public $timestamps = false;


}
