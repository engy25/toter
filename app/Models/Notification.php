<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Notification extends Model {

  use HasTranslations;
  use SoftDeletes,HasFactory;

	protected $table = 'notifications';

	public $timestamps = true;


  public $translatable = ['title','data'];



  protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function notifeable()
	{
		return $this->morphTo();
	}

}
