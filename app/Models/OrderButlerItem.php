<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helpers;
class OrderButlerItem extends Model
{
  use HasFactory;

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();

  }

  protected $guarded = [];

  public function order()
  {
    return $this->belongsTo(OrderButler::class,"order_id");
  }

  public function getImageAttribute()
  {
    return asset('storage/images/orderButlers/' . $this->attributes['image']);
  }


  public function setImageAttribute($value)
{
  if ($value && $value->isValid()) {
    if (isset($this->attributes['image']) && $this->attributes['image']) {

      if (file_exists(storage_path('app/public/images/orderButlers/' . $this->attributes['image']))) {
        \File::delete(storage_path('app/public/images/orderButlers/' . $this->attributes['image']));
      }
    }

    $image = $this->helper->upload_single_file($value, 'app/public/images/orderButlers/');
    $this->attributes['image'] = $image;
  }
}
}
