<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
  Section,
  SectionTranslation
};

class sectionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $i=1;
    $images = [
      'main.svg',
      'food.svg',
      'fresh_toters.svg',
      'self_care.svg',
      'new.svg',
      'flowers.svg',
      'funds.svg',
      'up_50.svg',
      'health.svg',
      'market.svg',
      'cleaning.svg',
      'gas.svg',
      'shop.svg',
      'car.svg',
      'laundry.svg',
      'butler.svg',
      'rewards.svg',


    ];

    foreach ($images as $image) {
      Section::create(['id'=>$i++,'image' => $image]);
    }
    SectionTranslation::create([
      'section_id' => 1,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main.'
    ]);

    SectionTranslation::create([
      'section_id' => 1,
      'locale' => "ar",
      'name' => 'Main',
      'description' =>'Main'
    ]);


    SectionTranslation::create([
      'section_id' => 17,
      'locale' => "en",
      'name' => 'Food',
      'description' => 'All the best restaurants near you.'
    ]);

    SectionTranslation::create([
      'section_id' => 17,
      'locale' => "ar",
      'name' => 'مطاعم',
      'description' => 'افضل الماعم القريبه منك'
    ]);

    SectionTranslation::create([
      'section_id' => 2,
      'locale' => "ar",
      'name' => 'توترز فريش ',
      'description' => 'البقاله في طريقها اليك'
    ]);

    SectionTranslation::create([
      'section_id' => 2,
      'locale' => "en",
      'name' => 'Fresh toters',
      'description' => 'Groceries your way.'
    ]);

    SectionTranslation::create([
      'section_id' => 3,
      'locale' => "en",
      'name' => 'Self Care',
      'description' => 'All your self-care and make up.'
    ]);

    SectionTranslation::create([
      'section_id' => 3,
      'locale' => "ar",
      'name' => 'التجميل',
      'description' => 'اطلب جميع منتجات العناية الذاتيه'
    ]);

    SectionTranslation::create([
      'section_id' => 4,
      'locale' => "en",
      'name' => 'What is New',
      'description' => 'Browse the latest restaurants and stores.'
    ]);

    SectionTranslation::create([
      'section_id' => 4,
      'locale' => "ar",
      'name' => 'جديد',
      'description' => 'تصفح احدث المطاعم والمتاجر'
    ]);

    SectionTranslation::create([
      'section_id' => 5,
      'locale' => "en",
      'name' => 'Flowers',
      'description' => 'Freshly Picked flowers for all'

    ]);

    SectionTranslation::create([
      'section_id' => 5,
      'locale' => "ar",
      'name' => 'زهور',
      'description' => 'زهور منتقاه حديثا لجميع المناسبات'
    ]);


    SectionTranslation::create([
      'section_id' => 6,
      'locale' => "en",
      'name' => 'Add Funds',
      'description' => 'Top up your wallets for quick.'
    ]);

    SectionTranslation::create([
      'section_id' => 6,
      'locale' => "ar",
      'name' => 'اضف رصيد',
      'description' => 'عبئ محفظتك لتسديد دفعات سريعه'
    ]);

    SectionTranslation::create([
      'section_id' => 7,
      'locale' => "en",
      'name' => 'Up to 50 %',
      'description' => 'order now and get 50% Off'
    ]);

    SectionTranslation::create([
      'section_id' => 7,
      'locale' => "ar",
      'name' => 'Up to 50 %',
      'description' => 'اطلب الان واحصل علي خصم لغاية'
    ]);

    SectionTranslation::create([
      'section_id' => 8,
      'locale' => "en",
      'name' => 'Health',
      'description' => 'Putting your health as periority with one click.'
    ]);

    SectionTranslation::create([
      'section_id' => 8,
      'locale' => "ar",
      'name' => 'الصحه',
      'description' => 'خلي صحتك من الاولويات بكبسه واحده'
    ]);

    SectionTranslation::create([
      'section_id' => 9,
      'locale' => "en",
      'name' => 'Market',
      'description' => ' groceries and pantry essentials are delivered in a jiffy '
    ]);

    SectionTranslation::create([
      'section_id' => 9,
      'locale' => "ar",
      'name' => 'البقاله',
      'description' => ' كل الباقله والمستلزمات يتم تسليمها في لمح البصر'
    ]);

    SectionTranslation::create([
      'section_id' => 10,
      'locale' => "en",
      'name' => 'Cleaning',
      'description' => 'Still back and enjoy the scrub!'
    ]);

    SectionTranslation::create([
      'section_id' => 10,
      'locale' => "ar",
      'name' => 'التنظيف',
      'description' => 'اجلس واستمته بالتلميع'
    ]);

    SectionTranslation::create([
      'section_id' => 11,
      'locale' => "en",
      'name' => 'Gas',
      'description' => 'Get yoir gas tank delivered to your door '
    ]);

    SectionTranslation::create([
      'section_id' => 11,
      'locale' => "ar",
      'name' => 'غاز',
      'description' => 'اطلب خزان غاز الي بابك'
    ]);


    SectionTranslation::create([
      'section_id' => 12,
      'locale' => "en",
      'name' => 'Shops',
      'description' => 'Shop from the comfort of your home'
    ]);

    SectionTranslation::create([
      'section_id' => 12,
      'locale' => "ar",
      'name' => 'متاجر',
      'description' => 'تسوق من راحة منزلك'
    ]);

    SectionTranslation::create([
      'section_id' => 13,
      'locale' => "en",
      'name' => 'Car Wash',
      'description' => 'Give Your Car the care wash it'
    ]);

    SectionTranslation::create([
      'section_id' => 13,
      'locale' => "ar",
      'name' => 'غسيل سيارات ',
      'description' => 'صار وقت تغسل السياره'
    ]);

    SectionTranslation::create([
      'section_id' => 14,
      'locale' => "en",
      'name' => 'Laundry',
      'description' => 'Let us do your laundry'
    ]);

    SectionTranslation::create([
      'section_id' => 14,
      'locale' => "ar",
      'name' => 'مصبغه',
      'description' => 'خلينا نغسلك ملابسك ونساعدك بيها'
    ]);

    SectionTranslation::create([
      'section_id' => 15,
      'locale' => "en",
      'name' => 'Butler',
      'description' => 'We deliver all orders provided they are sufficient.'
    ]);

    SectionTranslation::create([
      'section_id' => 15,
      'locale' => "ar",
      'name' => 'المندوب',
      'description' => 'نقوم بتوصيل جميع الطلبات شرط ان تسع'
    ]);

    SectionTranslation::create([
      'section_id' => 16,
      'locale' => "en",
      'name' => 'Rewards',
      'description' => 'Redeem your points with free meals and offers'
    ]);

    SectionTranslation::create([
      'section_id' => 16,
      'locale' => "ar",
      'name' => 'جوائز توترز',
      'description' => 'استبدل نقاطك بوجبات مجانيه وخصومات'
    ]);







  }


}
