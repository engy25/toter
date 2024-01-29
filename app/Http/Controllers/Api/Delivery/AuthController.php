<?php

namespace App\Http\Controllers\Api\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\User\{

  LoginRequest};

  use App\Http\Resources\Api\Delivery\{
   SimpleDeliveryResource
  };
use App\Helpers\Helpers;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{


  public $helper;

  public function __construct()
  {
    $this->helper = new Helpers();

  }


    //
  /***Login By phone */

  public function deliveryLogin(LoginRequest $request)
  {

    $roleNameDelivery= Role::findByName('Delivery','api');


    $credentials = [
      'phone' => $request->phone,
      'password' => $request->password,
      'country_code' => $request->country_code,
      'role_id' =>$roleNameDelivery->id ,
    ];

    if (!auth()->attempt($credentials)) {
      return $this->helper->responseJson('failed', trans('api.auth_failed'), 422, null);
    }

    $user_data = auth()->user();


    if (!$user_data->is_active) {
      return response()->json([
        "result"=>'failed',"message"=>trans("api.auth_user_not_active"),"status"=>(int)403,"data"=>null,
    ],403);
    } else {
      $user_data->devices()->firstOrCreate($request->only(['device_token', 'type']));
      $token = $user_data->createToken('elwadah')->accessToken;
      $user_data->token = $token;
      $user = SimpleDeliveryResource::make($user_data);
      return $this->helper->responseJson('success', trans('api.user_logged_success'), 200, ['user' => $user]);
    }
  }
}
