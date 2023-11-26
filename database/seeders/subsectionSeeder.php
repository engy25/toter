<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
  Subsection,
  SubsectionTranslation
};

class subsectionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    SubSection::create(['id' => 1, 'image' => '1.svg', 'section_id' => 2]);
    SubSectionTranslation::create([
      'sub_section_id' => 1,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 1,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);



    SubSection::create(['id' => 2, 'image' => '1.svg', 'section_id' => 5]);
    SubSectionTranslation::create([
      'sub_section_id' => 2,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 2,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSection::create(['id' => 3, 'image' => '1.svg', 'section_id' => 7]);
    SubSectionTranslation::create([
      'sub_section_id' => 3,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 3,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);


    SubSection::create(['id' => 4, 'image' => '1.svg', 'section_id' => 4]);
    SubSectionTranslation::create([
      'sub_section_id' => 4,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 4,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);


    SubSection::create(['id' => 5, 'image' => '1.svg', 'section_id' => 6]);
    SubSectionTranslation::create([
      'sub_section_id' => 5,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 5,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);


    SubSection::create(['id' => 6, 'image' => '1.svg', 'section_id' => 10]);
    SubSectionTranslation::create([
      'sub_section_id' => 6,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 6,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);



    SubSection::create(['id' => 7, 'image' => '1.svg', 'section_id' => 11]);
    SubSectionTranslation::create([
      'sub_section_id' => 7,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 7,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);



    SubSection::create(['id' => 8, 'image' => '1.svg', 'section_id' => 13]);
    SubSectionTranslation::create([
      'sub_section_id' => 8,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 8,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);


    SubSection::create(['id' => 9, 'image' => '1.svg', 'section_id' => 14]);
    SubSectionTranslation::create([
      'sub_section_id' => 9,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 9,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSection::create(['id' => 10, 'image' => '1.svg', 'section_id' => 15]);
    SubSectionTranslation::create([
      'sub_section_id' => 10,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 10,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSection::create(['id' => 11, 'image' => '1.svg', 'section_id' => 16]);
    SubSectionTranslation::create([
      'sub_section_id' => 11,
      'locale' => "en",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 11,
      'locale' => "ar",
      'name' => 'Main',
      'description' => 'Main'
    ]);

    $i = 12;
    $images = [
      '1.svg',
      '2.svg',
      '3.svg',
      '4.svg',
      '5.svg',
      '6.svg',
      '7.svg',
      '8.svg',
      '9.svg',
      '10.svg',
      '11.svg',
      '12.svg',
      '13.svg',
      '14.svg',
      '15.svg',
      '16.svg',
      '17.svg',
      '18.svg',
      '19.svg',
      '20.svg',
      '21.svg',
      '22.svg',


    ];

    foreach ($images as $image) {
      SubSection::create(['id' => $i++, 'image' => $image, 'section_id' => 17]);
    }


    SubSectionTranslation::create([
      'sub_section_id' => 12,
      'locale' => "en",
      'name' => 'Armenian',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 12,
      'locale' => "ar",
      'name' => 'ارمني',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 13,
      'locale' => "en",
      'name' => 'Bakeries',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 13,
      'locale' => "ar",
      'name' => 'مخبوزات',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 14,
      'locale' => "en",
      'name' => 'Burgers',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 14,
      'locale' => "ar",
      'name' => 'برغر',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 15,
      'locale' => "en",
      'name' => 'Daily Dish',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 15,
      'locale' => "ar",
      'name' => 'يوميات',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 16,
      'locale' => "en",
      'name' => 'Indian',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 16,
      'locale' => "ar",
      'name' => 'هندي',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 17,
      'locale' => "en",
      'name' => 'Salads',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 17,
      'locale' => "ar",
      'name' => 'سلطات',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 18,
      'locale' => "en",
      'name' => 'Coffe',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 18,
      'locale' => "ar",
      'name' => 'قهوه',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 19,
      'locale' => "en",
      'name' => 'Fast Food',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 19,
      'locale' => "ar",
      'name' => 'فاست فود',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 20,
      'locale' => "en",
      'name' => 'Ice Cream',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 20,
      'locale' => "ar",
      'name' => 'بوظه',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 21,
      'locale' => "en",
      'name' => 'Juices',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 21,
      'locale' => "ar",
      'name' => 'عصائر',

    ]);


    SubSectionTranslation::create([
      'sub_section_id' => 22,
      'locale' => "en",
      'name' => 'Sandwiches',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 22,
      'locale' => "ar",
      'name' => 'سندوتشات',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 23,
      'locale' => "en",
      'name' => 'Mexican',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 23,
      'locale' => "ar",
      'name' => 'مكسيكي',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 24,
      'locale' => "en",
      'name' => 'Pizza',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 24,
      'locale' => "ar",
      'name' => 'بيتزا',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 25,
      'locale' => "en",
      'name' => 'Desserts',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 25,
      'locale' => "ar",
      'name' => 'حلويات',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 26,
      'locale' => "en",
      'name' => 'Gluten- Free',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 26,
      'locale' => "ar",
      'name' => 'خالي من الجلوتين',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 27,
      'locale' => "en",
      'name' => 'Italian',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 27,
      'locale' => "ar",
      'name' => 'ايطالي',

    ]);


    SubSectionTranslation::create([
      'sub_section_id' => 28,
      'locale' => "en",
      'name' => 'Breakfast',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 28,
      'locale' => "ar",
      'name' => 'فطور',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 29,
      'locale' => "en",
      'name' => 'Chinese',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 29,
      'locale' => "ar",
      'name' => 'صيني',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 30,
      'locale' => "en",
      'name' => 'Lebanese',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 30,
      'locale' => "ar",
      'name' => 'لبناني',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 31,
      'locale' => "en",
      'name' => 'Healthy',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 31,
      'locale' => "ar",
      'name' => 'صحي',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 32,
      'locale' => "en",
      'name' => 'Poke',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 32,
      'locale' => "ar",
      'name' => 'سلطة هاواي',

    ]);


    SubSectionTranslation::create([
      'sub_section_id' => 33,
      'locale' => "en",
      'name' => 'Sushi',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 33,
      'locale' => "ar",
      'name' => 'سوشي',

    ]);





    SubSection::create(['id' => 34, 'image' => '23.svg', 'section_id' => 3]);
    SubSectionTranslation::create([
      'sub_section_id' => 34,
      'locale' => "en",
      'name' => 'Make Up',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 34,
      'locale' => "ar",
      'name' => 'مكياج',
    ]);




    SubSection::create(['id' => 35, 'image' => '24.svg', 'section_id' => 3]);
    SubSectionTranslation::create([
      'sub_section_id' => 35,
      'locale' => "en",
      'name' => 'Wellness',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 35,
      'locale' => "ar",
      'name' => 'العناية',
    ]);



    SubSection::create(['id' => 36, 'image' => '23.svg', 'section_id' => 8]);
    SubSectionTranslation::create([
      'sub_section_id' => 36,
      'locale' => "en",
      'name' => 'Make Up',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 36,
      'locale' => "ar",
      'name' => 'مكياج',
    ]);




    SubSection::create(['id' => 37, 'image' => '24.svg', 'section_id' => 8]);
    SubSectionTranslation::create([
      'sub_section_id' => 37,
      'locale' => "en",
      'name' => 'Wellness',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 37,
      'locale' => "ar",
      'name' => 'العناية',
    ]);






    $the_images = [
      '25.svg',
      '26.svg',
      '27.svg',
      '28.svg',
      '29.svg',


    ];

    $m=38;


   foreach ($the_images as $imagess) {
      SubSection::create(['id' => $m++, 'image' => $imagess, 'section_id' => 9]);
    }


    SubSectionTranslation::create([
      'sub_section_id' => 38,
      'locale' => "en",
      'name' => 'Groceries',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' =>38 ,
      'locale' => "ar",
      'name' => 'بقاله',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 39,
      'locale' => "en",
      'name' => 'Butchery',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 39,
      'locale' => "ar",
      'name' => 'مسلخ',

    ]);





    SubSectionTranslation::create([
      'sub_section_id' => 40,
      'locale' => "en",
      'name' => 'Candies',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 40,
      'locale' => "ar",
      'name' => 'الحلوي',

    ]);


    SubSectionTranslation::create([
      'sub_section_id' => 41,
      'locale' => "en",
      'name' => 'Pet Corner',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 41,
      'locale' => "ar",
      'name' => 'ركن الحيوان',

    ]);


    SubSectionTranslation::create([
      'sub_section_id' => 42,
      'locale' => "en",
      'name' => 'Pantry',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 42,
      'locale' => "ar",
      'name' => 'مخزن',

    ]);







    $photos = [
      '30.svg',
      '31.svg',
      '32.svg',
      '33.svg',
      '34.svg',
      '35.svg',
      '36.svg',
      '37.svg',
      '38.svg',
      '39.svg',
      '40.svg',
      '41.svg',
      '42.svg',

    ];

    $s=43;


   foreach ($photos as $photo) {
      SubSection::create(['id' => $s++, 'image' => $photo, 'section_id' => 12]);
    }


    SubSectionTranslation::create([
      'sub_section_id' => 43,
      'locale' => "en",
      'name' => 'Baby Care',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' =>43 ,
      'locale' => "ar",
      'name' => 'عناية الطفل',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 44,
      'locale' => "en",
      'name' => 'Baking',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 44,
      'locale' => "ar",
      'name' => 'مخبوزات',

    ]);





    SubSectionTranslation::create([
      'sub_section_id' => 45,
      'locale' => "en",
      'name' => 'Home',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 45,
      'locale' => "ar",
      'name' => 'اساسيات المنزل',

    ]);


    SubSectionTranslation::create([
      'sub_section_id' => 46,
      'locale' => "en",
      'name' => 'Optics',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 46,
      'locale' => "ar",
      'name' => 'بصريات',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 47,
      'locale' => "en",
      'name' => 'Party',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 47,
      'locale' => "ar",
      'name' => 'لوازم الحفله',

    ]);


    SubSectionTranslation::create([
      'sub_section_id' => 48,
      'locale' => "en",
      'name' => 'Pet Corner',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 48,
      'locale' => "ar",
      'name' => 'ركن الحيوان',

    ]);


    SubSectionTranslation::create([
      'sub_section_id' => 49,
      'locale' => "en",
      'name' => 'Sports',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 49,
      'locale' => "ar",
      'name' => 'مستلزمات رياضيه',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 50,
      'locale' => "en",
      'name' => 'Technical',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 50,
      'locale' => "ar",
      'name' => 'تقنيات',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 51,
      'locale' => "en",
      'name' => 'Gifts',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 51,
      'locale' => "ar",
      'name' => 'هدايا',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 52,
      'locale' => "en",
      'name' => 'Fun Zone',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 52,
      'locale' => "ar",
      'name' => 'ترفيه',

    ]);


    SubSectionTranslation::create([
      'sub_section_id' => 53,
      'locale' => "en",
      'name' => 'Stationery',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 53,
      'locale' => "ar",
      'name' => 'قرطاسيه',

    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 54,
      'locale' => "en",
      'name' => 'Accessories',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 54,
      'locale' => "ar",
      'name' => 'اكسسوارات',

    ]);



    SubSectionTranslation::create([
      'sub_section_id' => 55,
      'locale' => "en",
      'name' => 'Community',
    ]);

    SubSectionTranslation::create([
      'sub_section_id' => 55,
      'locale' => "ar",
      'name' => 'المجتمع',

    ]);


}

}
