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

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function getImageAttribute()
  {
    return asset('storage/images/subSections/' . $this->attributes['image']);
  }
  public function setImageAttribute($value)
  {
    if ($value && $value->isValid()) {
      if (isset($this->attributes['image']) && $this->attributes['image']) {


        if (file_exists(storage_path('app/public/images/subSections/' . $this->attributes['image']))) {
          \File::delete(storage_path('app/public/images/subSections/' . $this->attributes['image']));
        }
      }
      $image = $this->helper->upload_single_file($value, 'app/public/images/subSections/');
      $this->attributes['image'] = $image;
    }
  }

  public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(SubSectionTranslation::class, "sub_section_id");
  }

  public function offers()
  {
    return $this->hasMany(Offer::class);
  }

  public function getDescriptionAttribute($value)
  {
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
    return $this->hasMany(Store::class,"sub_section_id");
  }

  public function scopeValid($query){

    $query->whereHas("stores")->whereNotIn('section_id', [15, 6, 16, 4, 7])->whereHas('translations',function($subquery){
      $subquery->whereNotIn("name",["Main"]);
    });
  }



}



