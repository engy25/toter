<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDistrict extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function from()
    {
      return $this->belongsTo(District::class,"from_id");
    }

    public function to()
    {
      return $this->belongsTo(District::class,"to_id");
    }

    public function orderButlers()
    {
      return $this->hasMany(OrderButler::class,"district_id");
    }
}
