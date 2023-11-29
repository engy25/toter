<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Subsection;
use Illuminate\Http\Request;
use App\Models\{Section, Store};
use App\Http\Resources\Api\User\{SectionResource, SimpleStoreResource, SubSectionResource};
use App\Helpers\Helpers;

class SectionController extends Controller
{
  //
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }
  public function index(Request $request)
  {
    //  All Sections with surrounded stores
    $surroundedSections = Section::SectionsWithSurroundedStores($request->header("lat"), $request->header("lng"))->get();
    return $this->helper->responseJson('success', trans('api.auth_data_retreive_success'), 200, ['sections' => SectionResource::collection($surroundedSections)]);
  }

  public function show($id, Request $request)
  {
    $section = Section::valid()->where("id", $id)->get();

    $subsections = Subsection::valid()->where("section_id", $id)->get();

    $response = [];

    $response["stores"] = SimpleStoreResource::collection(Store::Surrounded($request->lat, $request->lng)->where("section_id", $id)->get());

    $response["sub_sections"] = SubSectionResource::collection($subsections);

    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      (object) ['response' => (object) $response]
    );
  }

}
