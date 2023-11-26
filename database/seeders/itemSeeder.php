<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Item,ItemTranslation};

class itemSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Item::create([
      'id' => 1,
      'image' => '360_F_18669964_Txz4BS0OErzj9v9DHM3N51d8yFVa85dR.jpg',
      'category_id' => 3,
      'store_id' => 1,
      'price' => 10,
      "default_currency_id" => 1,
      'has_gift' => 0,
      'has_offer' => 1,
      'is_restaurant' => 1,
      'points' => 200,
      "subsection_id"=>24,
      "section_id"=>17
    ]);



    ItemTranslation::create([
      'item_id' => 1,
      'locale' => "en",
      'name' => 'Pizza mushroom',
      'description' => 'Delicious Pizza with Mushroom, tomatoes, olives and cheese.'
    ]);

    ItemTranslation::create([
      'item_id' => 1,
      'locale' => "ar",
      'name' => ' بيتزا مشروم' ,
      'description' => 'بيتزا لذيذه مه مشروم وطماطم وجبن وزيتون'
    ]);



    Item::create([
      'id' => 2,
      'image' => 'istockphoto-1031043754-612x612.jpg',
      'category_id' => 4,
      'store_id' => 2,
      'price' => 10,
      "default_currency_id" => 1,
      'has_gift' => 1,
      'has_offer' => 0,
      'is_restaurant' => 0,
      'points' => 300,
      "subsection_id"=>6,
      "section_id"=>10
    ]);

    ItemTranslation::create([
      'item_id' => 2,
      'locale' => "en",
      'name' => 'Poly Service',
      'description' => 'A complete approach to furniture cleaning protection and  pest management since 1980'
    ]);

    ItemTranslation::create([
      'item_id' => 2,
      'locale' => "ar",
      'name' => 'Poly Service',
      'description' => 'نهج متكامل لحماية تنظيف الأثاث ومكافحة الآفات منذ عام 1980'
    ]);

  }





}
