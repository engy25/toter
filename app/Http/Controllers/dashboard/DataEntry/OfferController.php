<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Offer, Item, Store, Tier};
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Scopes\ItemScope;
use App\Http\Requests\dash\DE\OfferStoreRequest;
class OfferController extends Controller
{


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





  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $stores = Store::all();
    $tiers = Tier::all();
    return view("content.offer.create", compact('stores', "tiers"));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(OfferStoreRequest $request)
  {
    $storeId = $request->input('store_id');
    $store = Store::findOrFail($storeId);


    $offer = new Offer;
    $offer->fill([
      'subsection_id' => $store->sub_section_id,
      'store_id' => $storeId,
      'tier_id'=>$request->tier_id,
      'discount_percentage'=>$request->discount_percentage,
      'min_price'=>$request->min_price,
      'saveup_price'=>$request->saveup_price,
      'order_counts'=>$request->order_counts,
      'required_points'=>$request->required_points,
      'earned_points'=>$request->earned_points,
      'from_date'=>$request->from_date,


    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
      $image = $request->file('image');
      //$imagePath = $this->helper->upload_single_file($image, 'app/public/images/items/');
     // $offer->image = $imagePath;
    }

    $offer->save();

    // Create translations with the Subsection ID
    //$this->storeTranslations($item, $request);

    // Store related models


    \DB::commit();
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
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Offer  $offer
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Offer $offer)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Offer  $offer
   * @return \Illuminate\Http\Response
   */
  public function destroy(Offer $offer)
  {
    //
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
