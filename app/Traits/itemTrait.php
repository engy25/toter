<?php

namespace App\Traits;
use App\Models\{Item, ItemDrink, ItemGift, ItemTranslation, Size, SizeTranslation, Ingredient, IngredientTranslation, Option, OptionTranslation, Preference, PreferenceTranslation, Service, ServiceTranslation, Side, SideTranslation, ItemAddon};
use Illuminate\Http\Request;
trait itemTrait
{




  private function storeGifts(Item $item, $gifts)
  {

    if ($gifts) {
      foreach ($gifts as $gift) {
        $theGift = new ItemGift;
        $theGift->fill([
          'item_id' => $item->id,
          'name' => $gift['name'],
        ]);

        if (isset($gift['image']) && $gift['image']) {
          $image = $gift['image'];
          $imagePath = $this->helper->upload_single_file($image, 'app/public/images/gifts/');
          $theGift->image = $imagePath;
        }

        $theGift->save();
      }
    }
  }




  private function storeSizes(Item $item, $storeId, $sizes)
  {
    if ($sizes) {
      foreach ($sizes as $size) {
        $theSize = new Size;
        $theSize->fill([
          'item_id' => $item->id,

          'price' => $size['price'] ?? 0,
          'store_id' => $storeId,
        ]);
        $theSize->save();

        SizeTranslation::create(['name' => $size["name_en"], 'size_id' => $theSize->id, 'locale' => 'en']);
        SizeTranslation::create(['name' => $size["name_ar"], 'size_id' => $theSize->id, 'locale' => 'ar']);
      }
    }
  }

  private function storeIngredients(Item $item, $storeId, $ingredients)
  {
    if ($ingredients) {
      foreach ($ingredients as $ingredient) {
        $theIngredient = new Ingredient;
        $theIngredient->fill([
          'item_id' => $item->id,
          'store_id' => $storeId,
          'price' => $ingredient['price'] ?? 0,
          'add' => $ingredient['add_remove'],
        ]);

        // Handle image upload

        if (isset($ingredient['image']) && $ingredient['image']) {
          $image = $ingredient['image'];
          $imagePath = $this->helper->upload_single_file($image, 'app/public/images/ingredients/');
          $theIngredient->image = $imagePath;
        }

        $theIngredient->save();

        IngredientTranslation::create(['name' => $ingredient["name_en"], 'ingredient_id' => $theIngredient->id, 'locale' => 'en']);
        IngredientTranslation::create(['name' => $ingredient["name_ar"], 'ingredient_id' => $theIngredient->id, 'locale' => 'ar']);
      }
    }
  }

  private function storeServices(Item $item, $storeId, $services)
  {
    if ($services) {
      foreach ($services as $service) {
        $theService = new Service;
        $theService->fill([
          'item_id' => $item->id,
          'store_id' => $storeId,
          'price' => $service['price'] ??0,
        ]);

        $theService->save();

        ServiceTranslation::create(['name' => $service["name_en"], 'service_id' => $theService->id, 'locale' => 'en']);
        ServiceTranslation::create(['name' => $service["name_ar"], 'service_id' => $theService->id, 'locale' => 'ar']);
      }
    }
  }

  private function storePreferences(Item $item, $storeId, $preferences)
  {
    if ($preferences) {
      foreach ($preferences as $preference) {
        $thePreference = new Preference;
        $thePreference->fill([
          'item_id' => $item->id,
          'store_id' => $storeId,
          'price' => $preference['price'] ??0,
        ]);

        $thePreference->save();

        PreferenceTranslation::create(['name' => $preference["name_en"], 'preference_id' => $thePreference->id, 'locale' => 'en']);
        PreferenceTranslation::create(['name' => $preference["name_ar"], 'preference_id' => $thePreference->id, 'locale' => 'ar']);
      }
    }
  }

  private function storeOptions(Item $item, $storeId, $options)
  {
    if ($options) {
      foreach ($options as $option) {
        $theOption = new Option;
        $theOption->fill([
          'item_id' => $item->id,
          'store_id' => $storeId,
          'price' => $option['price'] ??0,
        ]);

        // Handle image upload
        if (isset($option['image']) && $option['image']) {
          $image = $option['image'];
          $imagePath = $this->helper->upload_single_file($image, 'app/public/images/options/');
          $theOption->image = $imagePath;
        }

        $theOption->save();

        OptionTranslation::create(['name' => $option["name_en"], 'option_id' => $theOption->id, 'locale' => 'en']);
        OptionTranslation::create(['name' => $option["name_ar"], 'option_id' => $theOption->id, 'locale' => 'ar']);
      }
    }
  }


  private function storeSides(Item $item, $storeId, $sides)
  {
    if ($sides) {
      foreach ($sides as $side) {
        $theSide = new Side;
        $theSide->fill([
          'item_id' => $item->id,
          'store_id' => $storeId,
          'price' => $side['price'] ??0,
        ]);

        // Handle image upload
        if (isset($side['image']) && $side['image']) {
          $image = $side['image'];
          $imagePath = $this->helper->upload_single_file($image, 'app/public/images/sides/');
          $theSide->image = $imagePath;
        }

        $theSide->save();

        SideTranslation::create(['name' => $side["name_en"], 'side_id' => $theSide->id, 'locale' => 'en']);
        SideTranslation::create(['name' => $side["name_ar"], 'side_id' => $theSide->id, 'locale' => 'ar']);
      }
    }
  }
  private function storeTranslations(Item $item, Request $request)
  {
    $locales = ['en', 'ar'];

    foreach ($locales as $locale) {
      ItemTranslation::create([
        'name' => $request->get("name_$locale"),
        'description' => $request->get("description_$locale"),
        'item_id' => $item->id,
        'locale' => $locale,
      ]);
    }
  }

  private function storeDrinks(Item $item, $drinks)
  {
    if ($drinks) {
      foreach ($drinks as $drink) {
        ItemDrink::create([
          "item_id" => $item->id,
          "drink_id" => $drink
        ]);
      }
    }
  }


  private function storeAddons(Item $item, $addons)
  {
    if ($addons) {
      foreach ($addons as $addon) {
        ItemAddon::create([
          "item_id" => $item->id,
          "addon_id" => $addon
        ]);
      }
    }
  }




}
