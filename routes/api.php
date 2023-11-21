<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
  AuthController,

  User\CountryController,
  User\ProfileController,
  User\AddressController,


};
use App\Http\Middleware\CheckRoleScopeMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::
    namespace('Api')->middleware('setLocale')->group(function () {

      /**
       * Authentication
       *
       */

      /**
       *
       *1:user
       */

      /**1: Register */
      Route::post('user-register', [AuthController::class, 'register']);



      /**2:Confirm the phone  */
      Route::post('confirm-code', [AuthController::class, 'confirmCode'])
        ->missing(function (Request $request) {
          return response()->json(['result' => 'failed', 'message' => trans('api.auth_something_went_wrong'), 'status' => 422, 'data' => null, (int) 422]);
        });

      /**3: User Login  By phone*/
      Route::post('user-login', [AuthController::class, 'userLogin']);
      /**3: User Login  By Social*/
      /**social in flutter */
      Route::post('user-login-social', [AuthController::class, 'userSocialLogin']);
              /**social in laravel */
      Route::get('social/login', [AuthController::class, 'socialLogin']);

      /**Resend otp again */
      Route::post('resend-otp', [AuthController::class, 'resendOtp']);



      /**
       * Forger Password
       * */
      /** 1:Send Code To Phone */
      Route::post('send-code', [AuthController::class, 'sendCode']);
      /** 2:Check Code  */
      Route::post('check-code', [AuthController::class, 'checkCode']);
      /**
       *3: Reset Password
       */
      Route::post('reset-password', [AuthController::class, 'resetPassword']);

      /**
       * country
       */

      Route::get('get-country', [CountryController::class, 'index']);




    });




Route::
    namespace('Api')->middleware(['setLocale'])->group(function () {


      Route::middleware('checkUser')->group(function () {

        /**update profile by image or fullname */
        Route::post("update-profile", [ProfileController::class, "updateProfile"]);

        /**
         * update phone
         *
         */
        /**send otp to phone */
        Route::post('send-otp-to-check-phone', [ProfileController::class, 'sendOtpToCheckPhone']);
        /**update phone */
        Route::post('update-phone', [ProfileController::class, 'updatePhone']);

        /**
         * Edit Password
         */
        Route::post('edit-password', [ProfileController::class, 'editPassword']);

        /**Display Profile */
        Route::get('show-profile', [ProfileController::class, 'ShowProfile']);

        /**Delete Account  */

        Route::post('delete-account', [ProfileController::class, 'deleteAccount']);


        /**logout */
        Route::post('logout', [AuthController::class, 'logout']);

        /** Address */

        Route::post('address', [AddressController::class, 'store']);
        Route::get('get-addresses', [AddressController::class, 'getAddresses']);
        Route::post('delete-address/{id}', [AddressController::class, 'destroy']);
        Route::post('update-address/{id}', [AddressController::class, 'update']);
        Route::get('address/{address_id}', [AddressController::class, 'show']);


      });



    });
