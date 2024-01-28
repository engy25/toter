<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Subsection, Store};
use App\Http\Resources\Api\User\SimpleStoreResource;
use App\Helpers\Helpers;

class SubSectionController extends Controller
{

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }

  public function showStore($id)
  {
    $store_of_subsection = Store::where("sub_section_id", $id)->paginate(10);
    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      ["stores" => SimpleStoreResource::collection($store_of_subsection)->response()->getData(true)]
    );

  }
}
