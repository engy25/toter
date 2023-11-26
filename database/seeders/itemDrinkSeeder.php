<?php

namespace Database\Seeders;

use App\Models\ItemDrink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class itemDrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      ItemDrink::create([

        'item_id' => 1,
        'drink_id' => 1,


      ]);

      ItemDrink::create([

        'item_id' => 1,
        'drink_id' => 2,


      ]);

      ItemDrink::create([

        'item_id' => 1,
        'drink_id' => 3,


      ]);
    }
}
