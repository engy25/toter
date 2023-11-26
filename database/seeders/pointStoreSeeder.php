<?php

namespace Database\Seeders;

use App\Models\PointStore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pointStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      PointStore::create(['store_id' => 1, 'order_counts' => '3', 'expire_days' => 30,'min_price'=>1000,'points_earned'=>300]);


    }
}
