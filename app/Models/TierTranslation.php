<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TierTranslation extends Model
{
  use HasFactory;
  protected $table = 'tier_translations';
  protected $guarded = [];
  public $timestamps = false;

}
