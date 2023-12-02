<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class serviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Service::create([
        'id' => 1,
        'item_id' => 2,
        'price' => 2,
        'store_id'=>2
      ]);

      ServiceTranslation::create([
        'service_id' => 1,
        'locale' => "en",
        'name' => 'Ironing',


      ]);
      ServiceTranslation::create([
        'service_id' => 1,
        'locale' => "ar",
        'name' => 'كى الملابس',
      ]);
      Service::create([
        'id' => 2,
        'item_id' => 2,
        'price' => 5,
        'store_id'=>2


      ]);

      ServiceTranslation::create([
        'service_id' => 2,
        'locale' => "en",
        'name' => 'Cleaning & Ironing',


      ]);
      ServiceTranslation::create([
        'service_id' => 2,
        'locale' => "ar",
        'name' => 'التنظيف والكي',
      ]);

    }
}
