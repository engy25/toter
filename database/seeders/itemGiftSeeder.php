<?php

namespace Database\Seeders;

use App\Models\ItemGift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class itemGiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      ItemGift::create([

        'item_id' => 2,
        'name'=>'Harpic',
        'image'=>'61oV8QpIwyL.__AC_SX300_SY300_QL70_ML2_.jpg'


      ]);

      ItemGift::create([

        'item_id' => 2,
        'name'=>'Harpic',
        'image'=>'61oV8QpIwyL.__AC_SX300_SY300_QL70_ML2_.jpg'


      ]);

      ItemGift::create([

        'item_id' => 2,
        'name'=>'Maxell Magic Bathroom Cleaner',
        'image'=>'61qwi4B5YXL._AC_SX522_.jpg'


      ]);

      ItemGift::create([

        'item_id' => 2,
        'name'=>'Harpic original toilet cleaner, 100% limescale remover,',
        'image'=>'51sOrry-BML.__AC_SX300_SY300_QL70_ML2_.jpg'


      ]);


    }
}
