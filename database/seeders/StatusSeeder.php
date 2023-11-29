<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\StatusTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Status::create([
        'id' => 1,

      ]);

      StatusTranslation::create([
        'status_id' => 1,
        'locale' => "en",
        'name' => 'pending ',


      ]);
      StatusTranslation::create([
        'status_id' => 1,
        'locale' => "ar",
        'name' => 'قيد الانتظار ',

      ]);

      Status::create([
        'id' => 2,

      ]);

      StatusTranslation::create([
        'status_id' => 2,
        'locale' => "en",
        'name' => 'confirm ',


      ]);
      StatusTranslation::create([
        'status_id' => 2,
        'locale' => "ar",
        'name' => 'تم التاكيد',

      ]);



      Status::create([
        'id' => 3,

      ]);

      StatusTranslation::create([
        'status_id' => 3,
        'locale' => "en",
        'name' => 'on the road ',


      ]);
      StatusTranslation::create([
        'status_id' => 3,
        'locale' => "ar",
        'name' => 'في الطريق',

      ]);



      Status::create([
        'id' => 4,

      ]);

      StatusTranslation::create([
        'status_id' => 4,
        'locale' => "en",
        'name' => 'finish',


      ]);
      StatusTranslation::create([
        'status_id' => 4,
        'locale' => "ar",
        'name' => 'تم الانتهاء',

      ]);



      Status::create([
        'id' => 5,

      ]);

      StatusTranslation::create([
        'status_id' => 5,
        'locale' => "en",
        'name' => 'cancell',


      ]);
      StatusTranslation::create([
        'status_id' => 5,
        'locale' => "ar",
        'name' => 'تم الالغاء',

      ]);

    }
}
