<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\OfferTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class offerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {



    // Offer::create([
    //   'id' => 1,
    //   'image' => 'offer.jpeg',
    //   'store_id' => 1,
    //   "subsection_id" => 12,
    //   'discount_percentage' => 5,
    //   'order_counts' => 5,
    //   'min_price' => 6,
    //   'required_points' => 2100000,
    //   'tier_id' => 1,
    //   'saveup_price' => 4.6601,
    //   'user_count' => 500,
    //   'free_delivery' => 1,
    //   'from_date' => '2023-11-22',
    //   'to_date' => '2024-11-22',



    // ]);

    // OfferTranslation::create([
    //   'offer_id' => 1,
    //   'locale' => "en",
    //   'name' => '5% off on 5 orders and free delivery',
    //   'title' => 'Unlock 5% Off On 5 Food Orders and free delivery',
    //   'description' => 'Save Up to IQD 7000 on every order from foods'

    // ]);
    // OfferTranslation::create([
    //   'offer_id' => 1,
    //   'locale' => "ar",
    //   'name' => 'خصم 5% على 5 طلبات والتوصيل مجاني',
    //   'title' => 'احصل على خصم 5% على 5 طلبات طعام وتوصيل مجاني',
    //   'description' => 'وفر حتى 7000 دينار عراقي على كل طلب من الأطعمة'
    // ]);



    // Offer::create([
    //   'id' => 2,
    //   'image' => 'offer.jpeg',
    //   'store_id' => 3,
    //   "subsection_id" => 1,
    //   'discount_percentage' => 5,
    //   'order_counts' => 5,
    //   'min_price' => 6,
    //   'required_points' => 2100000,
    //   'tier_id' => 1,
    //   'saveup_price' => 4.6601,
    //   'user_count' => 500,
    //   'free_delivery' => 1,
    //   'from_date' => '2023-11-22',
    //   'to_date' => '2024-11-22',




    // ]);

    // OfferTranslation::create([
    //   'offer_id' => 2,
    //   'locale' => "en",
    //   'name' => '5% off on 5 orders',
    //   'title' => 'Unlock 5% Off On 5 Food Orders',
    //   'description' => 'Save Up to IQD 7000 on every order from foods'

    // ]);
    // OfferTranslation::create([
    //   'offer_id' => 2,
    //   'locale' => "ar",
    //   'name' => 'خصم 5% على 5 طلبات  ',
    //   'title' => 'احصل على خصم 5% على 5 طلبات   ',
    //   'description' => 'وفر حتى 7000 دينار عراقي على كل طلب  '
    // ]);






    Offer::create([
      'id' => 3,
      'image' => 'offer.jpeg',
      'store_id' => 1,
      "subsection_id" => 12,
      'discount_percentage' => 5,
      'order_counts' => 0,
      'min_price' => 0,
      'required_points' => 0,
      'tier_id' => 1,
      'saveup_price' => 0,
      'user_count' => 500,
      'free_delivery' => 0,
      'from_date' => '2023-11-22',
      'to_date' => '2024-11-22',
      'item_id'=>1



    ]);

    OfferTranslation::create([
      'offer_id' => 3,
      'locale' => "en",
      'name' => '5 % discount',
      'title' => '5 % discount',
      'description' => '5 % discount'

    ]);
    OfferTranslation::create([
      'offer_id' => 3,
      'locale' => "ar",
      'name' => 'خصم 5%',
      'title' => 'خصم 5%',
      'description' =>  'خصم 5%',
    ]);







  }
}
