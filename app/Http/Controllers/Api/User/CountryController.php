<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Helpers\Helpers;
use App\Http\Resources\Api\User\CountryResource;
class CountryController extends Controller
{
    public $helper;
    public function __construct(){
        $this->helper= new Helpers();
    }
    public function index()
    {
        $country=Country::all();
        return $this->helper->responseJson('success',trans('api.auth_data_retreive_success'),200,['countries'=>CountryResource::collection($country)]);

    }
}
