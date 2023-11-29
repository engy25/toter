<?php

namespace Database\Seeders;

use App\Models\SizeTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Size;
class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Size::create([
        'id' => 1,
        'price' =>2,
        'item_id'=>1,

      ]);

      SizeTranslation::create([
        'size_id' => 1,
        'locale' => "en",
        'name' => 'small ',


      ]);
      SizeTranslation::create([
        'size_id' => 1,
        'locale' => "ar",
        'name' => 'صغير ',

      ]);

      Size::create([
        'id' => 2,
        'price' =>4,
        'item_id'=>1,



      ]);

      SizeTranslation::create([
        'size_id' => 2,
        'locale' => "en",
        'name' => 'large ',


      ]);
      SizeTranslation::create([
        'size_id' => 2,
        'locale' => "ar",
        'name' => 'كبيره ',

      ]);

    }
}
