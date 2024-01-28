<?php

namespace App\Models;

use App\Models\Scopes\ItemScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;


class Addon extends Model
{

  protected $table = 'addons';
  public $timestamps = true;

  use  HasFactory;
  protected $guarded = [];



  public function getImageAttribute()
  {
    return asset('storage/images/addons/' . $this->attributes['image']);
  }
  // public function setImageAttribute($value)
  // {
  //   if ($value && $value->isValid()) {
  //     if (isset($this->attributes['image']) && $this->attributes['image']) {


  //       if (file_exists(storage_path('app/public/images/addons/' . $this->attributes['image']))) {
  //         \File::delete(storage_path('app/public/images/addons/' . $this->attributes['image']));
  //       }
  //     }
  //     $image = $this->helper->upload_single_file($value, 'app/public/images/addons/');
  //     $this->attributes['image'] = $image;
  //   }
  // }

  public function options()
  {
    return $this->morphMany(CartItemOption::class, 'optionable');
  }


  public function items()
  {
    return $this->belongsToMany(Item::class, 'item_addons', 'addon_id', "item_id")->withoutGlobalScope(ItemScope::class);
  }
  public function getcurrencyAttribute()
  {
    $default_currency = Currency::where("default", 1)->first();
    $currency_name = CurrencyTranslation::where("currency_id", $default_currency->id)->first();
    return $currency_name->name;

  }

}
