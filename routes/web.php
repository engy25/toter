<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Web\{
  DashboardController,
  StatusController,
  AdminController,
  AboutController,
  PrivacyController,

};

use App\Http\Controllers\dashboard\Restaurant\{
  OrderRestaurantController
  ,
  RestaurantUsersController,
  OrderCallcenterRestaurantController


};

use App\Http\Controllers\dashboard\CallCenter\{
  TraditionalUserController,
  OrderController,
  OrderCallCenterController,
  OrderUserController,
  OrderButlerController

};
use App\Http\Controllers\dashboard\Admin\{
  RolePermissionController,
  UserController,
  AllUserController,
  NotificationController

};
use App\Http\Controllers\dashboard\DataEntry\{

  CityController,
  CountryController,
  CurrencyController,
  SubSectionController,
  SectionController,
  StoreController,
  OfferController,
  ItemController,
  ItempointsideController,
  ItemPointController,
  IngredientController,
  ItempointServiceController,
  ItempointPreferenceController,
  IngredientpointController,
  ItempointsizeController,
  AddonController,
  DrinkController,
  SideController,
  SizeController,
  GiftController,
  OptionController,
  ItempointOptionController,
  PreferenceController,
  ServiceController,
  DistrictController,
  TagController,
  WeekhourController,
  AddController,
  StoreDistrictController,
  ItemDrinkController,
  ItemSideController,
  ItemSizeController,
  ItemGiftController,
  ItemServiceController,
  ItemPreferenceController,
  ItemOptionController,
  DeliveryController,
  CouponController,
  RoleController,
  PermissionController,
  CompanyDistrictController
};

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
$controller_path = 'App\Http\Controllers';


/**
 * Route Associated to Contrller
 */


Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::group(
  [
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
  ],
  function () {
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/


    /**
     * home
     */
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    /*--------------------------------------------------------------- */


    Route::get('/dashboard', function () {
      return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');


    /******************************Restaurant *****************************************************/
    Route::Resource("storeorders", OrderRestaurantController::class);
    Route::get("/pagination/paginate-orderstore", [OrderRestaurantController::class, "paginationOrderStore"]);
    Route::get('/search-orderstore', [OrderRestaurantController::class, 'searchOrder'])->name('search.order.store');
    Route::get('/track-order/{order}', [OrderRestaurantController::class, 'showMapOfTheOrder'])->name('create.track.order');


    Route::Resource("storeorderscallcenters", OrderCallcenterRestaurantController::class);
    Route::get("/pagination/paginate-ordercallcenterstore", [OrderCallcenterRestaurantController::class, "paginationOrderStore"]);
    Route::get('/search-ordercallcenterstore', [OrderCallcenterRestaurantController::class, 'searchOrder'])->name('search.ordercallcenter.store');
    Route::get('/track-ordercallcenter/{order}', [OrderCallcenterRestaurantController::class, 'showMapOfTheOrder'])->name('create.track.ordercallcenter');






    /********************Add Users To Restaurants************************************************* */
    Route::Resource('restaurantusers', RestaurantUsersController::class);
    Route::get("/pagination/paginate-restaurantuser", [RestaurantUsersController::class, "paginationUser"]);
    Route::get('/search-restaurantuser', [RestaurantUsersController::class, 'searchUser'])->name('search.restaurantuser');


    /******************************DATA ENTRY AND ADMIN *****************************************************/


    // Route::group(['middleware' => ['role:DataEntry|Admin']], function () {


    Route::get('/admin/notifications/fetch', [NotificationController::class, 'fetch'])->name("display.notification");

    /******************Roles **************************/
    Route::Resource('roles', RoleController::class);
    Route::get("/pagination/paginate-role", [RoleController::class, "paginationRole"]);
    Route::get('/search-role', [RoleController::class, 'searchRole'])->name('search.role');
    /*------------------------------------------------------- */


    /************** Permissions**********/
    Route::Resource('permissions', PermissionController::class);
    Route::get("/pagination/paginate-permission", [PermissionController::class, "paginationPermission"]);
    Route::get('/search-permission', [PermissionController::class, 'searchPermission'])->name('search.permission');
    /*------------------------------------------------------------------------- */


    /*** Role Permission to admin*/
    Route::get('rolePermissions/{roleId}/create', [RolePermissionController::class, "create"])->name('rolePermissions.create');
    Route::post('rolePermissions/{roleId}/store', [RolePermissionController::class, "store"])->name('rolePermissions.store');
    /*------------------------------------------------------------------------- */

    /*******************Cities *****************/
    Route::Resource('cities', CityController::class);
    Route::get("/pagination/paginate-city", [CityController::class, "paginationCity"]);
    Route::get('/search-city', [CityController::class, 'searchCity'])->name('search.city');
    /*------------------------------------------------------------------------- */


    /***************************Countries ************************/
    Route::Resource('countries', CountryController::class);
    Route::get("/pagination/paginate-country", [CountryController::class, "paginationCountry"]);
    Route::get('/search-country', [CountryController::class, 'searchCountry'])->name('search.country');
    Route::get('countries-display', [CountryController::class, "countryIndex"])->name("countries.display");
    /*------------------------------------------------------------------------- */





    /********************subsections************************************************* */
    Route::Resource('subsections', SubSectionController::class);
    Route::get("/pagination/paginate-subsection", [SubSectionController::class, "paginationSubsection"]);
    Route::get('/search-subsections', [SubSectionController::class, 'searchSubsection'])->name('search.subsection');
    Route::get('sections-display', [SectionController::class, "sectionIndex"])->name("sections.display");
    /*------------------------------------------------------------------------- */






    /********************stores************************************************* */
    Route::Resource('stores', StoreController::class);
    /***fetch cities  */
    Route::get('get-cities', [StoreController::class, 'getCities'])->name("getCities");
    Route::get('/getSubSections/{sectionId}', [StoreController::class, 'getSubSections'])->name('getSubSections');
    Route::get('cities/districts/{cityId}', [StoreController::class, 'getDistricts'])->name("getDistricts");
    Route::get('store-items/{store_id}', [StoreController::class, "displayItems"])->name('store.items');
    Route::get("/pagination/paginate-storeItem/{store_id}", [StoreController::class, "paginationItem"]);
    Route::get("/pagination/paginate-store", [StoreController::class, "paginationStore"]);
    Route::get('/search-stores', [StoreController::class, 'searchStore'])->name('search.store');
    /*------------------------------------------------------------------------- */




    /********************currencies************************************************* */
    Route::get('currencies-display', [CurrencyController::class, "currencyIndex"])->name("currencies.display");
    /*------------------------------------------------------------------------- */



    /********************storedistricts************************************************* */
    Route::Resource('storedistricts', StoreDistrictController::class);
    /*------------------------------------------------------------------------- */



    /********************Company districts************************************************* */
    Route::Resource('companydistricts', CompanyDistrictController::class);
    Route::get("/pagination/paginate-companydisctrict", [CompanyDistrictController::class, "paginationCompanyDisctrict"]);
    Route::get('/search-companydisctrict', [CompanyDistrictController::class, 'searchCompanyDisctrict'])->name('search.companydisctrict');
    Route::get('city-district/{city_id}', [CompanyDistrictController::class, "displayDistricts"])->name('city.districts');
    /*------------------------------------------------------------------------- */


    /********************offers************************************************* */
    Route::Resource('offers', OfferController::class);
    Route::get("/pagination/paginate-offers", [OfferController::class, "paginationOffer"]);
    Route::get('/search-offers', [OfferController::class, 'searchOffer'])->name('search.offer');
    Route::get('offer-items/{store_id}', [OfferController::class, "displayItems"])->name('offer.items');
    /*------------------------------------------------------------------------- */


    /********************coupons************************************************* */
    Route::Resource('coupons', CouponController::class);
    Route::post('add-coupon-to-store', [CouponController::class, "addCouponToStore"])->name("add.coupon.store");
    Route::put('update-coupon-to-store/{coupon}', [CouponController::class, "updateCouponToStore"])->name("update.coupon.com");
    Route::get("/pagination/paginate-coupon", [CouponController::class, "paginationCoupon"]);
    Route::get('/search-coupon', [CouponController::class, 'searchCoupon'])->name('search.coupon');
    Route::get('stores-display', [CouponController::class, "StoreIndex"])->name("stores.display");
    Route::get('store-items-display/{store_id}', [CouponController::class, "displayItems"])->name('store.items.display');

    /*------------------------------------------------------------------------- */


    /********************items************************************************* */
    Route::Resource('items', ItemController::class);

    Route::get("/pagination/paginate-item", [ItemController::class, "paginationItem"]);
    Route::get('/search-items', [ItemController::class, 'searchItem'])->name('search.item');
    /***display the tags of the  store */
    Route::get('store-tags/{store_id}', [ItemController::class, "displayTags"])->name('store.tags');
    /***display the drinks of the  store */
    Route::get('store-drinks/{store_id}', [ItemController::class, "displayDrinks"])->name('store.drinks');
    /*------------------------------------------------------------------------- */


    /********************item points************************************************* */
    Route::Resource('itempoints', ItemPointController::class);

    Route::get("/pagination/paginate-itempoint", [ItemPointController::class, "paginationItem"]);
    Route::get('/search-itempoints', [ItemController::class, 'searchItem'])->name('search.itempoint');

    /*-------------------------------Ingredients------------------------------------------ */
    Route::Resource('ingredientpoints', IngredientpointController::class);
    /*------------------------------------------------------------------------- */

    /*---------------------------Sides---------------------------------------------- */
    Route::Resource('itempointsides', ItempointsideController::class);
    /*------------------------------------------------------------------------- */

    /*---------------------------------Sizes---------------------------------------- */
    Route::Resource('itempointsizes', ItempointsizeController::class);
    /*------------------------------------------------------------------------- */

    /*--------------------------------Services----------------------------------------- */
    Route::Resource('itempointservices', ItempointServiceController::class);
    /*------------------------------------------------------------------------- */

    /*-----------------------------------Preferences-------------------------------------- */
    Route::Resource('itempointpreferences', ItempointPreferenceController::class);
    /*------------------------------------------------------------------------- */

    /*-----------------------------------Options-------------------------------------- */
    Route::Resource('itempointoptions', ItempointOptionController::class);
    /*------------------------------------------------------------------------- */

    /*------------------------------------------------------------------------- */





    Route::Resource('itemdrinks', ItemDrinkController::class);
    Route::delete('/itemdrink/{item_id}/{drink_id}', [ItemDrinkController::class, "delete"])->name('itemdrinks.delete');
    /*------------------------------------------------------------------------- */

    Route::Resource('itemgifts', ItemGiftController::class);
    /*------------------------------------------------------------------------- */
    Route::Resource('itemsides', ItemSideController::class);
    /*------------------------------------------------------------------------- */
    Route::Resource('itemsizes', ItemSizeController::class);
    /*------------------------------------------------------------------------- */
    Route::Resource('itemservices', ItemServiceController::class);
    /*------------------------------------------------------------------------- */
    Route::Resource('itempreferences', ItemPreferenceController::class);
    /*------------------------------------------------------------------------- */
    Route::Resource('itemoptions', ItemOptionController::class);
    /*------------------------------------------------------------------------- */
    /***display the addons of the  store */
    Route::get('store-addons/{store_id}', [ItemController::class, "displayAddons"])->name('store.addons');
    /*------------------------------------------------------------------------- */
    Route::Resource('ingredients', IngredientController::class);
    /*------------------------------------------------------------------------- */


    /**********************addons ***************/
    Route::Resource('addons', AddonController::class);
    Route::Resource('adds', AddController::class);
    Route::Delete('addon/{addon}/{item}', [AddonController::class, "delete"])->name('addon.delete');
    /*------------------------------------------------------------------------- */



    /**********************Drinks ***************/
    Route::Resource('drinks', DrinkController::class);
    /*------------------------------------------------------------------------- */


    /***********************Tags *****************/
    Route::Resource('tags', TagController::class);
    /*------------------------------------------------------------------------- */

    /******************Sides ******************/
    Route::Resource('sides', SideController::class);
    /*------------------------------------------------------------------------- */


    /***********************Sizes ****************************/
    Route::Resource('sizes', SizeController::class);
    /*------------------------------------------------------------------------- */



    /**************************Gifts *****************************/
    Route::Resource('gifts', GiftController::class);
    /*------------------------------------------------------------------------- */


    /****************************options *********************************/
    Route::Resource('options', OptionController::class);
    /*------------------------------------------------------------------------- */

    /*******************************preferences *****************************/
    Route::Resource('preferences', PreferenceController::class);
    /*------------------------------------------------------------------------- */


    /**********************services ***********************************/
    Route::Resource('services', ServiceController::class);
    /*------------------------------------------------------------------------- */



    /*****************************weekhours *****************************/
    Route::Resource('weekhours', WeekhourController::class);
    Route::get('weekhours/{weekhour}/edit/{day}', [WeekhourController::class, 'customEdit'])->name('weekhours.customEdit');


    /*------------------------------------------------------------------------- */
    /*****************************districts *****************************/
    Route::Resource('districts', DistrictController::class);
    Route::get("/pagination/paginate-district", [DistrictController::class, "paginationDistrict"]);
    Route::get('/search-districts', [DistrictController::class, 'searchDistrict'])->name('search.district');
    Route::get('cities-display', [DistrictController::class, "cityIndex"])->name("cities.display");
    /*------------------------------------------------------------------------- */





    // });



    /**********************************************ADMIN *********************************************************/
    // Route::group(['middleware' => ['role:Admin']], function () {

    /**
     * Users
     */
    Route::Resource('users', UserController::class);
    Route::get('usersList/{roleName}', [UserController::class, "indexUser"])->name('users.list');
    Route::get("/pagination/paginate-user/{roleName}", [UserController::class, "paginationUser"]);
    Route::get('/search-user/{roleName}', [UserController::class, 'searchUser'])->name('search.user');
    /**to display the lists of the permissions depends of the role */
    Route::get('permissionsList/{roleId}', [UserController::class, "displayPermissions"])->name('permissions.list');
    /*------------------------------------------------------------------------- */

    /*******************all users *******************/
    Route::Resource('allusers', AllUserController::class);
    Route::get("/pagination/paginate-alluser", [AllUserController::class, "paginationUser"]);
    Route::get('/search-alluser', [AllUserController::class, 'searchUser'])->name('search.alluser');


    Route::resource('notifications', NotificationController::class)->only('index', 'show', 'store');

    // Route::get('/push-notificaiton', [NotificationController::class, 'index'])->name('push-notificaiton');
    // Route::post('/store-token', [NotificationController::class, 'storeToken'])->name('store.token');
    // Route::post('/send-web-notification', [NotificationController::class, 'sendWebNotification'])->name('send.web-notification');


    Route::get('/get-notificaiton', [NotificationController::class, 'index'])->name('get-notificaitons')->name("notifications.index");



    // });


    // Route::group(['middleware' => ['role:CallCenter|Admin|DataEntry|CallCenter']], function () {



    /******************************Deliveries *****************************/
    Route::Resource('deliveries', DeliveryController::class);
    Route::get('/getDaysNotInSchedule/{deliveryId}', [DeliveryController::class, 'getDaysNotInSchedule'])->name('getDaysNotInSchedule');
    Route::put("deliveryschedules/{deliveryschedule}", [DeliveryController::class, "deliveryScheduleUpdate"])->name('deliveryschedules.update');
    Route::post("deliveryschedules", [DeliveryController::class, "deliveryScheduleStore"])->name('deliveryschedules.store');
    Route::delete("deliveryschedules/{deliveryschedule}", [DeliveryController::class, "deliveryScheduleDestroy"])->name('deliveryschedules.destroy');
    Route::get("/pagination/paginate-delivery", [DeliveryController::class, "paginationDelivery"]);
    Route::get('/search-delivery', [DeliveryController::class, 'searchDelivery'])->name('search.delivery');
    Route::get('/get-days', [DeliveryController::class, 'getDays']);
    /*------------------------------------------------------------------------- */

    /***to add attendance time to each delivery */
    Route::post("add-arrival-time", [DeliveryController::class, "AddArrivalTimeToDelivery"])->name("arrivaltime.store");
    /***to add the daily price of delivery */
    Route::post("add-daily-price-to-delivery", [DeliveryController::class, "AddDailyPriceToDelivery"])->name("dailyprice.delivery.store");
    Route::post("add-incentive-to-delivery", [DeliveryController::class, "AddIncenticeToDelivery"])->name("incentive.delivery.store");
    Route::post("add-discount-to-delivery", [DeliveryController::class, "AddDiscountToDelivery"])->name("discount.delivery.store");
    // });


    /*******************************************Call Center******************************************/
    // Route::group(['middleware' => ['role:CallCenter|Admin']], function () {
    /**
     * the traditional user :the user that doesnot have mobile that doesnot
     *  have account to login we make the account cause he make order by phone
     */
    Route::resource("traditionalusers", TraditionalUserController::class);

    Route::get("/pagination/paginate-traditionaluser", [TraditionalUserController::class, "paginationUser"]);
    Route::get('/search-traditionaluser', [TraditionalUserController::class, 'searchUser'])->name('search.traditionaluser');

    /******************************************************************************************************/

    /*********************************************** Create Orders Belongs To CallCenter*******************************************************/
    Route::get("createStores/{user}", [OrderController::class, "createStores"])->name("createStore.create");
    Route::get('/search-item/{order}', [OrderController::class, 'searchItem'])->name('search.items');
    Route::get("filter-items/{id}", [OrderController::class, "filterItems"])->name("filter.items");
    Route::post("createStores/{user}", [OrderController::class, "storeStores"])->name("createStore.store");

    /**Order CallCenter */
    Route::get("orders/{id}", [OrderController::class, "create"])->name("orders.create");
    Route::post("orders/{id}", [OrderController::class, "store"])->name("orders.store");

    Route::get("order-address/{orderId}", [OrderController::class, "createorderAddress"])->name("order.address.create");
    Route::post("order-address/{orderId}", [OrderController::class, "storeOrderAddress"])->name("order.address.store");


    Route::get("item-details/{id}", [OrderController::class, "itemDetails"])->name("item.details");
    /**system may be filters the orders by date and delivery and sub total and total */
    Route::resource("ordercallcenters", OrderCallCenterController::class);

    Route::get("createorderbutler/{userId}", [OrderCallCenterController::class, "createOrderButler"])->name("create.order.butler");
    Route::post("storeorderbutler/{userId}", [OrderCallCenterController::class, "storeOrderButler"])->name("store.order.butler");

    Route::get("/pagination/paginate-ordercallcenter", [OrderCallCenterController::class, "paginationOrderCallCenter"]);
    Route::get('/search-ordercallcenter', [OrderCallCenterController::class, 'searchOrder'])->name('search.order.callcenter');
    /**export order call center table */
    Route::get('/export-callcenter-pdf', [OrderCallCenterController::class, 'export'])->name('exportcallcenter.pdf');

    /******************************************************************************************************/

    /********************************************Orders User***********************************************/
    Route::resource("orderusers", OrderUserController::class);
    Route::get("/pagination/paginate-orderuser", [OrderUserController::class, "paginationOrderUser"]);
    Route::get('/search-orderuser', [OrderUserController::class, 'searchOrder'])->name('search.order.user');


    /**export order user table */
    Route::get('/export-user-pdf', [OrderUserController::class, 'export'])->name('exportuser.pdf');
    /******************************************************************************************************/

    /****************************************************Order Butlers**************************************************/
    Route::resource("orderbutlers", OrderButlerController::class);
    Route::get("/pagination/paginate-orderbutler", [OrderButlerController::class, "paginationOrderButler"]);
    Route::get('/search-orderbutler', [OrderButlerController::class, 'searchOrder'])->name('search.order.butler');
    Route::get('/track-orderbutler/{order}', [OrderButlerController::class, 'showMapOfTheOrder'])->name('create.track.orderbutler');



    /**export order user table */
    Route::get('/export-butler-pdf', [OrderButlerController::class, 'export'])->name('exportbutler.pdf');

    // });


  }
);






















Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {


  Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboards');
  Route::get('get-dashboard', [DashboardController::class, "index_dashboard"])->name('index.dashboard');






  /**
   * Admin
   */
  Route::resource('admins', AdminController::class);



});






Auth::routes();


