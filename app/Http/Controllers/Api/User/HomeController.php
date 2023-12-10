<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\SubSectionResource;
use App\Models\Subsection;
use App\Models\SubsectionTranslation;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\RequestOfferType;
use App\Models\{User, Tier, Offer, Section, Store};
use App\Http\Resources\Api\User\{HomeResource, TierResource, OfferResource, SectionResource, MainOfferResource, SimpleStoreResource};
use App\Helpers\Helpers;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }



  /**tier of user ->if auth */
  /**offers */
  /**sections */
  /**nearest */
  /**subsections */
  /**the items that have offers */


  public function index(Request $request)
  {
    $response = [];

    // Check if the user has given permission to the location
    if ($request->hasHeader('lat') && $request->hasHeader('lng')) {

      // Check authentication
      if (auth('api')->check()) {
        $user = auth('api')->user()->with('tier')->first();
        $tier = Tier::find($user->tier_id);
        $response['tier'] = TierResource::make($tier);
      }

      // Offers created recently
      $recentOffers = Offer::valid()->whereNull("item_id")->latest('created_at')->take(5)->get();
      if ($recentOffers->isNotEmpty()) {
        $response['Offers'] = OfferResource::collection($recentOffers);
      }

      // Sections with surrounded stores
      $surroundedSections = Section::SectionsWithSurroundedStores($request->header("lat"), $request->header("lng"));
      $sections = $surroundedSections->take(8)->get();


      if ($sections->isNotEmpty()) {
        $response['sections'] = SectionResource::collection($sections);
        $surroundedSectionIds = $surroundedSections->pluck('id')->toArray();
        $response['sub_sections'] = SubSectionResource::collection(Subsection::Valid()->whereIn('section_id', $surroundedSectionIds)->take(15)->get());
      }

      // Offers in sections that are in the surrounded area
      $subsection_have_offers = Subsection::whereHas('offers')->whereIn("section_id", $surroundedSections->pluck('id')->toArray())->with('translations')->get();
      $discountCategories = $subsection_have_offers->pluck('name', 'id')->toArray();

      // Iterate through offer categories to display all offers with the subsection
      foreach ($discountCategories as $key => $subsectionName) {
        $discounts = Offer::valid()->where("subsection_id", $key)->latest()->take(10)->get();

        if ($discounts->count() > 0) {
          $highestDiscount = $discounts->sortByDesc('discount_percentage')->first();
          $offersData = MainOfferResource::collection($discounts)->map(function ($offer) use ($subsectionName, $highestDiscount) {
            $offerName = ($offer->id === $highestDiscount->id) ? $offer->name : $highestDiscount->name;
            return [
              'name' => $subsectionName . ' _ ' . $offerName,
              'details' => new MainOfferResource($offer),
            ];
          });

          $response[$offersData[0]['name']] = MainOfferResource::collection($discounts);
        }
      }

      $response['nearest_stores'] = SimpleStoreResource::collection(Store::nearest($request->lat, $request->lng)->take(10)->get());

      return $this->helper->responseJson('success', trans('api.auth_data_retreive_success'), 200, (object) ["home" => (object) $response]);
    }
  }


  /***section 50 %percent */
  /***section  New the stores that created fro the last 3 months ago */

  public function indexStores(Request $request, $type)
  {
    if ($type == "new") {
      $offer_store_ids = Offer::valid()->where("discount_percentage", 50)->pluck("store_id")->toArray();
      $stores = Store::whereIn("id", $offer_store_ids)->paginate(10);

      return $this->helper->responseJson('success', trans('api.auth_data_retreive_success'), 200, ['up_to_50' => SimpleStoreResource::collection($stores)->response()->getData(true)]);

    } elseif ($type == "up_to_50") {
      $stores = Store::Surrounded($request->lat, $request->lng)->where("created_at", '>=', Carbon::now()->subMonths(3))->paginate(10);

      return $this->helper->responseJson('success', trans('api.auth_data_retreive_success'), 200, ['new' => SimpleStoreResource::collection($stores)->response()->getData(true)]);

    }

  }



  /**
   * Display THe offer pagination of the subsection depends on subsectionname
   */




  public function indexOfferType(RequestOfferType $request)
  {
    $requestedType = $request->subsection_name;

    $subsectionId = SubsectionTranslation::
      where('name', $requestedType)
      ->pluck("sub_section_id");

    $subsectionName = $requestedType;

    $discounts = Offer::valid()->where("subsection_id", $subsectionId)->paginate(15);

    if ($discounts->count() > 0) {

      $highestDiscount = $discounts->sortByDesc('discount_percentage')->first();
      $offersData = MainOfferResource::collection($discounts)->map(function ($offer) use ($subsectionId, $subsectionName, $highestDiscount) {
        $offerName = ($offer->id === $highestDiscount->id) ? $offer->name : $highestDiscount->name;

        return [
          'name' => $subsectionName . ' - ' . $offerName,
          'details' => new MainOfferResource($offer),
        ];

      });

      return $this->helper->responseJson(
        'success',
        trans('api.auth_data_retreive_success'),
        200,
        [$offersData[0]['name'] => MainOfferResource::collection($discounts)->response()->getData(true)]
      );

    }
  }

















}
