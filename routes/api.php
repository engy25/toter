<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
  AuthController,

  User\CountryController,
  User\ProfileController,
  User\AddressController,
  User\TierController,
  User\ButlerController,
  User\HomeController,
  User\SectionController,
  User\OfferController,
  User\SubSectionController,
  User\StoreController,
  User\ReviewController,
  User\ItemController,
  User\SearchHistoryController,
  User\OderButlerController,
  User\OderController,
  User\PointUserController,
  User\CartController,
  User\CityController,
  User\FavouriteController,
  User\NotificationController

};
use App\Http\Controllers\Api\Delivery\AuthController as AuthDeliveryController;

use App\Http\Controllers\Api\Delivery\HomeDeliveryController;

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



      ///push notification
      Route::post("push-subscribe", [NotificationController::class, "pushSubscribe"]);


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

      /***Delivery Login */

      Route::post('delivery-login', [AuthDeliveryController::class, 'deliveryLogin']);



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

      /**
       * cities
       */
      Route::get('get-cities/{storeId?}', [CityController::class, 'index']);



      Route::get('home', [HomeController::class, 'index']);
      /***new and up_to_50 section  pagination in home */
      Route::get('indexStores/{type}', [HomeController::class, 'indexStores']);

      /**offer of home pagination */
      Route::get('index-offer-type', [HomeController::class, 'indexOfferType']);
      /**offers */
      // Route::get('indexOffers/{id}/{tag_id?}', [OfferController::class, 'indexOffers']);
      Route::get('indexOffers/{name}', [OfferController::class, 'indexOffers']);

      Route::get("offer-all", [OfferController::class, "index"]);

      Route::get('offer', [OfferController::class, 'show']);
      /** */

      Route::get('sections', [SectionController::class, 'index']);
      Route::get('sections/{id}', [SectionController::class, 'show']);

      /***subsection */

      /**1 displat store when put id of subsection */

      Route::get('subsection-store/{id}', [SubSectionController::class, 'showStore']);

      /**store */
      Route::get('store/{id}/{tag_id?}', [StoreController::class, 'show']);

      Route::get("store-areas", [StoreController::class, "showStoreAreas"]);

      /**Nearest Store */
      Route::get('nearest-store', [StoreController::class, 'nearestStore']);

      /**review */
      Route::get('review', [ReviewController::class, "show"]);

      /**fav */
      Route::get('favourites/{sort}', [FavouriteController::class, "index"]);
      Route::post('add-item-to-favourites/{id}', [FavouriteController::class, 'addItemToFavorite']);
      Route::post('add-store-to-favourites/{id}', [FavouriteController::class, 'addStoreToFavorite']);
      /**itm details */
      Route::get('item', [ItemController::class, "show"]);

      /**serch history */
      Route::get("filter", [SearchHistoryController::class, "filter"]);







    });




Route::
    namespace('Api')->middleware(['setLocale'])->group(function () {


      Route::middleware(['checkUser'])->group(function () {

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
        Route::post('delete-address/{address}', [AddressController::class, 'destroy']);
        Route::post('update-address/{id}', [AddressController::class, 'update']);
        Route::get('address/{address_id}', [AddressController::class, 'show']);

        /**Tier */
        Route::get('tier', [TierController::class, 'index']);


        /**Butler */
        Route::get('butler', [ButlerController::class, 'index']);

        /**review */
        Route::post('add-review', [ReviewController::class, "add"]);



        /**point  user */
        Route::get("point-user-history", [PointUserController::class, "show"]);

        /**recent Searches */


        Route::get('recent-search', [SearchHistoryController::class, "recentSearches"]);
        Route::post('recent-searches/delete', [SearchHistoryController::class, 'deleteSearches']);
        Route::post('recent-searches/destroy/{searchId}', [SearchHistoryController::class, 'destroy']);
        Route::post('store-search', [SearchHistoryController::class, 'store']);

        /**apply coupon */
        Route::post("apply-coupon", [OderButlerController::class, "applyCoupon"]);

        /**
         * Add To Cart
         */
        Route::post("add-to-cart", [CartController::class, "store"]);
        Route::get('get-cart', [CartController::class, 'getCart']);
        Route::post('update-cart_qty', [CartController::class, 'updateCartQty']);

        /**make order */

        Route::post('make-butler-order', [OderButlerController::class, "store"]);
        Route::post('make-order', [OderController::class, "store"]);
        Route::get('get-orders', [OderController::class, 'getOrders']);
        Route::get('order-details', [OderController::class, 'orderDetails']);
        Route::post('cancel-order', [OderController::class, "cancelOrder"]);

        Route::post('apply-offer', [OfferController::class, "applyOffer"]);

        /**track Order */
        Route::get('track-order', [OderController::class, "trackOrder"]);

        /**Notifications */

        Route::get("h", [NotificationController::class, "index"]);



        ///notification get all notification

        Route::get("notifications", [NotificationController::class, "getNotifications"]);
        Route::get("showNotifications/{id}", [NotificationController::class, "show"]);
        Route::post("delete-notification/{id}", [NotificationController::class, "destroy"]);
        Route::get("count-notifications", [NotificationController::class, "countNotifications"]);


      });



    });

/**
 * Delivery
 */
Route::
    namespace('Api')->middleware(['setLocale'])->group(function () {


      Route::middleware(['checkDelivery'])->group(function () {

        Route::get('delivery-home', [HomeDeliveryController::class, "index"]);
        Route::get('delivery-home-show-all', [HomeDeliveryController::class, "indexHomeShow"]);
        Route::get('delivery-order-details', [HomeDeliveryController::class, "orderDetails"]);


        Route::post('delivery-accept-order', [HomeDeliveryController::class, "acceptOrder"]);
        Route::post('delivery-cancel-order', [HomeDeliveryController::class, "cancelOrder"]);

        /** delivery update the order */
        Route::post('delivery-update-location', [HomeDeliveryController::class, "updateLocation"]);




      });

    });
