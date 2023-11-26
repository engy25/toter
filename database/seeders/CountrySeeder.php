<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Country, CountryTranslation};

class CountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {


    Country::create(['id' => 1, 'flag' => 'cristina-glebova-fYqQBr0EzkA-unsplash.jpg', 'currency_id' => 1, 'country_code' => '+20']);

    CountryTranslation::create([
      'country_id' => 1,
      'locale' => "en",
      'name' => 'United State',

    ]);
    CountryTranslation::create([
      'country_id' => 1,
      'locale' => "ar",
      'name' => 'الولايات المتحدة',

    ]);



    Country::create(['id' => 2, 'flag' => 'Lebanon.svg.png', 'currency_id' => 2, 'country_code' => 'LB']);

    CountryTranslation::create([
      'country_id' => 2,
      'locale' => "en",
      'name' => 'Lebnon',

    ]);
    CountryTranslation::create([
      'country_id' => 2,
      'locale' => "ar",
      'name' => 'لبنان',

    ]);


    Country::create(['id' => 3, 'flag' => 'Flag_of_Iraq.svg.png', 'currency_id' => 3, 'country_code' => 'IQ']);

    CountryTranslation::create([
      'country_id' => 3,
      'locale' => "en",
      'name' => 'Iraq',

    ]);
    CountryTranslation::create([
      'country_id' => 3,
      'locale' => "ar",
      'name' => 'العراق',

    ]);
  }
}
