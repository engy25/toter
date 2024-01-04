<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\{SimpleItemResource, SearchHistoryResource};
use Illuminate\Http\Request;
use App\Models\{Item, SearchHistory};
use App\Http\Requests\Api\User\{SearchRequest,SearchHistoryRequest};
use App\Helpers\Helpers;
use App\Models\Scopes\ItemScope;
class SearchHistoryController extends Controller
{


  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }



  public function filter(SearchRequest $request)
  {
    $items = Item::WithoutGlobalScope(new ItemScope)->when($request->keyword, function ($q) use ($request) {
      $q->whereTranslationLike("name", '%' . $request->keyword . '%')
      ->orWhereTranslationLike("description" ,'%' . $request->keyword . '%');
      if(auth('api')->check())
      {

          auth('api')->user()->searchHistories()->updateOrCreate(['keyword' => $request->keyword , 'user_id' => auth('api')->user()->id],['keyword' => $request->keyword , 'user_id' => auth('api')->user()->id]);

      }

    })->when($request->max_price,function($q) use ($request){
       // Use the accessor to get the calculated price
       $q->whereRaw('(price + (added_value / 100) * price) <= ?', [$request->max_price]);
    })
    ->When($request->min_price && $request->max_price ,function($q) use ($request){
      $q->where(function($q) use ($request){
        $q->whereBetween('price',[$request->min_price,$request->max_price]);
      });
    })->when($request->subsection_id,function ($q) use ($request){
      $q->where("subsection_id",$request->subsection_id);

    })->when($request->tag_id,function ($q) use ($request){
      $q->where("category_id",$request->tag_id);
    })
    ->when($request->rate, function ($q) use ($request){
      $q->where("avg_rating",'<=', $request->rate)->orderBy("avg_rating", "desc");
    })
    ->latest()->paginate(PAGINATION_COUNT);

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
