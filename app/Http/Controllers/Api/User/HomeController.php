<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\SubSectionResource;
use App\Models\Subsection;
use Illuminate\Http\Request;
use App\Models\{User, Tier, Offer, Section, Store};
use App\Http\Resources\Api\User\{HomeResource, TierResource, OfferResource, SectionResource, MainOfferResource, SimpleStoreResource};
use App\Helpers\Helpers;

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
          $offersData = MainOfferResource::collection($discounts)->map(function ($offer) use ($subsectionName) {
            return [
              'name' => $subsectionName . ' - ' . $offer->name,
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

}
