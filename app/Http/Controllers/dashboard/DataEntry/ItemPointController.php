<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Item, Store, Currency};
use App\Traits\itemTrait;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Scopes\ItemScope;
use App\Http\Requests\dash\DE\{storeItempointRequest,updateItempointRequest};

use App\Helpers\Helpers;
class ItemPointController extends Controller
{
  use itemTrait;
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function index()
  {
    $locale = LaravelLocalization::getCurrentLocale();


    $items = Item::withoutGlobalScope(new ItemScope)->where("points","!=",0)->
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


    return view("content.itempoint.indexItem", compact("items"));
  }




  public function paginationItem(Request $request)
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $items = Item::withoutGlobalScope(new ItemScope)->where("points","!=",0)->
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
    return view("content.itempoint.paginationItem", compact("items"))->render();

  }


  public function searchItem(Request $request)
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $searchString = '%' . $request->search_string . '%';

    $items = Item::withoutGlobalScope(new ItemScope)->where("points","!=",0)->
      where(function ($query) use ($searchString) {
        $query->whereHas('category.translations', function ($subQuery) use ($searchString) {
          $subQuery->where('name', 'like', $searchString);
        })->orWhereHas('translations', function ($subQuery) use ($searchString) {
          $subQuery->where('name', 'like', $searchString)
            ->orWhere('description', 'like', $searchString);
        });
      })
      ->orWhere('points', 'like', $searchString)
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
      return view("content.itempoint.paginationItem", compact("items"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }


  public function create()
  {
    $stores = Store::get();
    return view("content.itempoint.create", compact("stores"));
  }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request

     */
  public function store(storeItempointRequest $request)
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
        'points' => $request->point,
        'price'=>0,
        'default_currency_id' => $currency->id,
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


      \DB::commit();

      return redirect()->route('itempoints.index')->with('success', 'Item created successfully.');
    } catch (\Exception $e) {
      \DB::rollBack();
      return $this->helper->responseJson('fail', trans('api.auth_failed'), 422, null);
    }
  }



  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Item  $item
   */
  public function show($item)
  {
    $item = Item::withoutGlobalScope(new ItemScope)->findOrFail($item);

    $added_ingredients = $item->Addingredients()->get();
    $remove_ingredients = $item->Removeingredients()->get();


    $gifts = $item->gifts()->get();
    $sizes = $item->sizes()->get();
    $services = $item->services()->get();
    $preferences = $item->preferences()->get();
    $options = $item->options()->get();
    $sides = $item->sides()->get();
    return view("content.itempoint.show", compact("item", "sides", "options", "preferences", "services", "sizes", "gifts", "added_ingredients", "remove_ingredients"));
  }

    public function edit($itempoint)
    {
      $item = Item::withoutGlobalScope(new ItemScope)->findOrFail($itempoint);


      return view("content.itempoint.update", compact("item"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(updateItempointRequest $request, $itempoint)
    {

      $item = Item::withoutGlobalScope(new ItemScope)->findOrFail($itempoint);


      $item->points = $request->point;


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

      return redirect()->route('itempoints.index')->with('success', 'Item has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
