<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Butler, ButlerTranslation};
use App\Helpers\Helpers;
use App\Http\Resources\Api\User\{ButlerResource};

class ButlerController extends Controller
{


  public $helper;

  public function __construct()
  {
    $this->helper = new Helpers();

  }

  /**
   * Display the butler to make the order
   */
  public function index()
  {

    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      ["butlers" => ButlerResource::collection(Butler::cursor())]
    );

  }

}
