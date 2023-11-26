<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Option,OptionTranslation};
class optionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Option::create([
        'id' => 1,
        'price' =>0,
        'item_id'=>1,
        'image'=>'download2.jpg'


      ]);

      OptionTranslation::create([
        'option_id' => 1,
        'locale' => "en",
        'name' => 'Mushroom ',


      ]);
      OptionTranslation::create([
        'option_id' => 1,
        'locale' => "ar",
        'name' => 'مشروم ',

      ]);

      Option::create([
        'id'=> 2,
        'price' => 2,
        'item_id'=>1,
        'image'=>'download.jpg'


      ]);

      OptionTranslation::create([
        'option_id' => 2,
        'locale' => "en",
        'name' => 'Vegetarian Mushroom ',


      ]);
      OptionTranslation::create([
        'option_id' => 2,
        'locale' => "ar",
        'name' => 'مشروم نباتي',

      ]);

      Option::create([
        'id' => 3,
        'price' => 2,
        'item_id'=>1,
        'image'=>'download1.jpg'


      ]);

      OptionTranslation::create([
        'option_id' => 3,
        'locale' => "en",
        'name' => 'Truffle Mushroom ',


      ]);
      OptionTranslation::create([
        'option_id' => 3,
        'locale' => "ar",
        'name' => 'Truffle Mushroom ',

      ]);


    }
}
