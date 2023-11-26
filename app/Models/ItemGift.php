<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helpers;
class ItemGift extends Model {

	protected $table = 'item_gifts';
	public $timestamps = true;

	use SoftDeletes,HasFactory;
  public $helper;
  public function __construct()
  {
      $this->helper= new Helpers();
  }
	protected $dates = ['deleted_at'];
  protected $guarded = [];
	public function item()
	{
		return $this->belongsTo(Item::class);
	}


  public function getImageAttribute()
  {
    return asset('storage/images/gifts/' . $this->attributes['image']);
  }
  // public function setImageAttribute($value)
  // {
  //   if ($value && $value->isValid()) {
  //     if (isset($this->attributes['image']) && $this->attributes['image']) {


  //       if (file_exists(storage_path('app/public/images/gifts/' . $this->attributes['image']))) {
  //         \File::delete(storage_path('app/public/images/gifts/' . $this->attributes['image']));
  //       }
  //     }
  //     $image = $this->helper->upload_single_file($value, 'app/public/images/gifts/');
  //     $this->attributes['image'] = $image;
  //   }
  // }
  public function options()
  {
    return $this->morphMany(CartItemOption::class, 'optionable');
  }
}
