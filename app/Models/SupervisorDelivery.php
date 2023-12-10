<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisorDelivery extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function delivery()
  {
    return $this->belongsTo(User::class, "delivery_id");
  }

  public function supervisor()
  {
    return $this->belongsTo(User::class, "supervisor_id");

  }
}
