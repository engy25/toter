<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Offer, Item, Store, Tier, OfferTranslation};
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Scopes\ItemScope;
use App\Http\Requests\dash\DE\OfferStoreRequest;
use App\Helpers\Helpers;

class OfferController extends Controller
{

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function searchOffer(Request $request)
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $searchString = '%' . $request->search_string . '%';

    $offers = Offer::where(function ($query) use ($searchString) {
      // Assuming discount_percentage is a numeric field, use appropriate numerical comparisons
      $query->whereHas('store.translations', function ($subQuery) use ($searchString) {
        $subQuery->where('name', 'like', $searchString);
      })->orWhereHas('translations', function ($subQuery) use ($searchString) {
        $subQuery->where('name', 'like', $searchString)
          ->orWhere('description', 'like', $searchString)
          ->orWhere('title', 'like', $searchString);
      })->orWhere('discount_percentage', 'like', $searchString);
    })
      ->with([
        'store' => function ($query) {
          $query->select('id');
        },
        'translations' => function ($query) use ($locale) {
          $query->select('offer_id', 'name')->where("locale", $locale);
        },
      ])
      ->latest()
      ->paginate(PAGINATION_COUNT);

    if ($offers->count() > 0) {
      // Return the search results as HTML
      return view("content.offer.pagination_index", compact("offers"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }


















  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   *
   */


  public function index()
  {
    $locale = LaravelLocalization::getCurrentLocale();

    $offers = Offer::
      with([
        'store' => function ($query) use ($locale) {
          $query->select('id');
        },
        // 'item' => function ($query) use ($locale) {
        //   $query->select('id');

        // },
        'translations' => function ($query) use ($locale) {
          $query->select('offer_id', 'name')->where('locale', $locale);

        },
      ])
      ->latest()->paginate(PAGINATION_COUNT);



    return view("content.offer.index", compact("offers"));
  }


  public function paginationOffer(Request $request)
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $offers = Offer::

      with([
        'store' => function ($query) use ($locale) {
          $query->select('id');
        },
        'translations' => function ($query) use ($locale) {
          $query->select('offer_id', 'name')->where('locale', $locale);

        },
      ])
      ->latest()->paginate(PAGINATION_COUNT);

    return view("content.offer.pagination_index", compact("offers"))->render();

  }




  public function create()
  {
    $stores = Store::all();
    $tiers = Tier::all();
    return view("content.offer.create", compact('stores', "tiers"));
  }

  private function storeTranslations(Offer $offer, Request $request)
  {
    $locales = ['en', 'ar'];

    foreach ($locales as $locale) {
      OfferTranslation::create([
        'name' => $request->get("name_$locale"),
        'description' => $request->get("description_$locale"),
        'title' => $request->get("title_$locale"),
        'offer_id' => $offer->id,
        'locale' => $locale,
      ]);
    }
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */


  public function store(OfferStoreRequest $request)
  {
    \DB::beginTransaction();

    try {
      $storeId = $request->input('store_id');
      $store = Store::findOrFail($storeId);


      $offer = new Offer;
      $offer->fill([
        'subsection_id' => $store->sub_section_id,
        'store_id' => $storeId,
        'tier_id' => $request->tier_id,
        'discount_percentage' => $request->discount_percentage,
        'min_price' => $request->min_price,
        'saveup_price' => $request->saveup_price,
        'order_counts' => $request->order_counts,
        'required_points' => $request->required_points,
        'earned_points' => $request->earned_points,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date,
        'free_delivery'=>$request->featured

      ]);

      // Handle image upload
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagePath = $this->helper->upload_single_file($image, 'app/public/images/offers/');
        $offer->image = $imagePath;
      }

      $offer->save();

      // Create translations with the Offer ID
      $this->storeTranslations($offer, $request);


      \DB::commit();

      return redirect()->route('offers.index')->with('success', 'Offer created successfully.');
    } catch (\Exception $e) {
      \DB::rollBack();
      return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
  }
  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Offer  $offer
   * @return \Illuminate\Http\Response
   */

  public function show(Offer $offer)
  {
    return view("content.offer.show", compact("offer"));
  }




  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Offer  $offer
   * @return \Illuminate\Http\Response
   */
  public function edit(Offer $offer)
  {
    //
    $stores = Store::all();
    $tiers = Tier::all();
    return view("content.offer.update", compact('stores', "tiers", "offer"));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Offer  $offer
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $offer)
  {
    \DB::beginTransaction();

    try {
      $offer = Offer::findOrFail($offer);

      $storeId = $request->input('store_id');
      $store = Store::findOrFail($storeId);

      $offer->fill([
        'tier_id' => $request->tier_id,
        'store_id' => $storeId,
        'subsection_id' => $store->sub_section_id,
        'discount_percentage' => $request->discount_percentage,
        'min_price' => $request->min_price,
        'saveup_price' => $request->saveup_price,
        'order_counts' => $request->order_counts,
        'required_points' => $request->required_points,
        'earned_points' => $request->earned_points,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date,
        'free_delivery' => $request->featured
      ]);

      // Handle image update
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagePath = $this->helper->upload_single_file($image, 'app/public/images/offers/');
        $offer->image = $imagePath;
      }

      $offer->save();

      // Update translations with the Offer ID
      $offerTranslation_en = $offer->translate("en");
      $offerTranslation_en->name = $request->name_en;
      $offerTranslation_en->title = $request->title_en;
      $offerTranslation_en->description = $request->description_en;
      $offerTranslation_en->save();

      $offerTranslation_ar = $offer->translate("ar");
      $offerTranslation_ar->name = $request->name_ar;
      $offerTranslation_ar->title = $request->title_ar;
      $offerTranslation_ar->description = $request->description_ar;
      $offerTranslation_ar->save();
      \DB::commit();

      return redirect()->route('offers.index')->with('success', 'Offer Updated successfully.');
    } catch (\Exception $e) {
      \DB::rollBack();
      return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Offer  $offer
   * @return \Illuminate\Http\Response
   */
  public function destroy($offer)
  {
    $theOffer = Offer::findOrFail($offer);

     $theOffer->points()->delete();

    $theOffer->translations()->delete();
    $theOffer->delete();


    return response()->json(['status' => true, 'msg' => "Offer Deleted Successfully"]);
  }

  public function displayItems($store_id)
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $items = Item::withoutGlobalScope(new ItemScope)->
      with([
        'store',
        'translations' => function ($query) use ($locale) {
          $query->where('locale', $locale);
        },
      ])
      ->where("store_id", $store_id)->where("has_offer", 1)
      ->latest()->paginate(2);



    return view("content.item.index", compact("items"));

  }
}
