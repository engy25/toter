<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\{SimpleItemResource, SearchHistoryResource};
use Illuminate\Http\Request;
use App\Models\{Item, SearchHistory};
use App\Http\Requests\Api\User\{SearchRequest,SearchHistoryRequest};
use App\Helpers\Helpers;

class SearchHistoryController extends Controller
{


  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }



  public function filter(SearchRequest $request)
  {
    $items = Item::when($request->keyword, function ($q) use ($request) {
      $q->whereTranslationLike("name", '%' . $request->keyword . '%');


    })->latest()->paginate(10);

    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      ["items" => SimpleItemResource::collection($items)->response()->getData(true)]
    );

  }

  public function recentSearches()
  {
    $searches = SearchHistory::where('user_id', auth('api')->id())
      ->latest()->take(10)->get()->unique('keyword');
    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      ["search" => SearchHistoryResource::collection($searches)->response()->getData(true)]
    );

  }


  public function deleteSearches()
  {

    auth('api')->user()->searchHistories()->delete();

    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      null
    );
  }
  public function destroy($searchId)
  {
    $search = SearchHistory::whereId($searchId)->where("user_id",auth('api')->user()->id)->first();

    if (!$search) {
      return $this->helper->responseJson('failed', trans('api.not_found'), 404, null);
    }
    $search->delete();
    return $this->helper->responseJson('success',trans('api.data_deleted_successfully'),200,null);
  }




  public function store(SearchHistoryRequest $request)
  {
    auth('api')->user()->searchHistories()->updateOrCreate(['keyword' => $request->keyword, 'user_id' => auth('api')->id()], ['keyword' => $request->keyword, 'user_id' => auth('api')->id()]);
    return $this->helper->responseJson(
      'success',
      trans('api.auth_data_retreive_success'),
      200,
      null
    );

  }


}
