<?php

namespace App\Models;

use App\Models\Scopes\ItemScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

  protected $table = 'order_items';
  public $timestamps = true;

  use HasFactory;
  protected $guarded = [];


  public function item()
  {
      return $this->belongsTo(Item::class)->withoutGlobalScope(ItemScope::class);
  }

  public function size()
  {
      return $this->belongsTo(Size::class);
  }

  public function preference()
  {
      return $this->belongsTo(Preference::class);
  }

  public function option()
  {
      return $this->belongsTo(Option::class);
  }

  public function gift()
  {
      return $this->belongsTo(ItemGift::class,"gift_id");
  }


  public function ordereable()
  {
    return $this->morphTo();
  }

}
