<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Offer,Item};
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Scopes\ItemScope;
class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
        ->latest()->paginate(2);



      return view("content.offer.index", compact("offers"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        'store', 'translations' => function ($query) use ($locale) {
          $query->where('locale', $locale);
        },
      ])
      ->where("store_id", $store_id)->where("has_offer",1)
      ->latest()->paginate(2);



    return view("content.item.index", compact("items"));

  }
}
