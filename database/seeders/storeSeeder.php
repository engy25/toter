<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Store, StoreTranslation,StoreCategory,StoreCategoryTranslation};


class storeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {


    // Store::create([
    //   'id' => 1,
    //   'image' => '360_F_324739203_keeq8udvv0P2h1MLYJ0GLSlTBagoXS48.jpg',
    //   'default_currency_id' => '1',
    //   'price' => 0,
    //   'exchange_rate' => 1308.25,
    //   'to_currency_id' => 3,
    //   'address' => ' Next to, Bridge Omar bin Abdul Aziz, Ramadi, Iraq',
    //   'lat' => 33.430439,
    //   'lng' => 43.271397,
    //   'delivery_time' => 43,
    //   'delivery_fees' => 15,
    //   'is_offered' => 1,
    //   'admin_id' => 2,
    //   'sub_section_id' => 24,
    //   'is_earn_point' => 1,
    // 'section_id'=>17

    // ]);

    // StoreTranslation::create([
    //   'store_id' => 1,
    //   'locale' => "en",
    //   'name' => 'Dream Land Restaurant',
    //   'description' => 'Dream Land Restaurant is The 6th Most Reviewed Restaurant in Ramadi, Dream Land Restaurant - Restaurant in Ramadi, Iraq.'
    // ]);

    // StoreTranslation::create([
    //   'store_id' => 1,
    //   'locale' => "ar",
    //   'name' => 'Dream Land Restaurant',
    //   'description' => 'مطعم دريم لاند هو المطعم السادس الأكثر تقييماً في الرمادي، مطعم دريم لاند - مطعم في الرمادي،العراق.'
    // ]);







    // Store::create([
    //   'id' => 2,
    //   'image' => 'download.jpg',
    //   'default_currency_id' => '1',
    //   'price' => 0,
    //   'exchange_rate' => 1308.25,
    //   'to_currency_id' => 3,

    //   'address' => 'ناحية الرضوية، X97Q+G9X ناحيه الرضويه / قرب مطعم, Najaf 54001, Iraq',
    //   'lat' => 32.93435404,
    //   'lng' => 44.52864848,
    //   'delivery_time' => 36,
    //   'delivery_fees' => 17,
    //   'is_offered' => 0,
    //   'admin_id' => 3,
    //   'sub_section_id' => 6,
    //   'is_earn_point' => 0,
        // 'section_id'=>10
    // ]);

    // StoreTranslation::create([
    //   'store_id' => 2,
    //   'locale' => "en",
    //   'name' => 'Cleaning Store',
    //   'description' => 'Cleaning Store is The 6th Most Reviewed Cleaning in Iraq.'
    // ]);

    // StoreTranslation::create([
    //   'store_id' => 2,
    //   'locale' => "ar",
    //   'name' => 'متجر النظافه',
    //   'description' => 'متجر التنظيف هو سادس أكثر شركات التنظيف تقييمًا في العراق'
    // ]);






    // Store::create([
    //   'id' => 2,
    //   'image' => 'download.jpg',
    //   'default_currency_id' => '1',
    //   'price' => 0,
    //   'exchange_rate' => 1308.25,
    //   'to_currency_id' => 3,
    //   'address' => 'ناحية الرضوية، X97Q+G9X ناحيه الرضويه / قرب مطعم, Najaf 54001, Iraq',
    //   'lat' => 32.93435404,
    //   'lng' => 44.52864848,
    //   'delivery_time' => 36,
    //   'delivery_fees' => 17,
    //   'is_offered' => 0,
    //   'admin_id' => 3,
    //   'sub_section_id' => 6,
    //   'is_earn_point' => 0,
        // 'section_id'=>17
    // ]);

    // StoreTranslation::create([
    //   'store_id' => 2,
    //   'locale' => "en",
    //   'name' => 'Cleaning Store',
    //   'description' => 'Cleaning Store is The 6th Most Reviewed Cleaning in Iraq.'
    // ]);

    // StoreTranslation::create([
    //   'store_id' => 2,
    //   'locale' => "ar",
    //   'name' => 'متجر النظافه',
    //   'description' => 'متجر التنظيف هو سادس أكثر شركات التنظيف تقييمًا في العراق'
    // ]);



    // Store::create([
    //   'id' => 3,
    //   'image' => 'download1.jpg',
    //   'default_currency_id' => '1',
    //   'price' => 0,
    //   'exchange_rate' => 1308.25,
    //   'to_currency_id' => 3,
    //   'address' => 'ناحية الرضوية، X97Q+G9X ناحيه الرضويه / قرب مطعم, Najaf 54001, Iraq',
    //   'lat' => 32.93435404,
    //   'lng' => 44.52864848,
    //   'delivery_time' => 36,
    //   'delivery_fees' => 17,
    //   'is_offered' => 1,
    //   'admin_id' => 2,
    //   'sub_section_id' => 1,
    //   'is_earn_point' => 0و
        // 'section_id'=>2
    // ]);

    // StoreTranslation::create([
    //   'store_id' => 3,
    //   'locale' => "en",
    //   'name' => 'Toters Fresh',
    //   'description' => 'Toters Fresh is The 1th Most Reviewed Fresh  in Iraq.'
    // ]);

    // StoreTranslation::create([
    //   'store_id' => 3,
    //   'locale' => "ar",
    //   'name' => 'توترز فريش',
    //   'description' => 'توترز فريش هو المنتج الطازج الأول الأكثر تقييمًا في العراق'
    // ]);

  }
}
