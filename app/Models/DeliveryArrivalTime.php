<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DeliveryArrivalTime extends Model
{
  use HasFactory;

  public static function booted()
  {
    static::creating(function (DeliveryArrivalTime $deliveryArrivalTime) {
      $cancelTime = Carbon::parse($deliveryArrivalTime->cancel_time);
      $attendanceTime = Carbon::parse($deliveryArrivalTime->attendance_time);
      $workingHours = $attendanceTime->diffInHours($cancelTime);

      $deliveryArrivalTime->working_hours = $workingHours;
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

  public function getAttendanceTimeAttribute()
  {

    return Carbon::parse($this->attributes['attendance_time'])->format('H:i');
  }


  public function getCancelTimeAttribute()
  {

    return Carbon::parse($this->attributes['cancel_time'])->format('H:i');
  }
}
