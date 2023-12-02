<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\IngredientTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ingredientSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Ingredient::create([
      'id' => 1,
      'image' => 'images.jpg',
      'price' => 4,
      'item_id'=>1,
      'store_id'=>1
    ]);

    IngredientTranslation::create([
      'ingredient_id' => 1,
      'locale' => "en",
      'name' => 'Mushroom',


    ]);
    IngredientTranslation::create([
      'ingredient_id' => 1,
      'locale' => "ar",
      'name' => 'مشروم',

    ]);

    Ingredient::create([
      'id' => 2,
      'image' => 'download.jpg',
      'price' => 0,
      'item_id'=>1,
      'add'=>0,
      'store_id'=>1
    ]);

    IngredientTranslation::create([
      'ingredient_id' => 2,
      'locale' => "en",
      'name' => 'onion',


    ]);
    IngredientTranslation::create([
      'ingredient_id' => 2,
      'locale' => "ar",
      'name' => 'بصل',

    ]);

    Ingredient::create([
      'id' => 3,
      'price' => 0,
      'item_id'=>1,
      'add'=>0,
      'store_id'=>1

    ]);

    IngredientTranslation::create([
      'ingredient_id' => 3,
      'locale' => "en",
      'name' => 'salsa freska',


    ]);
    IngredientTranslation::create([
      'ingredient_id' => 3,
      'locale' => "ar",
      'name' => 'صلصه',

    ]);


    Ingredient::create([
      'id' => 4,
      'price' => 2,
      'item_id'=>1,
      'store_id'=>1

    ]);

    IngredientTranslation::create([
      'ingredient_id' => 4,
      'locale' => "en",
      'name' => 'Extra Cheese',


    ]);
    IngredientTranslation::create([
      'ingredient_id' => 4,
      'locale' => "ar",
      'name' => 'جبنه زياده',

    ]);
  }
}
