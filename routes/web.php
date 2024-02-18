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

// Main Page Route
// Route::get('/', $controller_path . '\dashboard\Analytics@index')->name('dashboard-analytics');
//Route::get('/dashboard/analytics', $controller_path . '\dashboard\Analytics@index')->name('dashboard-analytics');
// Route::get('/dashboard/crm', $controller_path . '\dashboard\Crm@index')->name('dashboard-crm');
// Route::get('/dashboard/ecommerce', $controller_path . '\dashboard\Ecommerce@index')->name('dashboard-ecommerce');

// // locale
// Route::get('lang/{locale}', $controller_path . '\language\LanguageController@swap');

// // layout
// Route::get('/layouts/collapsed-menu', $controller_path . '\layouts\CollapsedMenu@index')->name('layouts-collapsed-menu');
// Route::get('/layouts/content-navbar', $controller_path . '\layouts\ContentNavbar@index')->name('layouts-content-navbar');
// Route::get('/layouts/content-nav-sidebar', $controller_path . '\layouts\ContentNavSidebar@index')->name('layouts-content-nav-sidebar');

// // Route::get('/layouts/horizontal', $controller_path . '\layouts\Horizontal@index')->name('dashboard-analytics');
// // Route::get('/layouts/vertical', $controller_path . '\layouts\Vertical@index')->name('dashboard-analytics');
// Route::get('/layouts/without-menu', $controller_path . '\layouts\WithoutMenu@index')->name('layouts-without-menu');
// Route::get('/layouts/without-navbar', $controller_path . '\layouts\WithoutNavbar@index')->name('layouts-without-navbar');
// Route::get('/layouts/fluid', $controller_path . '\layouts\Fluid@index')->name('layouts-fluid');
// Route::get('/layouts/container', $controller_path . '\layouts\Container@index')->name('layouts-container');
// Route::get('/layouts/blank', $controller_path . '\layouts\Blank@index')->name('layouts-blank');

// // apps
// Route::get('/app/email', $controller_path . '\apps\Email@index')->name('app-email');
// // Route::get('/app/chat', $controller_path . '\apps\Chat@index')->name('app-chat');
// // Route::get('/app/calendar', $controller_path . '\apps\Calendar@index')->name('app-calendar');
// Route::get('/app/kanban', $controller_path . '\apps\Kanban@index')->name('app-kanban');
// Route::get('/app/invoice/list', $controller_path . '\apps\InvoiceList@index')->name('app-invoice-list');
// Route::get('/app/invoice/preview', $controller_path . '\apps\InvoicePreview@index')->name('app-invoice-preview');
// Route::get('/app/invoice/print', $controller_path . '\apps\InvoicePrint@index')->name('app-invoice-print');
// Route::get('/app/invoice/edit', $controller_path . '\apps\InvoiceEdit@index')->name('app-invoice-edit');
// Route::get('/app/invoice/add', $controller_path . '\apps\InvoiceAdd@index')->name('app-invoice-add');
// Route::get('/app/user/list', $controller_path . '\apps\UserList@index')->name('app-user-list');
// Route::get('/app/user/view/account', $controller_path . '\apps\UserViewAccount@index')->name('app-user-view-account');
// Route::get('/app/user/view/security', $controller_path . '\apps\UserViewSecurity@index')->name('app-user-view-security');
// Route::get('/app/user/view/billing', $controller_path . '\apps\UserViewBilling@index')->name('app-user-view-billing');
// Route::get('/app/user/view/notifications', $controller_path . '\apps\UserViewNotifications@index')->name('app-user-view-notifications');
// Route::get('/app/user/view/connections', $controller_path . '\apps\UserViewConnections@index')->name('app-user-view-connections');
// Route::get('/app/access-roles', $controller_path . '\apps\AccessRoles@index')->name('app-access-roles');
// Route::get('/app/access-permission', $controller_path . '\apps\AccessPermission@index')->name('app-access-permission');

// // pages
// Route::get('/pages/profile-user', $controller_path . '\pages\UserProfile@index')->name('pages-profile-user');
// Route::get('/pages/profile-teams', $controller_path . '\pages\UserTeams@index')->name('pages-profile-teams');
// Route::get('/pages/profile-projects', $controller_path . '\pages\UserProjects@index')->name('pages-profile-projects');
// Route::get('/pages/profile-connections', $controller_path . '\pages\UserConnections@index')->name('pages-profile-connections');
// Route::get('/pages/account-settings-account', $controller_path . '\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
// Route::get('/pages/account-settings-security', $controller_path . '\pages\AccountSettingsSecurity@index')->name('pages-account-settings-security');
// Route::get('/pages/account-settings-billing', $controller_path . '\pages\AccountSettingsBilling@index')->name('pages-account-settings-billing');
// Route::get('/pages/account-settings-notifications', $controller_path . '\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
// Route::get('/pages/account-settings-connections', $controller_path . '\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
// Route::get('/pages/faq', $controller_path . '\pages\Faq@index')->name('pages-faq');
// Route::get('/pages/help-center-landing', $controller_path . '\pages\HelpCenterLanding@index')->name('pages-help-center-landing');
// Route::get('/pages/help-center-categories', $controller_path . '\pages\HelpCenterCategories@index')->name('pages-help-center-categories');
// Route::get('/pages/help-center-article', $controller_path . '\pages\HelpCenterArticle@index')->name('pages-help-center-article');
// Route::get('/pages/pricing', $controller_path . '\pages\Pricing@index')->name('pages-pricing');

// Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
// Route::get('/pages/misc-under-maintenance', $controller_path . '\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');
// Route::get('/pages/misc-comingsoon', $controller_path . '\pages\MiscComingSoon@index')->name('pages-misc-comingsoon');
// Route::get('/pages/misc-not-authorized', $controller_path . '\pages\MiscNotAuthorized@index')->name('pages-misc-not-authorized');

// Route::get('/ui/pagination-breadcrumbs', $controller_path . '\user_interface\PaginationBreadcrumbs@index')->name('ui-pagination-breadcrumbs');
// Route::get('/ui/progress', $controller_path . '\user_interface\Progress@index')->name('ui-progress');
// Route::get('/ui/spinners', $controller_path . '\user_interface\Spinners@index')->name('ui-spinners');
// Route::get('/ui/tabs-pills', $controller_path . '\user_interface\TabsPills@index')->name('ui-tabs-pills');
// Route::get('/ui/toasts', $controller_path . '\user_interface\Toasts@index')->name('ui-toasts');
// Route::get('/ui/tooltips-popovers', $controller_path . '\user_interface\TooltipsPopovers@index')->name('ui-tooltips-popovers');
// Route::get('/ui/typography', $controller_path . '\user_interface\Typography@index')->name('ui-typography');

// extended ui
// Route::get('/extended/ui-avatar', $controller_path . '\extended_ui\Avatar@index')->name('extended-ui-avatar');
// Route::get('/extended/ui-blockui', $controller_path . '\extended_ui\BlockUI@index')->name('extended-ui-blockui');
// Route::get('/extended/ui-drag-and-drop', $controller_path . '\extended_ui\DragAndDrop@index')->name('extended-ui-drag-and-drop');
// Route::get('/extended/ui-media-player', $controller_path . '\extended_ui\MediaPlayer@index')->name('extended-ui-media-player');
// Route::get('/extended/ui-perfect-scrollbar', $controller_path . '\extended_ui\PerfectScrollbar@index')->name('extended-ui-perfect-scrollbar');
// Route::get('/extended/ui-star-ratings', $controller_path . '\extended_ui\StarRatings@index')->name('extended-ui-star-ratings');
// Route::get('/extended/ui-sweetalert2', $controller_path . '\extended_ui\SweetAlert@index')->name('extended-ui-sweetalert2');
// Route::get('/extended/ui-text-divider', $controller_path . '\extended_ui\TextDivider@index')->name('extended-ui-text-divider');
// Route::get('/extended/ui-timeline-basic', $controller_path . '\extended_ui\TimelineBasic@index')->name('extended-ui-timeline-basic');
// Route::get('/extended/ui-timeline-fullscreen', $controller_path . '\extended_ui\TimelineFullscreen@index')->name('extended-ui-timeline-fullscreen');
// Route::get('/extended/ui-tour', $controller_path . '\extended_ui\Tour@index')->name('extended-ui-tour');
// Route::get('/extended/ui-treeview', $controller_path . '\extended_ui\Treeview@index')->name('extended-ui-treeview');
// Route::get('/extended/ui-misc', $controller_path . '\extended_ui\Misc@index')->name('extended-ui-misc');

// icons
// Route::get('/icons/tabler', $controller_path . '\icons\Tabler@index')->name('icons-tabler');
// Route::get('/icons/font-awesome', $controller_path . '\icons\FontAwesome@index')->name('icons-font-awesome');

// // form elements
// Route::get('/forms/basic-inputs', $controller_path . '\form_elements\BasicInput@index')->name('forms-basic-inputs');
// Route::get('/forms/input-groups', $controller_path . '\form_elements\InputGroups@index')->name('forms-input-groups');
// Route::get('/forms/custom-options', $controller_path . '\form_elements\CustomOptions@index')->name('forms-custom-options');
// Route::get('/forms/editors', $controller_path . '\form_elements\Editors@index')->name('forms-editors');
// Route::get('/forms/file-upload', $controller_path . '\form_elements\FileUpload@index')->name('forms-file-upload');
// Route::get('/forms/pickers', $controller_path . '\form_elements\Picker@index')->name('forms-pickers');
// Route::get('/forms/selects', $controller_path . '\form_elements\Selects@index')->name('forms-selects');
// Route::get('/forms/sliders', $controller_path . '\form_elements\Sliders@index')->name('forms-sliders');
// Route::get('/forms/switches', $controller_path . '\form_elements\Switches@index')->name('forms-switches');
// Route::get('/forms/extras', $controller_path . '\form_elements\Extras@index')->name('forms-extras');

// // form layouts
// Route::get('/form/layouts-vertical', $controller_path . '\form_layouts\VerticalForm@index')->name('form-layouts-vertical');
// Route::get('/form/layouts-horizontal', $controller_path . '\form_layouts\HorizontalForm@index')->name('form-layouts-horizontal');
// Route::get('/form/layouts-sticky', $controller_path . '\form_layouts\StickyActions@index')->name('form-layouts-sticky');

// // form wizards
// Route::get('/form/wizard-numbered', $controller_path . '\form_wizard\Numbered@index')->name('form-wizard-numbered');
// Route::get('/form/wizard-icons', $controller_path . '\form_wizard\Icons@index')->name('form-wizard-icons');
// Route::get('/form/validation', $controller_path . '\form_validation\Validation@index')->name('form-validation');

// // tables
// Route::get('/tables/basic', $controller_path . '\tables\Basic@index')->name('tables-basic');
// Route::get('/tables/datatables-basic', $controller_path . '\tables\DatatableBasic@index')->name('tables-datatables-basic');
// Route::get('/tables/datatables-advanced', $controller_path . '\tables\DatatableAdvanced@index')->name('tables-datatables-advanced');
// Route::get('/tables/datatables-extensions', $controller_path . '\tables\DatatableExtensions@index')->name('tables-datatables-extensions');

// // charts
// Route::get('/charts/apex', $controller_path . '\charts\ApexCharts@index')->name('charts-apex');
// Route::get('/charts/chartjs', $controller_path . '\charts\ChartJs@index')->name('charts-chartjs');

// maps
// Route::get('/maps/leaflet', $controller_path . '\maps\Leaflet@index')->name('maps-leaflet');

// // laravel example
// Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('laravel-example-user-management');
// Route::resource('/user-list', UserManagement::class);


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


