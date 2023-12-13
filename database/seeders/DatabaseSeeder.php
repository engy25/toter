<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // $this->call(currencySeeder::class);
    // $this->call(countrySeeder::class);
    // \App\Models\User::factory(30)->create();
  //   $this->call(RolesTableSeeder::class);
    //  $this->call(TierTableSeeder::class);
    //  $this->call(TierTableTranslationSeeder::class);
    // $this->call(sectionSeeder::class);
    // $this->call(subsectionSeeder::class);
    // $this->call(storeSeeder::class);
// $this->call(offerSeeder::class);
//  $this->call(StoreCategorySeeder::class);
//  $this->call(pointStoreSeeder::class);
    // $this->call(itemSeeder::class);
    // $this->call(ingredientSeeder::class);
// $this->call(addonSeeder::class);
    // $this->call(drinkSeeder::class);
//  $this->call(itemDrinkSeeder::class);
// $this->call(itemGiftSeeder::class);

    // $this->call(optionSeeder::class);
// $this->call(SizeSeeder::class);
// $this->call(SideSeeder::class);
// $this->call(preferenceSeeder::class);
//  $this->call(daySeeder::class);
// $this->call(serviceSeeder::class);
//  $this->call(butlerSeeder::class);
// $this->call(StatusSeeder::class);
  //  $this->call(DistricSeeder::class);
   // $this->call(DistrictStoreSeeder::class);
   $this->call(RolesAndPerissionSeeder::class);
  }
}
