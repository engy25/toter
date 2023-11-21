<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCategoryTranslation extends Model
{
  use HasFactory;
  protected $table = 'store_category_translations';
  public $timestamps = false;

  protected $guarded=[];

}
