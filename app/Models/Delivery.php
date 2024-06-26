<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
  use HasFactory;
  protected $guarded = [];
  public function ordereable()
  {
    return $this->morphTo();
  }

  public function status()
  {
    return $this->belongsTo(Status::class);
  }
}
