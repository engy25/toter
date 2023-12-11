<?php

namespace Database\Seeders;

use App\Models\{StoreDistrict,DistrictTranslation,District};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistricSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    District::create(['id' => 2,"city_id"=>1]);
    DistrictTranslation::create([
      'district_id' => 2,
      'locale' => "en",
      'name' => 'District2',

    ]);
    DistrictTranslation::create([
      'district_id' => 2,
      'locale' => "ar",
      'name' =>  'المنطقه الثانيه',

    ]);

    District::create(['id' => 3,"city_id"=>1]);
    DistrictTranslation::create([
      'district_id' => 3,
      'locale' => "en",
      'name' => 'District3',

    ]);
    DistrictTranslation::create([
      'district_id' => 3,
      'locale' => "ar",
      'name' =>  'المنطقه الثالثه',

    ]);

    District::create(['id' => 4,"city_id"=>1]);
    DistrictTranslation::create([
      'district_id' => 4,
      'locale' => "en",
      'name' => 'District4',

    ]);
    DistrictTranslation::create([
      'district_id' => 4,
      'locale' => "ar",
      'name' =>  'المنطقه الرابعه',

    ]);

   
  }
}
