<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Item, Store, Drink, StoreCategory, Addon, Currency, ItemTranslation, Size, SizeTranslation, Ingredient, IngredientTranslation, Option, OptionTranslation, Preference, PreferenceTranslation, Service, ServiceTranslation, Side, SideTranslation, ItemAddon};
use App\Models\ItemDrink;
use App\Models\ItemGift;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Scopes\ItemScope;
use App\Http\Requests\dash\DE\{storeItemRequest, updateItemRequest};
use App\Helpers\Helpers;

class ItemController extends Controller
{

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $locale = LaravelLocalization::getCurrentLocale();


    $items = Item::withoutGlobalScope(new ItemScope)->
      with([
        'store' => function ($query) use ($locale) {
          $query->select('id');
        },
        'category' => function ($query) use ($locale) {
          $query->select('id');

        },
        'translations' => function ($query) use ($locale) {
          $query->select('item_id', 'name')->where('locale', $locale);

        },
      ])->latest()->paginate(PAGINATION_COUNT);






    return view("content.item.indexItem", compact("items"));
  }


  public function paginationItem(Request $request)
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $items = Item::withoutGlobalScope(new ItemScope)->
      with([
        'store' => function ($query) use ($locale) {
          $query->select('id');
        },
        'category' => function ($query) use ($locale) {
          $query->select('id');

        },
        'translations' => function ($query) use ($locale) {
          $query->select('item_id', 'name')->where('locale', $locale);
        },
      ])->latest()->paginate(PAGINATION_COUNT);
    return view("content.item.paginationItem", compact("items"))->render();

  }




  public function searchItem(Request $request)
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $searchString = '%' . $request->search_string . '%';

    $items = Item::withoutGlobalScope(new ItemScope)->
      where(function ($query) use ($searchString) {
        $query->whereHas('category.translations', function ($subQuery) use ($searchString) {
          $subQuery->where('name', 'like', $searchString);
        })->orWhereHas('translations', function ($subQuery) use ($searchString) {
          $subQuery->where('name', 'like', $searchString)
            ->orWhere('description', 'like', $searchString);
        });
      })
      ->orWhere('price', 'like', $searchString)
      ->with([
        'section' => function ($query) {
          $query->select('id');
        },
        'translations' => function ($query) use ($locale) {
          $query->select('item_id', 'name')->where("locale", $locale);
        },
      ])
      ->latest()
      ->paginate(PAGINATION_COUNT);

    if ($items->count() > 0) {
      // Return the search results as HTML
      return view("content.item.paginationItem", compact("items"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }







  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $stores = Store::get();
    return view("content.item.create", compact("stores"));
  }
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
          'price' => $size['price'],
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
          'price' => $ingredient['price'],
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
          'price' => $service['price'],
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
          'price' => $preference['price'],
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
          'price' => $option['price'],
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
          'price' => $side['price'],
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

  public function store(StoreItemRequest $request)
  {
    \DB::beginTransaction();

    try {
      $storeId = $request->input('store_id');
      $store = Store::findOrFail($storeId);
      $currency = Currency::where("default", 1)->first();

      $item = new Item;
      $item->fill([
        'section_id' => $store->section_id,
        'subsection_id' => $store->sub_section_id,
        'store_id' => $storeId,
        'price' => $request->price,
        'default_currency_id' => $currency->id,
        'added_value' => $request->added_value,
        'is_restaurant' => $request->restaurant_true,
        'category_id' => $request->tag_id,
      ]);

      // Handle image upload
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagePath = $this->helper->upload_single_file($image, 'app/public/images/items/');
        $item->image = $imagePath;
      }

      $item->save();

      // Create translations with the Subsection ID
      $this->storeTranslations($item, $request);

      // Store related models
      $this->storeGifts($item, $request->gifts);
      $this->storeSizes($item, $storeId, $request->sizes);
      $this->storeIngredients($item, $storeId, $request->ingredients);
      $this->storeServices($item, $storeId, $request->services);
      $this->storePreferences($item, $storeId, $request->preferences);
      $this->storeOptions($item, $storeId, $request->options);
      $this->storeSides($item, $storeId, $request->sides);
      $this->storeDrinks($item, $request->drinks);
      $this->storeAddons($item, $request->addons);

      \DB::commit();

      return redirect()->route('items.index')->with('success', 'Item created successfully.');
    } catch (\Exception $e) {
      \DB::rollBack();
      return $this->helper->responseJson('fail', trans('api.auth_failed'), 422, null);
    }
  }





  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function show($item)
  {
    $item = Item::withoutGlobalScope(new ItemScope)->findOrFail($item);

    $added_ingredients = $item->Addingredients()->get();
    $remove_ingredients = $item->Removeingredients()->get();
    $addons = $item->addons()->get();
    $drinks = $item->drinks()->get();
    $gifts = $item->gifts()->get();
    $sizes = $item->sizes()->get();
    $services = $item->services()->get();
    $preferences = $item->preferences()->get();
    $options = $item->options()->get();
    $sides = $item->sides()->get();
    return view("content.item.show", compact("item", "sides", "options", "preferences", "services", "sizes", "gifts", "added_ingredients", "remove_ingredients", "addons", "drinks"));
  }




  public function edit($item)
  {
    $item = Item::withoutGlobalScope(new ItemScope)->findOrFail($item);


    return view("content.item.update", compact("item"));
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function update(updateItemRequest $request, Item $item)
  {

    $item->price = $request->upprice;
    $item->added_value = $request->upadded_value;


    if ($request->hasFile('upimage')) {
      $image = $request->file('upimage');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/items/');
      $item->image = $imagePath;

    }
    $item->save();

    $itemTranslation_en = $item->translate("en");
    $itemTranslation_en->name = $request->upname_en;
    $itemTranslation_en->description = $request->updescription_en;
    $itemTranslation_en->save();

    $itemTranslation_ar = $item->translate("ar");
    $itemTranslation_ar->name = $request->upname_ar;
    $itemTranslation_ar->description = $request->updescription_ar;
    $itemTranslation_ar->save();

    return redirect()->route('items.index')->with('success', 'Item has been updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function destroy(Item $item)
  {
    // \DB::beginTransaction();
    // try {
    $item->drinks()->detach();
    $item->addons()->detach();
    $item->gifts()->delete();

    // Delete translations for sizes
    foreach ($item->sizes as $size) {
      $size->translations()->delete();
    }

    foreach ($item->Addingredients as $Addingredient) {
      $Addingredient->translations()->delete();
    }

    foreach ($item->Removeingredients as $Removeingredient) {
      $Removeingredient->translations()->delete();
    }

    foreach ($item->services as $service) {
      $service->translations()->delete();
    }
    foreach ($item->preferences as $preference) {
      $preference->translations()->delete();
    }

    foreach ($item->options as $option) {
      $option->translations()->delete();
    }
    foreach ($item->sides as $side) {
      $side->translations()->delete();
    }

    $item->Addingredients()->delete();
    $item->Removeingredients()->delete();
    $item->sizes()->delete();
    $item->services()->delete();
    $item->preferences()->delete();
    $item->options()->delete();
    $item->sides()->delete();
    $item->translations()->delete();

    $item->delete();
    \DB::commit();

    return response()->json(['status' => true, 'msg' => "Item Deleted Successfully"]);
    // } catch (\Exception $e) {
    //   \DB::rollBack();
    //   return response()->json(['status' => false, 'msg' => "An error occurred while deleting the Item."], 500);
    // }
  }

  public function displayTags($store_id)
  {
    $locale = LaravelLocalization::getCurrentLocale();

    $tags = StoreCategory::
      with([
        'translations' => function ($query) use ($locale) {
          $query->where('locale', $locale);
        },
      ])
      ->where("store_id", $store_id)
      ->get();



    return response()->json($tags);

  }


  public function displayDrinks($store_id)
  {
    $locale = LaravelLocalization::getCurrentLocale();

    $addons = Drink::
      with([
        'translations' => function ($query) use ($locale) {
          $query->where('locale', $locale);
        },
      ])
      ->where("store_id", $store_id)
      ->get();


    return response()->json($addons);

  }

  public function displayAddons($store_id)
  {

    $addons = Addon::where("store_id", $store_id)->get();

    return response()->json($addons);

  }
}
