<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StoreDistrict;
class DistrictStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      StoreDistrict::create(["store_id"=>1,"district_id"=>2,"delivery_charge"=>12]);

      StoreDistrict::create(["store_id"=>1,"district_id"=>3,"delivery_charge"=>10]);

      StoreDistrict::create(["store_id"=>1,"district_id"=>4,"delivery_charge"=>8]);

      StoreDistrict::create(["store_id"=>2,"district_id"=>2,"delivery_charge"=>12]);

      StoreDistrict::create(["store_id"=>2,"district_id"=>3,"delivery_charge"=>10]);

      StoreDistrict::create(["store_id"=>2,"district_id"=>4,"delivery_charge"=>8]);


      StoreDistrict::create(["store_id"=>3,"district_id"=>2,"delivery_charge"=>12]);

      StoreDistrict::create(["store_id"=>3,"district_id"=>3,"delivery_charge"=>10]);

      StoreDistrict::create(["store_id"=>3,"district_id"=>4,"delivery_charge"=>8]);
    }
}
