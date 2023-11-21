<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TierTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $tier1 = DB::table('tiers')->insert([
      ['orders_count' => '10', 'duration_bydays' => '30', 'expired_duration_bydays' => '90', 'earn_reward_point' => '500', 'image' => 'tier1.png'],
      ['orders_count' => '10', 'duration_bydays' => '30', 'expired_duration_bydays' => '90', 'earn_reward_point' => '5000', 'image' => 'tier2.png'],

    ]);
    // DB::table('tier_translations')->insert([
    //   'tier_id' => $tier1->id,
    //   'locale' => "en",
    //   "name" => "Green Tier",
    //   "description" => 'Green Tierrr'
    // ]);
    // DB::table('tier_translations')->insert([
    //   'tier_id' => $tier1->id,
    //   'locale' => "ar",
    //   "name" => "الفئه الخضراء",
    //   "description" => ' الفئه الخضراء'
    // ]);



    // DB::table('tier_translations')->insert([
    //   'tier_id' => $tier2->id,
    //   'locale' => "en",
    //   "name" => "Golden Tier",
    //   "description" => 'Golden Tierrr'
    // ]);
    // DB::table('tier_translations')->insert([
    //   'tier_id' => $tier2->id,
    //   'locale' => "ar",
    //   "name" => "الفئه الذهبيه",
    //   "description" => ' الفئه الذهبيه'
    // ]);
  }
}
