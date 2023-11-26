<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Addon,ItemAddon};
class addonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Addon::create([
        'id' => 1,
        'image' => 'images.jpg',
        'price' => 4,
        'name'=>"Mushroom"

      ]);



      Addon::create([
        'id' => 2,
        'image' => 'downlgoad.jpg',
        'price' => 5,
        'name'=>"Tomatoes"

      ]);

      Addon::create([
        'id' => 3,
        'image' => 'imag.jpg',
        'price' => 6,
        'name'=>"Olives"

      ]);

      Addon::create([
        'id' => 4,
        'image' => 'downl.jpg',
        'price' => 7,
        'name'=>"Cheese"

      ]);

      ItemAddon::create([

        'item_id' => 1,
        'addon_id' => 1,


      ]);

      ItemAddon::create([

        'item_id' => 1,
        'addon_id' => 2,


      ]);

      ItemAddon::create([

        'item_id' => 1,
        'addon_id' => 3,


      ]);

      ItemAddon::create([

        'item_id' => 1,
        'addon_id' => 4,


      ]);


    }
}
