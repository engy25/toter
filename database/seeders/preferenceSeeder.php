<?php

namespace Database\Seeders;

use App\Models\{Preference,PreferenceTranslation};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class preferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Preference::create([
        'id' => 1,
        'item_id' => '1',
        'price' => 0,

        'store_id'=>1
      ]);

      PreferenceTranslation::create([
        'preference_id' => 1,
        'locale' => "en",
        'name' => 'Send Blue cheese Dips',


      ]);
      PreferenceTranslation::create([
        'preference_id' => 1,
        'locale' => "ar",
        'name' => 'إرسال الانخفاضات الجبن الأزرق'

      ]);

      Preference::create([
        'id' => 2,
        'item_id' => '1',
        'price' => 0,
        'store_id'=>1

      ]);

      PreferenceTranslation::create([
        'preference_id' => 2,
        'locale' => "en",
        'name' => "Don't Send Blue cheese Dips",


      ]);
      PreferenceTranslation::create([
        'preference_id' => 2,
        'locale' => "ar",
        'name' => 'لا ترسل انخفاضات الجبن الأزرق'

      ]);

    }
}
