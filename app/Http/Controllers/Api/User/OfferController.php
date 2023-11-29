<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\{Offer, Store, StoreCategory, Item,Subsection,Section};
use App\Http\Resources\Api\User\{StoreResource, CategoryResource, SimpleItemResource, MainOfferResource};

class OfferController extends Controller
{
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  /**
   * Stores That Have Offers Display Every Thing About Store
   */
  /**
   * popular and reviws
   */
  // public function indexOffers($id, $tag_id = 1)
  // {
  //   $store_id = Offer::valid()->whereId($id)->pluck("store_id")->toArray();

  //   /**store that belongs to this offer */
  //   $stores = Store::where("id", $store_id)->first();

  //   /**items that belongs to this store */
  //   $items = Item::with(["orderItems", "category"])->where("store_id", $id);


  //   /**items_popuar */
  //   $items_popular=$items->get()->filter(function($item){
  //     return $item->status==trans('api.popular');
  //   });

  //   /**items that exist in the store */
  //   $items_belongs_to_tag = $items->where("category_id", $tag_id)->get();


  //   $response = [];
  //   $response['store'] = StoreResource::make($stores);
  //   $response['popular_items'] = SimpleItemResource::collection($items_popular);
  //   $response['items'] = SimpleItemResource::collection($items_belongs_to_tag);



  //   return $this->helper->responseJson(
  //     'success',
  //     trans('api.auth_data_retreive_success'),
  //     200,
  //     (object) ["response" => (object) $response]
  //   );

  // }




  public function indexoffers(Request $request, $name)
  {
    $surroundedSections = Section::SectionsWithSurroundedStores($request->header("lat"), $request->header("lng"));
    $subsection_have_offers = Subsection::whereHas('offers')->whereIn("section_id", $surroundedSections->pluck('id')->toArray())->with('translations')->get();
    $discountCategories = $subsection_have_offers->pluck('name', 'id')->toArray();

      $discounts = Offer::valid()->whereNotNull("item_id")->latest()->get();

      $offersData = MainOfferResource::collection($discounts)->map(function ($offer) use ($name) {
          return [
              'name' => $name . ' - ' . $offer->name,
              'id'=>$offer->id,

              'details' => new MainOfferResource($offer),
          ];
      });

      return $this->helper->responseJson(
          'success',
          trans('api.auth_data_retreive_success'),
          200,
          ["offers" => $offersData]
      );
  }



}
