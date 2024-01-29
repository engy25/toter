<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

  protected $table = 'addresses';
  public $timestamps = true;

  use HasFactory;

  public static function booted()
  {
    parent::boot();
    static::deleting(function ($address) {
      if ($address->orders()->count() > 0 || $address->fromOrderButlers()->count() > 0 || $address->toOrderButlers()->count() > 0 || $address->orderCallcenters()->count() > 0)

      return 5;
     
       // return response()->json(['status' => false, 'msg' => "Cannot delete Address, It is related to other tables."], 403);

    });
    return true;
  }

  protected $guarded = [];
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function orders()
  {
    return $this->hasMany(Order::class, 'address_id');
  }

  public function fromOrderButlers()
  {
    return $this->hasMany(OrderButler::class, 'from_address');
  }
  public function toOrderButlers()
  {
    return $this->hasMany(OrderButler::class, 'to_address');
  }

  public function orderCallcenters()
  {
    return $this->hasMany(OrderCallcenter::class, 'address_id');
  }

}
