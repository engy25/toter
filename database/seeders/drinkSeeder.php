<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{DrinkTranslation, Drink};

class drinkSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Drink::create([
      'id' => 1,
      'image' => '518b7GAV9FS.jpg',
      'price' => 4,
      'store_id'=>1

    ]);

    DrinkTranslation::create([
      'drink_id' => 1,
      'locale' => "en",
      'name' => 'spiro spathis',


    ]);
    DrinkTranslation::create([
      'drink_id' => 1,
      'locale' => "ar",
      'name' => 'سبيرو سباتس',

    ]);


    Drink::create([
      'id' => 2,
      'image' => 'download.jpg',
      'price' => 3,
      'store_id'=>1

    ]);

    DrinkTranslation::create([
      'drink_id' => 2,
      'locale' => "en",
      'name' => 'spiro spathis red apple',


    ]);
    DrinkTranslation::create([
      'drink_id' => 2,
      'locale' => "ar",
      'name' => 'سبيرو سباتس تفاح احمر',

    ]);


    Drink::create([
      'id' => 3,
      'image' => 'images.jpg',
      'price' => 4,
        'store_id'=>1

    ]);

    DrinkTranslation::create([
      'drink_id' => 3,
      'locale' => "en",
      'name' => 'spiro spathis Mulberry',


    ]);
    DrinkTranslation::create([
      'drink_id' => 3,
      'locale' => "ar",
      'name' => 'توت سبيرو سباتس',

    ]);



  }
}
