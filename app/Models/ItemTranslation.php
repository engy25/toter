<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model;

class ItemTranslation extends Model
{
  use HasFactory;
  protected $table = 'item_translations';
  public $timestamps = false;
  protected $guarded = [];
}
