<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\{
  User,
  Country,
  Device,

};
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Crypt;
use Laravel\Passport\Token;
use App\Http\Requests\Api\Auth\User\{
  RegisterRequest,
  ConfirmPhoneRequest,
  LoginRequest,
  SocialRequest,
  ResendOtpRequest,
  SendCodeRequest,
  CheckCodeRequest,
  ResetPasswordRequest,
  LogoutRequest,
  RegisterSocialRequest

};

use App\Http\Resources\Api\User\{
  SimpleResource
};

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public $helper;

  public function __construct()
  {
    $this->helper = new Helpers();

  }

  /***
   *
   * Register By Phone But Not Activate Until Confirmation
   */
  public function register(RegisterRequest $request)
  {
    // \DB::beginTransaction();
    // try {

      // $user_data = ['phone', 'country_code', 'fullname', 'password','email_address'];
      // $encrypted_password=$request->password;
      // $encryption_key= config('app.encryption_key');
      // $decrypted_password=Crypt::decrypt(base64_decode($encrypted_password,false));

      $verified_code = 1111 ?? $this->helper->apiCode();
      //$user = User::create(Arr::only($request->validated(), $user_data)+ ['verified_code' => $verified_code,'is_active'=>0,'user_type'=>'Client','role_id'=>1]);
      $country = Country::where("country_code", $request->country_code)->first();

      $user = User::create([
        'phone' => $request->phone,
        'email' => $request->email,
        'country_code' => $request->country_code,
        'fname' => $request->fname,
        'password' => $request->password,
        'otp' => $verified_code,
        'is_active' => 0,
        //'user_type' => 'User',
        'role_id' => 3,
        'tier_id' => 1,

      ]);
      $role = Role::where('name', 'User')->where('guard_name', 'api')->first();

      $user->assignRole($role);

      // if ($request->provider && $request->provider_id) {
      //     $user->providers()->create(['provider' => $request->provider, 'provider_id' => $request->provider_id]);
      // }

      // Send SMS
      // $message = "Your OTP is: $verified_code";
      // sendSMS($user->phone, $message);


      $data = ['id' => $user->id, 'otp' => $verified_code, 'phone' => $user->phone, 'country_code' => $user->country_code, "email" => $user->email];

      \DB::commit();

      return $this->helper->responseJson('success', trans('api.first_step_sign_up'), (int) 200, ['user' => $data]);


    // } catch (\Exception $e) {
    //   \DB::rollBack();
    //   return $this->helper->responseJson('fail', trans('api.auth_failed'), 422, null);

    // }


  }


  /**Confirm the Phone through OTP Sent To You in SMS
   *
   */
  public function confirmCode(ConfirmPhoneRequest $request)
  {
    //DB::beginTransaction();
    // try{

    $user = User::where(['phone' => $request->phone, 'country_code' => $request->country_code, 'otp' => $request->otp])->first();

    if ($user) {
      $user->update(['otp' => null, 'phone_verified_at' => now(), 'is_active' => 1]);
      $user->devices()->firstOrCreate($request->only(['device_token', 'type']));

      $token = $user->createToken('toter')->accessToken;
      $user = SimpleResource::make($user);
      $data = data_set($user, 'token', $token);
      \DB::commit();
      return $this->helper->responseJson('success', trans('api.user_verify_success'), 200, ['user' => $user]);
    } else {
      return $this->helper->responseJson('failed', trans('api.something_went_wrong'), 422, null);
    }
    /*


    }catch(\Exception $e)
    {
    DB::rollBack();
    return $this->helper->responseJson('failed',trans('api.auth_failed'),422,null);

    }
    */


  }

  /***Login By phone */

  public function userLogin(LoginRequest $request)
  {
    // $encrypted_password=$request->password;
    // $encryption_key= config('app.encryption_key');
    // $decrypted_password=Crypt::decrypt(base64_decode($encrypted_password,false));
    $credentials = [
      'phone' => $request->phone,
      'email' => $request->email,
      'password' => $request->password,
      'country_code' => $request->country_code,
      'role_id' => 3,
    ];

    if (!auth()->attempt($credentials)) {
      return $this->helper->responseJson('failed', trans('api.auth_failed'), 422, null);
    }

    $user_data = auth()->user();


    if (!$user_data->is_active) {
      return response()->json([
        'result' => 'failed',
        'message' => trans('api.auth_user_not_active_comp_register'),
        'status' => 403,
        'last_step' => 'verify',
        'data' => [
          'user' => [
            'otp' => (int) $user_data->otp,
            'phone' => $user_data->phone,
            'country_code' => $user_data->country_code,
          ]
        ]
      ], 403);
    } else {
      $user_data->devices()->firstOrCreate($request->only(['device_token', 'type']));
      $token = $user_data->createToken('moawen')->accessToken;
      $user_data->token = $token;
      $user = SimpleResource::make($user_data);
      return $this->helper->responseJson('success', trans('api.user_logged_success'), 200, ['user' => $user]);
    }
  }

  /**Login By Social */
  public function userSocialLogin(SocialRequest $request)
  {

    $user = User::whereHas('providers', function ($query) use ($request) {
      $query->where(['provider' => $request->provider, 'provider_id' => $request->provider_id]);
    })->first();
    if (!$user) {

      return $this->helper->responseJson('failed', trans('api.auth_user_not_registered'), 422, null);

    } elseif ($user->is_active == 0) {

      return response()->json([

        'result' => 'failed',
        'message' => trans('api.auth_user_not_active_comp_register'),
        'status' => 403,
        'last_step' => 'verify',
        'data' => [
          'user' =>
            [
              'otp' => (int) $user->otp,
              'phone' => $user->phone,
              'country_code' => $user->country_code,
            ]
        ]
      ], 403);


    }

    $user->devices()->firstOrCreate($request->only(['type', 'device_token']));
    $token = $user->createToken('moawen', ['user'])->accessToken;
    $data = data_set($user, 'token', $token);
    $user = SimpleResource::make($user);
    return $this->helper->responseJson('success', trans('api.user_logged_success'), 200, ['user' => $user]);


  }


  /***Resend OTP */

  public function resendOtp(ResendOtpRequest $request)
  {
    $user = User::where(['phone' => $request->phone, 'country_code' => $request->country_code])->first();
    if (!$user) {
      return response()->json([

        'result' => 'failed',
        'message' => trans('api.user_not_exist'),
        'status' => 422,
        'data' => null
      ], 422);
    }

    $otp = 1234 ?? $this->helper->apiCode();
    $user->update(['otp' => $otp]);
    $data = ['phone' => $request->phone, 'country_code' => $request->country_code, 'otp' => $user->otp];
    return response()->json([
      'result' => 'success',
      'message' => trans('api.auth_msg_sent_successs'),
      'status' => 200,
      'data' => ['user' => $data]
    ], 200);


  }










  /***Logout */


  public function logout(LogoutRequest $request)
  {

    if (auth('api')->check()) {

      $user_id = auth('api')->user()->id;

      $device = Device::where(["user_id" => $user_id, "type" => $request->type])->first();
      if ($device) {
        $device->delete();
      }
      auth('api')->user()->token()->revoke();

    }

    return $this->helper->responsejson('success', trans('api.auth_logout_success'), 200, null);

  }




  /**
   * Forget Password
   * check phone exists
   */
  public function sendCode(SendCodeRequest $request)
  {


    $user = User::where(['phone' => $request->phone, 'country_code' => $request->country_code])->first();

    if (!$user) {
      return $this->helper->responseJson('failed', trans('api.user_not_exist'), 422, null);
    }

    $reset_code = 1111 ?? $this->helper->apiCode();
    $user->update(['otp' => $reset_code]);
    $data = ['phone' => $user->phone, 'country_code' => $user->country_code, 'otp' => $user->otp];
    return $this->helper->responseJson('success', trans('api.auth_msg_sent_successs'), 200, ['user' => $data]);


  }


  /**
   * 2:Check Code correct Or Not To Send SMS
   */
  public function checkCode(CheckCodeRequest $request)
  {
    $user = User::where(['phone' => $request->phone, 'country_code' => $request->country_code, 'otp' => $request->otp])->first();
    if (!$user) {
      return $this->helper->responseJson('failed', trans('api.user_not_exist'), 422, null);
    }
    $data = ['phone' => $user->phone, 'country_code' => $user->country_code, 'otp' => (int) $user->otp];

    return $this->helper->responseJson('success', trans('api.auth_code_sent_Success'), 200, ['user' => $data]);




  }

  public function resetPassword(ResetPasswordRequest $request)
  {
    $user = User::where(['phone' => $request->phone, 'country_code' => $request->country_code, 'otp' => $request->otp])->first();


    if (!$user) {
      return $this->helper->responseJson('failed', trans('api.user_not_exist'), 422, null);
    }

    $user->update(['password' => $request->password, 'otp' => null, 'is_active' => 1]);


    return $this->helper->responseJson('success', trans('api.auth_password_changed_successfully'), 200, null);
  }


  /**
   * Social Login
   */
  public function socialLogin(RegisterSocialRequest $request)
  {
    $provider = $request->input('provider'); //for multiple providers
    $token = $request->input('access_token');
    // get the provider's user. (In the provider server)
    $providerUser = Socialite::driver($provider)->userFromToken($token);

    $verified_code = 1111 ?? $this->helper->apiCode();

    $user = User::whereHas('providers', function ($query) use ($provider, $providerUser) {
      $query->where('provider_name', $provider)
        ->where('provider_id', $providerUser->id);
    })
      ->first();
    if (!$user) {
      $user = User::create([
        "phone" => $request->phone,
        "country_code" => $request->country_code,
        'otp' => $verified_code,
        'is_active' => 0,
        'role_id' => 3,
        'tier_id' => 1,

      ]);
      $user->providers()->create(["provider" => $provider, "provider_id" => $providerUser->id]);
      $data = ['id' => $user->id, 'otp' => $verified_code, 'phone' => $user->phone, 'country_code' => $user->country_code];
      return $this->helper->responseJson('success', trans('api.first_step_sign_up'), (int) 200, ['user' => $data]);
    } elseif ($user->is_active == 0) {

      return response()->json([

        'result' => 'failed',
        'message' => trans('api.auth_user_not_active_comp_register'),
        'status' => 403,
        'last_step' => 'verify',
        'data' => [
            'user' =>
            [
              'otp' => (int) $user->otp,
              'phone' => $user->phone,
              'country_code' => $user->country_code,
            ]
          ]
      ], 403);


    }

    // Create a token for the user to log in
    $token = $user->createToken(env('APP_NAME'))->accessToken;

    $user->devices()->firstOrCreate($request->only(['type', 'device_token']));
    $token = $user->createToken('toter')->accessToken;
    $data = data_set($user, 'token', $token);
    $user = SimpleResource::make($user);
    return $this->helper->responseJson('success', trans('api.user_logged_success'), 200, ['user' => $user]);




  }






}
