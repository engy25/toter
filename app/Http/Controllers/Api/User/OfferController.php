<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\{OfferRequest,RequestOfferPointType};
use App\Helpers\Helpers;
use App\Models\{Offer, Store, StoreCategory, Item, Subsection, Section, PointUser, OfferUser};
use App\Http\Resources\Api\User\{StoreResource, CategoryResource, SimpleItemResource, MainOfferResource, OfferResource};

class OfferController extends Controller
{
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }


  public function show(Request $request)
  {
    $offer = Offer::valid()->find($request->offer_id);

    if (!$offer) {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        404,
        null
      );
    }

    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      ["offer" => OfferResource::make($offer)]
    );
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
        'id' => $offer->id,

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

  /**
   * in point user make
   */
  public function applyOffer(OfferRequest $request)
  {
    $user = auth("api")->user();

    $offer = Offer::valid()->find($request->offer_id);
    if (!$offer) {
      return $this->helper->responseJson(
        'failed',
        trans('api.not_found'),
        422,
        null
      );

    }
    if ($offer->tier_id == 2 && $user->tier_id == 1) {

      return $this->helper->responseJson(
        'failed',
        trans('api.msg_reward'),
        422,
        [trans('api.reward_golden_tier') => trans('api.msg_reward')]
      );

    }
    if ($offer->required_points > $user->userPoints()) {
      return $this->helper->responseJson(
        'failed',
        trans('api.msg_point'),
        422,
        null
      );
    }
    $points = OfferUser::where("user_id", $user->id)->where("offer_id", $offer->id)->first();

    /**check the user have the offer ? */
    if ($points) {
      return $this->helper->responseJson(
        'failed',
        trans('api.alreadyaplliedoffer'),
        422,
        null
      );
    }

    OfferUser::create([
      "user_id" => $user->id,
      "offer_id" => $offer->id,
      "order_count_of_user" => $offer->order_counts,
      "expire_at" => $offer->to_date,
      "point_earned" =>0,
      "free_delivery" => $offer->free_delivery
    ]);

    return $this->helper->responseJson('succcess', trans('api.offer_applied_success'), 200, null);





  }


  public function index(RequestOfferPointType $request)
  {
    $discount =[];


    if($request->type=="wadah"){

      $key='Discounts On Fresh';
      $discount=Offer::valid()->whereNull("item_id")->where("store_id", 3)->latest()->paginate(15);


    }elseif($request->type=="discount"){

      $key='Discounts and offers';
      $discount=Offer::valid()->whereNull("item_id")->where("store_id","!=",3)->latest()->paginate(15);
    }

    return $this->helper->responseJson('success', trans('api.auth_data_retreive_success'), 200, [$key => OfferResource::collection($discount)->response()->getData(true)]);



  }





}
