<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TierTableTranslationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    // Find the user by ID

    // Assign the role to the user
    DB::table('tier_translations')->insert([
      [
        'tier_id' => 1,
        'locale' => 'en',
        'name' => 'Green Tier',
        'description' => 'Green Tier Description',
      ],
      [
        'tier_id' => 1,
        'locale' => 'ar',
        'name' => 'الفئة الخضراء',
        'description' => 'وصف الفئة الخضراء',
      ],
    ]);

    // Insert translations for the Golden Tier
    DB::table('tier_translations')->insert([
      [
        'tier_id' => 2,
        'locale' => 'en',
        'name' => 'Golden Tier',
        'description' => 'Golden Tier Description',
      ],
      [
        'tier_id' => 2,
        'locale' => 'ar',
        'name' => 'الفئة الذهبية',
        'description' => 'وصف الفئة الذهبية',
      ],
    ]);
  }
}
