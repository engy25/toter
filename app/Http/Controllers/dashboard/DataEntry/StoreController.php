<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Store, Item, Offer, StoreTranslation, District, Weekhour, Currency, Section, City, Subsection, Day};
use App\Helpers\Helpers;
use App\Models\CountryTranslation;
use App\Models\StoreCategory;
use App\Models\StoreCategoryTranslation;
use App\Models\StoreDistrict;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Scopes\ItemScope;
use App\Http\Requests\dash\DE\{StoreRequest,UpdateStoreRequest};

class StoreController extends Controller
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



  public function searchStore(Request $request)
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $searchString = '%' . $request->search_string . '%';

    $stores = Store::where(function ($query) use ($searchString) {
      $query->whereHas('section.translations', function ($subQuery) use ($searchString) {
        $subQuery->where('name', 'like', $searchString);
      })->orWhereHas('translations', function ($subQuery) use ($searchString) {
        $subQuery->where('name', 'like', $searchString)
          ->orWhere('description', 'like', $searchString);
      });
    })
      ->with([
        'section' => function ($query) {
          $query->select('id');
        },
        'translations' => function ($query) use ($locale) {
          $query->select('store_id', 'name')->where("locale", $locale);
        },
      ])
      ->latest()
      ->paginate(PAGINATION_COUNT);


    if ($stores->count() > 0) {
      // Return the search results as HTML
      return view("content.store.pagination_index", compact("stores"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }




  public function index()
  {
    $locale = LaravelLocalization::getCurrentLocale();

    $stores = Store::with([
      'section' => function ($query) use ($locale) {
        $query->select('id');
      },
      'sub_section' => function ($query) use ($locale) {
        $query->select('id');

      },
      'translations' => function ($query) use ($locale) {
        $query->select('store_id', 'name')->where('locale', $locale);

      },
    ])
      ->latest()->paginate(PAGINATION_COUNT);



    return view("content.store.index", compact("stores"));
  }


  public function paginationStore(Request $request)
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $stores = Store::with([
      'section' => function ($query) use ($locale) {
        $query->select('id');
      },
      'translations' => function ($query) use ($locale) {
        $query->select('store_id', 'name')->where('locale', $locale);
      },
    ])->latest()->paginate(PAGINATION_COUNT);
    return view("content.store.pagination_index", compact("stores"))->render();

  }




  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $sections = Section::valid()->get();
    $days = Day::get();
    $country_iraq = CountryTranslation::where("name", "Iraq")->first();
    $cities = City::whereHas("districts")->where("country_id", $country_iraq->country_id)->get();
    return view("content.store.create", compact("sections", "days", "cities"));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRequest $request)
  {
    \DB::beginTransaction();
    try {

      $deliveryFees = $request->input('delivery_fees');
      $districts = $request->input('district_id');


      $currency = Currency::where("default", 1)->first();

      $store = new Store;
      $store->section_id = $request->section_id;
      $store->sub_section_id = $request->sub_section_id;
      $store->default_currency_id = $currency->id;
      $store->address = $request->address;
      $store->delivery_time = $request->delivery_time;
      $store->admin_id = auth()->user()->id;
      $store->lat = "33.430439";
      $store->lng = "43.271397";

      // // Handle image upload
      if ($request->hasFile('image')) {

        $image = $request->file('image');
        $imagePath = $this->helper->upload_single_file($image, 'app/public/images/stores/');
        $store->image = $imagePath;
      }

      // Save the store to get the ID
      $store->save();

      // Create translations with the Subsection ID
      StoreTranslation::create(['name' => $request->name_en, 'description' => $request->description_en, 'store_id' => $store->id, 'locale' => 'en']);
      StoreTranslation::create(['name' => $request->name_ar, 'description' => $request->description_ar, 'store_id' => $store->id, 'locale' => 'ar']);

      foreach ($request->weekhours as $dayIndex => $weekHoursData) {
        $dayId = $weekHoursData["day_id"];
        $fromTime = $weekHoursData["from_time"];
        $toTime = $weekHoursData["to_time"];
        // Create a new WeekHour instance
        $weekhour = new WeekHour([
          'store_id' => $store->id,
          'day_id' => $dayId,
          'from' => $fromTime,
          'to' => $toTime,
        ]);
        // Save the weekhour to the database
        $store->weekhours()->save($weekhour);
      }

      if ($request->has("store_categories")) {
        foreach ($request->input('store_categories') as $store_category) {
          //create tags

          $tag = StoreCategory::create([
            "store_id" => $store->id
          ]);
          StoreCategoryTranslation::create(['name' => $store_category["name_en"], 'description' => $store_category["description_en"], 'store_category_id' => $tag->id, 'locale' => 'en']);
          StoreCategoryTranslation::create(['name' => $store_category["name_ar"], 'description' => $store_category["description_ar"], 'store_category_id' => $tag->id, 'locale' => 'ar']);
        }
      }

      if ($request->has('district_id')) {
        foreach ($districts as $key => $districtsId) {
          $deliveryCharge = $deliveryFees[$key];
          $validator = Validator::make(['delivery_charge' => $deliveryCharge], [
            'delivery_charge' => 'required|numeric', // Add more rules as needed
          ]);

          if ($validator->fails()) {
            // Handle validation failure, e.g., redirect back with errors
            return redirect()->back()->withErrors($validator)->withInput();
          } else {
            // Create StoreDistrict only if validation passes
            StoreDistrict::create(["district_id" => $districtsId, "store_id" => $store->id, "delivery_charge" => $deliveryFees[$key]]);
          }
        }
      }


      \DB::commit();

      return redirect()->route('stores.index')->with('success', 'Store created successfully.');


    } catch (\Exception $e) {
      \DB::rollBack();
      return $this->helper->responseJson('fail', trans('api.auth_failed'), 422, null);

    }

  }

  public function getSubSections($sectionId)
  {
    $locale = LaravelLocalization::getCurrentLocale();


    $subSections = SubSection::ValidSection()->where("section_id", $sectionId)->with(["translations" => function ($query) use ($locale) {
      $query->select("sub_section_id", "name")->where("locale", $locale);
    }])->select('id')->get();

    return response()->json($subSections);

  }



  public function getDistricts($cityId)
  {
    $locale = LaravelLocalization::getCurrentLocale();

    $districts = District::where("city_id", $cityId)->with(["translations" => function ($query) use ($locale) {
      $query->select("district_id", "name")->where("locale", $locale);
    }])->select('id')->get();

    return response()->json($districts);
  }





  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Store  $store
   * @return \Illuminate\Http\Response
   */
  public function show(Store $store)
  {

    $weekhours = Weekhour::where("store_id", $store->id)->get();
    $districts = $store->districts()->get();


    return view("content.store.show", compact("store", "weekhours", "districts"));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Store  $store
   * @return \Illuminate\Http\Response
   */
  public function edit(Store $store)
  {
    // You may need to load additional data if required for the edit view
    $sections = Section::valid()->get();
    $days = Day::get();
    $country_iraq = CountryTranslation::where("name", "Iraq")->first();
    $cities = City::whereHas("districts")->where("country_id", $country_iraq->country_id)->get();

    return view("content.store.update", compact("store", "sections", "days", "cities"));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Store  $store
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateStoreRequest $request, Store $store)
  {
    $store->address=$request->address;
    $store->delivery_time=$request->delivery_time;
    $store->section_id=$request->section_id;
    $store->sub_section_id=$request->sub_section_id;

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/stores/');
      $store->image = $imagePath;

    }
    $store->save();

    $storeTranslation_en=$store->translate("en");
    $storeTranslation_en->name=$request->name_en;
    $storeTranslation_en->description=$request->description_en;
    $storeTranslation_en->save();

    $storeTranslation_ar=$store->translate("ar");
    $storeTranslation_ar->name=$request->name_ar;
    $storeTranslation_ar->description=$request->description_ar;
    $storeTranslation_ar->save();
    return redirect()->route('stores.index')->with('success', 'Store has been updated successfully.');

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Store  $store
   * @return \Illuminate\Http\Response
   */

  public function destroy(Store $store)
  {
    try {
      $store->delete();
      return response()->json(['status' => true, 'msg' => "Store Deleted Successfully", "id" => $store->id]);
    } catch (\Exception $e) {
      if ($e->getMessage() === "Cannot delete Store, It is related to other tables") {
        return response()->json(['status' => false, 'msg' => $e->getMessage()], 403);
      }
      return response()->json(['status' => false, 'msg' => "An error occurred while deleting the Store."], 500);
    }
  }

  public function displayItems($store_id)
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $items = Item::withoutGlobalScope(new ItemScope)->
      with([
        'store', 'translations' => function ($query) use ($locale) {
          $query->where('locale', $locale);
        },
      ])
      ->where("store_id", $store_id)
      ->latest()->paginate(2);



    return view("content.item.index", compact("items"));

  }


  public function paginationItem(Request $request, $store_id)
  {
    $locale = LaravelLocalization::getCurrentLocale();

    $items = Item::withoutGlobalScope(new ItemScope)->
      with([
        'store',
        'translations' => function ($query) use ($locale) {
          $query->where('locale', $locale);
        },
      ])
      ->where("store_id", $store_id)
      ->latest()
      ->paginate(2);



    return view("content.item.pagination_index", compact("items"))->render();
  }

  public function getCities()
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $country_iraq = CountryTranslation::where("name", "Iraq")->first();
    $cities = City::whereHas("districts")->where("country_id", $country_iraq->country_id)->
      with([
        'translations' => function ($query) use ($locale) {
          $query->where('locale', $locale);
        },
      ])->
      get();
    return response()->json($cities);
  }

}
