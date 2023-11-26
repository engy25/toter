<?php

namespace Database\Seeders;

use App\Models\Side;
use App\Models\SideTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Side::create([
        'id' => 1,
        'price' =>2,
        'item_id'=>1,
        'image'=>'download6.jpg'



      ]);

      SideTranslation::create([
        'side_id' => 1,
        'locale' => "en",
        'name' => 'Sweet Potato Fries',


      ]);
      SideTranslation::create([
        'side_id' => 1,
        'locale' => "ar",
        'name' => 'Sweet Potato Fries',

      ]);


      Side::create([
        'id' => 2,
        'price' =>2,
        'item_id'=>1,
        'image'=>'download.jpg'



      ]);

      SideTranslation::create([
        'side_id' => 2,
        'locale' => "en",
        'name' => 'Garlic Knots ',


      ]);
      SideTranslation::create([
        'side_id' => 2,
        'locale' => "ar",
        'name' => 'Garlic Knots ',

      ]);




      Side::create([
        'id' => 3,
        'price' =>5,
        'item_id'=>1,
        'image'=>'download99.jpg'



      ]);

      SideTranslation::create([
        'side_id' => 3,
        'locale' => "en",
        'name' => 'Onion Rings ',


      ]);
      SideTranslation::create([
        'side_id' => 3,
        'locale' => "ar",
        'name' => 'Garlic Knots ',

      ]);


    }
}
