<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Helpers\Helpers;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Item extends Model implements TranslatableContract {

	protected $table = 'items';
	public $timestamps = true;

	use SoftDeletes,HasFactory,Translatable;
  public $translatedAttributes = ['name','description'];
  protected $guarded = [];
	protected $dates = ['deleted_at'];


  public $helper;
  public function __construct()
  {
      $this->helper= new Helpers();
  }

  public function getImageAttribute()
  {
    return asset('storage/images/items/' . $this->attributes['image']);
  }
  // public function setImageAttribute($value)
  // {
  //   if ($value && $value->isValid()) {
  //     if (isset($this->attributes['image']) && $this->attributes['image']) {


  //       if (file_exists(storage_path('app/public/images/items/' . $this->attributes['image']))) {
  //         \File::delete(storage_path('app/public/images/items/' . $this->attributes['image']));
  //       }
  //     }
  //     $image = $this->helper->upload_single_file($value, 'app/public/images/items/');
  //     $this->attributes['image'] = $image;
  //   }
  // }

  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(ItemTranslation::class);
  }





	public function drinks()
	{
		return $this->belongsToMany(Drink::class, 'item_drinks', 'item_id', 'drink_id');
	}

  public function addons()
	{
		return $this->belongsToMany(Addon::class, 'item_addons', 'item_id', 'addon_id');
	}

  public function gifts()
  {
    return $this->hasMany(ItemGift::class);
  }

  public function sizes()
  {
    return $this->hasMany(Size::class);
  }

  public function Addingredients()
  {
    return $this->hasMany(Ingredient::class)->where("add",1);
  }

  public function Removeingredients()
  {
    return $this->hasMany(Ingredient::class)->where("add",0);
  }

  public function days()
  {
    return $this->hasMany(Day::class);
  }

  public function services()
  {
    return $this->hasMany(Service::class);
  }

  public function preferences()
  {
    return $this->hasMany(Preference::class);
  }

  public function options()
  {
    return $this->hasMany(Option::class);
  }

	public function store()
	{
		return $this->belongsTo(Store::class);
	}

	public function category()
	{
		return $this->belongsTo(StoreCategory::class);
	}

	public function sides()
	{
		return $this->hasMany(Side::class);
	}

  public function favourites()
  {
     return $this->morphMany(Favourite::class,'favoriteable');
  }



  public function reviews()
  {
     return $this->morphMany(Review::class,'reviewable');
  }

  public function orderItems()
  {
    return $this->hasMany(OrderItem::class);
  }
/**this items popular or not */
public function getStatusAttribute()
{
    $orderItemsCount = $this->orderItems()->count();

    return ($orderItemsCount > 1) ? trans('api.popular') : null;
}

public function section()
{
  return $this->belongsto(Section::class);
}

public function subsection()
{
  return $this->belongsto(SubSection::class);
}


}
