<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function sender()
  {
    return $this->belongsTo(User::class, "sender_id");
  }

  public function receiver()
  {
    return $this->belongsTo(User::class, "receiver_id");
  }

  public function currrency()
  {
    return $this->belongsTo(Currency::class, "currency_id");
  }
  public function getcurrencyAttribute()
  {
    $default_currency=Currency::where("default",1)->first();
    $currency_name=CurrencyTranslation::where("currency_id",$default_currency->id)->first();
    return $currency_name->name;

  }
}
