<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Item, Store, ItemDrink, ItemGift, Drink, StoreCategory, Addon, Currency, ItemTranslation, Size, SizeTranslation, Ingredient, IngredientTranslation, Option, OptionTranslation, Preference, PreferenceTranslation, Service, ServiceTranslation, Side, SideTranslation, ItemAddon};
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Scopes\ItemScope;
use App\Http\Requests\dash\DE\{storeItemRequest, updateItemRequest,storeItempointRequest};
use App\Helpers\Helpers;
use App\Traits\itemTrait;
class ItemController extends Controller
{
  use itemTrait;

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


    $items = Item::
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

    $items = Item::
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

    $items = Item::
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
   * Show the form for creating a new item that the user can buy by price not point.
   *

   */
  public function create()
  {
    $stores = Store::get();
    return view("content.item.create", compact("stores"));
  }
  /**
   * Show the form for creating a new item that the user can buy by point not price.
   *

   */




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
