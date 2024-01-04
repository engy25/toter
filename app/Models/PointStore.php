<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PointStore extends Model
{

  protected $guarded = [];
  protected $table = 'point_stores';
  public $timestamps = true;

  use  HasFactory;



}
