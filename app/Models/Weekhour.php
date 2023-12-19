<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weekhour extends Model
{
  use HasFactory;
  protected $guarded = [];
  protected $with = ['day'];
  protected $casts = [
    'from' => 'datetime',
    'to'  => 'datetime'
];

  public function store()
  {
    return $this->belongsTo(Store::class);
  }

  public function day()
  {
    return $this->belongsTo(Day::class);
  }
}
