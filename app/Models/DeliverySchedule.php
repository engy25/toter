<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DeliverySchedule extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function booted()
  {
    static::updating(function (DeliverySchedule $deliverySchedule) {
      if ($deliverySchedule->to_time != null) {
        
        $from_time = Carbon::parse($deliverySchedule->from_time);
        $to_time = Carbon::parse($deliverySchedule->to_time);
        $working_houres = $from_time->diffInHours($to_time);
        $deliverySchedule->working_hours = $working_houres;
      }

    });
  }

  public function delivery()
  {
    return $this->belongsTo(User::class);
  }
  public function day()
  {
    return $this->belongsTo(Day::class);
  }
  public function getFromTimeAttribute()
  {

    return Carbon::parse($this->attributes['from_time'])->format('H:i');
  }


  public function getToTimeAttribute()
  {

    return Carbon::parse($this->attributes['to_time'])->format('H:i');
  }

}
