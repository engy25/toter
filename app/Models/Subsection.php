<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Helpers\Helpers;

class Subsection extends Model implements TranslatableContract
{

  use SoftDeletes, HasFactory, Translatable;
  protected $table = 'subsections';
  public $timestamps = true;

  protected $guarded = [];

  public $translatedAttributes = ['name', 'description'];

  protected $dates = ['deleted_at'];

  public function section()
  {
    return $this->belongsTo(Section::class);
  }


  protected static function boot()
  {
      parent::boot();

      static::deleting(function ($subsection) {
          /***check if the subsection related to any other table */
          if ($subsection->offers()->count() > 0 || $subsection->stores()->count() > 0) {
              // There are related records in either offers or stores
              return false;
          } else {
              // No related records, proceed with deletion
               $subsection->translations()->delete();
              return true;
          }
      });
  }


  // public $helper;
  // public function __construct()
  // {
  //   $this->helper = new Helpers();
  // }

  public function getImageAttribute()
  {
    return asset('storage/images/subSections/' . $this->attributes['image']);
  }
  // public function setImageAttribute($value)
  // {
  //   // Check if $value is an instance of UploadedFile
  //   if ($value instanceof \Illuminate\Http\UploadedFile && $value->isValid()) {
  //     if (isset($this->attributes['image']) && $this->attributes['image']) {
  //       if (file_exists(storage_path('app/public/images/subSections/' . $this->attributes['image']))) {
  //         \File::delete(storage_path('app/public/images/subSections/' . $this->attributes['image']));
  //       }
  //     }

  //     $image = $this->helper->upload_single_file($value, 'app/public/images/subSections/');
  //     $this->attributes['image'] = $image;
  //   }
  // }






  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(SubsectionTranslation::class, "sub_section_id");
  }

  public function offers()
  {
    return $this->hasMany(Offer::class,"subsection_id");
  }

  public function getDescriptionAttribute($value)
  {
    $helper=new Helpers();
    return $this->helper->stripText($value);
  }

  public function getNameAttribute()
  {
    if ($this->attributes['name'] == "Main") {
      return $this->section->name;
    } else {
      return trans($this->attributes['name']);
    }
  }
  public function stores()
  {
    return $this->hasMany(Store::class, "sub_section_id");
  }

  public function scopeValid($query)
  {

    $query->whereHas("stores")->whereNotIn('section_id', [15, 6, 16, 4, 7])->whereHas('translations', function ($subquery) {
      $subquery->whereNotIn("name", ["Main"]);
    });
  }

  public function scopeValidWeb($query)
  {

    $query->whereHas('translations', function ($subquery) {
      $subquery->whereNotIn("name", ["Main"]);
    });

  }

}



