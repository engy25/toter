<?php

namespace Database\Seeders;

use App\Models\{Butler,ButlerTranslation};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class butlerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Butler::create(['id' => 1,'image'=>"butler.jpeg","delivery_time"=>"From 30 to 45 minutes","delivery_charge"=>5,"service_charge"=>2,"default_currency_id"=>1,"exchange_rate"=>12,"to_currency_id"=>2,"admin_id"=>1]);

      ButlerTranslation::create([
        'butler_id' => 1,
        'locale' => "en",
        'name' => 'Deliver Your Stuff',
        'description' => 'e.g. You forgot your keys at home and need to get them',
      ]);
      ButlerTranslation::create([
        'butler_id' => 1,
        'locale' => "ar",
        'name' => 'توصيل احتياجاتك',
        'description'=>'مثلا نسيت مفتاحك بالبيت وتريد الحصول عليه'

      ]);



      Butler::create(['id' => 2,'image'=>"What.jpeg","delivery_time"=>"From 30 to 45 minutes","delivery_charge"=>5,"service_charge"=>2,"default_currency_id"=>1,"exchange_rate"=>12,"to_currency_id"=>2,"admin_id"=>1]);

      ButlerTranslation::create([
        'butler_id' => 2,
        'locale' => "en",
        'name' => 'Buy Something',
        'description' => "Didn't find what you were looking for at our stores? Our butlers can buy whatever you need from your store of choice.",
      ]);
      ButlerTranslation::create([
        'butler_id' => 2,
        'locale' => "ar",
        'name' => 'شراء احتياجاتك',
        'description'=>'ما لقيت الذي تريده بتطبيقنا؟مندوب توترز يقدر يشتريلك للي تحتاجه من اي مكان تختاره'

      ]);

    }
}
