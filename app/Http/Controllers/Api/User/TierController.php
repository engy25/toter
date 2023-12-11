<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\SimpleItemResource;
use App\Models\Scopes\ItemScope;
use Illuminate\Http\Request;
use App\Models\{Tier, Offer,item};
use App\Http\Resources\Api\User\{TierResource, OfferResource};
use App\Helpers\Helpers;

class TierController extends Controller
{


  public $helper;

  public function __construct()
  {
    $this->helper = new Helpers();

  }


/**
 * Display the tier of the user and the offers of foods and Toters Fresh
 */

  public function index()
  {
    $user = auth('api')->user()->with('tier')->first();
    $tier = Tier::find($user->tier_id);

    $response = [
      'tier' => TierResource::make($tier),
      "Items"=>SimpleItemResource::collection(Item::withoutGlobalScope(ItemScope::class)->where("points","!=",0)->latest()->take(10)->get()),
      'Discounts On Fresh' => OfferResource::collection(Offer::valid()->whereNull("item_id")->where("store_id", 3)->latest()->take(10)->get()),
      'Discounts and offers' => OfferResource::collection(Offer::valid()->whereNull("item_id")->where("store_id", 1)->latest()->take(10)->get()),
    ];

    return $this->helper->responseJson('success', trans('api.auth_data_retreive_success'), 200, (object) ["response" => (object) $response]);
  }

  /**pagination
   *
   * 89
  */







}
