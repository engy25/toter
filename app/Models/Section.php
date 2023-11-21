<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Helpers\Helpers;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Section extends Model implements TranslatableContract{

	protected $table = 'sections';
	public $timestamps = true;
  protected $guarded = [];
	use SoftDeletes,HasFactory,Translatable;
  public $translatedAttributes = ['name','description'];

	protected $dates = ['deleted_at'];


	public function subsections()
	{
		return $this->hasMany(Subsection::class);
	}

  public $helper;
  public function __construct()
  {
      $this->helper= new Helpers();
  }

  public function getImageAttribute()
  {
    return asset('storage/images/sections/' . $this->attributes['image']);
  }
  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/sections/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/sections/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/sections/');
      $this->attributes['image'] = $image;
    }
  }


  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(SectionTranslation::class);
  }

}
