<?php

namespace App\Models;

use App\Models\Scopes\ItemScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Helpers\Helpers;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Item extends Model implements TranslatableContract
{

  protected $table = 'items';
  public $timestamps = true;

  use HasFactory, Translatable;
  public $translatedAttributes = ['name', 'description'];
  protected $guarded = [];
  protected $dates = ['from_date', 'to_date'];

  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope(new ItemScope());
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
  //     $helpers = new Helpers(); // Instantiate the Helpers class
  //     $image = $helpers->upload_single_file($value, 'app/public/images/items/');
  //     $this->attributes['image'] = $image;
  //   }
  // }

  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(ItemTranslation::class);
  }



  public function drinks()
  {
    return $this->belongsToMany(Drink::class, 'item_drinks', 'item_id', 'drink_id')->withPivot("drink_id");
  }

  public function addons()
  {
    return $this->belongsToMany(Addon::class, 'item_addons', 'item_id', 'addon_id')->withPivot("addon_id");
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
    return $this->hasMany(Ingredient::class)->where("add", 1);
  }

  public function Removeingredients()
  {
    return $this->hasMany(Ingredient::class)->where("add", 0);
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
    return $this->morphMany(Favourite::class, 'favoriteable');
  }



  public function reviews()
  {
    return $this->morphMany(Review::class, 'reviewable');
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
    return $this->belongsto(Subsection::class);
  }


  /***
   *
   *  public static function applyCouponDiscount($coupon, &$order_data, $sub_total)
    {
      $percentage = $coupon->discount_percentage / 100;
      $coupon_discount = $sub_total * $percentage;

      $order_data["total"] = $sub_total - $coupon_discount;
      $order_data["sub_total"] = $order_data["total"];
      $order_data['coupon_id'] = $coupon->id;

      $coupon->update([
        'user_used_code_count' => $coupon->user_used_code_count + 1,
      ]);
    }
   */

  public function getPriceAttribute()
  {
    $added_value = $this->attributes["added_value"];
    $item_price = $this->attributes["price"];

    // Check if either attribute is NULL
    if ($added_value === null || $item_price === null) {
      return null; // or any default value or handle accordingly
    }

    $percentage = $added_value / 100;
    $item_added_value = $item_price * $percentage;

    return $item_price + $item_added_value;
  }

  public function getPriceBeforeTaxAttribute()
  {

    $item_price = $this->attributes["price"];

    return $item_price;
  }


  public function getcurrencyAttribute()
  {
    $default_currency = Currency::where("default", 1)->first();
    $currency_name = CurrencyTranslation::where("currency_id", $default_currency->id)->first();
    return $currency_name->name;

  }


  public function getcurrencyIsoCodeAttribute()
  {
    $default_currency = Currency::where("default", 1)->first();

    return $default_currency->isocode;

  }

  public function coupon()
  {
    return $this->belongsToMany(Coupon::class, 'coupon_items', 'item_id', 'coupon_id');
  }


}
