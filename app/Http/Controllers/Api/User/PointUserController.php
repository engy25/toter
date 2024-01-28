<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\{PointUser,OfferUser};
use Illuminate\Http\Request;
use App\Helpers\Helpers;

class PointUserController extends Controller
{


  public $helper;

  public function __construct()
  {
    $this->helper = new Helpers();

  }

  public function show(Request $request)
  {
    $user = auth("api")->user();

    $scores=[];
    if($request->elkol){
      $scores=PointUser::where("user_id", $user->id)->get();
    }
    if($request->earned){
      $scores=PointUser::where("user_id", $user->id)->where('expired_at','>',date('Y-m-d'))->get();
    }


      return $this->helper->responseJson(
        'success',
        trans('api.auth_data_retreive_success'),
        200,[
          "scores" => ScoreResource::collection($scores),
        ]

      );

    }





  }

