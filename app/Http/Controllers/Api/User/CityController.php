<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\{CityResource,CitiesResource};
use Illuminate\Http\Request;
use App\Models\{City, CountryTranslation,Store};
use App\Helpers\Helpers;

class CityController extends Controller
{
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();

  }
  //Display All Cities That Belong To Iraq With Its Districts
  public function index($storeId=null)
  {
    $country = CountryTranslation::where("name", "Iraq")->first();


    if($storeId==null)
    {

      $cities = City::whereHas("districts")->where("country_id", $country->country_id)->with(["districts"])->get();
      return $this->helper->responseJson('success',trans('api.auth_data_retreive_success'),200,["Cities"=>CityResource::collection($cities)]);

    }
    
    $store=Store::with('districts')->find($storeId);
    if (!$store) {
      return $this->helper->responseJson('failed', trans('api.store_not_found'), 404, null);
    }

    $cities = City::where("country_id",$country->country_id)->with(["districts.stores"])->
    whereHas("districts.stores",function($q) use ($storeId){
      $q->where("store_id",$storeId);

    })->get();



    return $this->helper->responseJson('success',trans('api.auth_data_retreive_success'),200,["Cities"=>CitiesResource::collection($cities)]);


  }

}
