<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\CurrencyTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    Currency::create(['id' => 1, 'isocode' => 'USD', 'default' => 1]);

    CurrencyTranslation::create([
      'currency_id' => 1,
      'locale' => "en",
      'name' => 'dollar',

    ]);
    CurrencyTranslation::create([
      'currency_id' => 1,
      'locale' => "ar",
      'name' => 'دولار',

    ]);

    Currency::create(['id' => 2, 'isocode' => 'LB', 'default' => 0]);

    CurrencyTranslation::create([
      'currency_id' => 2,
      'locale' => "en",
      'name' => 'Lebanese Pound',

    ]);
    CurrencyTranslation::create([
      'currency_id' => 2,
      'locale' => "ar",
      'name' => 'الليرة اللبنانية',

    ]);

    Currency::create(['id' => 3, 'isocode' => 'IQD', 'default' => 0]);

    CurrencyTranslation::create([
      'currency_id' => 3,
      'locale' => "en",
      'name' => 'Iraqi Dinar',

    ]);
    CurrencyTranslation::create([
      'currency_id' => 3,
      'locale' => "ar",
      'name' => 'الدينار العراقي',

    ]);

  }
}
