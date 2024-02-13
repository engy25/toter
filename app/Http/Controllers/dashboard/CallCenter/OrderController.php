<?php

namespace App\Http\Controllers\dashboard\CallCenter;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\{Store, User, OrderCallcenter, Address, City, item, Currency, StoreDistrict, OrderStatus, OrderItem};
use App\Models\CityTranslation;
use App\Models\CountryTranslation;
use App\Models\Scopes\ItemScope;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;
use App\Services\StatusService;
use App\Http\Requests\dash\CallCenter\{StoreOrderRequest, StoreOrderAddressRequest};
use App\Traits\OrderTrait;

class OrderController extends Controller
{
  use OrderTrait;
  public $helper;
  public $statusService;
  public function __construct()
  {
    $this->helper = new Helpers();
    $this->statusService = new StatusService();

  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   */

  public function searchItem(Request $request, $order)
  {
    $searchString = '%' . $request->search_string . '%';

    $the_order = OrderCallcenter::whereId($order)->firstOrFail();

    $store = Store::with([
      "items",
      "items.drinks",
      'items.sides',
      'items.gifts',
      'items.Removeingredients',
      'items.Removeingredients',
      'items.services',
      'items.options',
      'items.preferences'
    ])
      ->whereId($the_order->store_id)
      ->where(function ($query) use ($searchString) {
        $query->whereHas('items.translations', function ($subQuery) use ($searchString) {
          $subQuery->where('name', 'like', $searchString)
            ->orWhere("description", 'like', $searchString);
        })->orWhereHas("items", function ($subQuery) use ($searchString) {
          $subQuery->where("price", 'like', $searchString);
        });
      })->firstOrFail();

    if ($store->count() > 0) {
      return view("content.orderCallcenter.partials.search-results", compact("store", "searchString"))->render();
    } else {
      return response()->json(["status" => 'nothing_found']);
    }
  }





  public function createStores(User $user)
  {
    $stores = Store::whereHas("translations")->whereHas("items")->get();

    return view("content.traditionalUser.createStore", compact("stores", "user"));
  }



  public function storeStores(Request $request, User $user)
  {
    \DB::beginTransaction();

    try {


      $validated = $request->validate([
        "store" => "required|exists:stores,id"
      ]);

      $store = Store::firstOrFail();


      $orderCallCenter = new OrderCallcenter([
        'store_id' => $validated["store"],
        'user_id' => $user->id,
        // 'address_id' => $address->id,

      ]);

      $orderCallCenter->save();

      \DB::commit();

      return redirect()->route('orders.create', ['id' => $orderCallCenter->id])->with('success', 'Pleaze Complete The Stage');
    } catch (\Exception $e) {
      // Rollback the transaction in case of an exception
      \DB::rollBack();

      // Log the error
      \Log::error($e->getMessage());

      // Return an error response or handle the exception as needed
      return redirect()->route('traditionalusers.index')->with('error', 'Error creating user and address.');
    }
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */

  public function create(OrderCallcenter $id)
  {
    $searchString = "";

    $store = Store::with([
      'Theitems',
      'Theitems.drinks',
      'Theitems.sides',
      'Theitems.gifts',
      'Theitems.Removeingredients',
      'Theitems.services',
      'Theitems.options',
      'Theitems.preferences',
      'tags',
    ])
      ->where('id', $id->store_id)
      ->firstOrFail();


    return view("content.orderCallcenter.c", compact("id", "store", "searchString"));

  }
  public function store(StoreOrderRequest $request, OrderCallcenter $id)
  {
    \DB::beginTransaction();

    try {

      $subTotal = 0;
      $driver = new User();
      $statusPending = $this->statusService->getStatusIdByName("pending");
      $order = $id;
      $userId = $order->user_id;

      foreach ($request->items as $item) {

        $item = json_decode($item, true);
        if (!$item || !isset($item['id']) || !isset($item['quantity'])) {

          $status = 422;

          return view('content.orderCallcenter.c', compact('status'));

        }

        $orderItem = OrderItem::create([
          'ordereable_id' => $order->id,
          'ordereable_type' => 'App\Models\OrderCallcenter',
          'item_id' => $item['id'],
          'qty' => $item['quantity'],
          // 'notes' => $item['notes'] ?? null,
        ]);

        $itemModel = Item::findOrFail($item['id']);
        $quantity = $item['quantity'];
        $subTotal += $itemModel->price * $quantity;
        $storeId = $itemModel->store_id;

        $driverId = ($driver->assignDriverToOrder($storeId) == null) ? null : $driver->assignDriverToOrder($storeId)->id;
        $store = Store::whereId($storeId)->first();
        $deliveryTime = $store->delivery_time;


      }


      $order->update([
        "sub_total" => $subTotal,
        "delivery_id" => $driverId,
        "delivery_time" => $deliveryTime,

      ]);

      OrderStatus::create([
        "status_id" => $statusPending,
        "ordereable_id" => $order->id,
        "ordereable_type" => "App\Models\OrderCallcenter"
      ]);
      \DB::commit();
      return redirect()->route('order.address.create', ['orderId' => $order->id])->with('success', 'Pleaze Complete The Stage');
    } catch (\Exception $e) {
      // Rollback the transaction in case of an exception
      \DB::rollBack();

      // Log the error
      \Log::error($e->getMessage());

      // Return an error response or handle the exception as needed
      return redirect()->route('traditionalusers.index')->with('error', 'Error creating Order .');
    }
  }

  public function createorderAddress(OrderCallcenter $orderId)
  {
    $countryIraqId = CountryTranslation::where("name", "Iraq")->value("country_id");
    $cities = City::where("country_id", $countryIraqId)->get();
    $orderId = $orderId->id;

    return view("content.orderCallcenter.partials.create_address", compact("cities", "orderId"));
  }



  public function storeOrderAddress(StoreOrderAddressRequest $request, OrderCallcenter $orderId)
  {

    \DB::beginTransaction();

    try {
      $countryIraqId = CountryTranslation::where("name", "Iraq")->value("country_id");
      $cities = City::where("country_id", $countryIraqId)->get();

      $order = $orderId;
      $userId = $order->user_id;
      $user = User::whereId($userId)->first();
      $storeId = $order->store_id;



      //Check if the district ID is associated with the store
      if (!$this->checkDistrictIdAssociatedToTheStore($storeId, $request->district_id)) {

        $orderId = $orderId->id;
        $status = 401;
        return view('content.orderCallcenter.partials.create_address', compact('status', 'cities', 'orderId'));
      }
      $deliveryCharge = StoreDistrict::where("district_id", $request->district_id)->where("store_id", $storeId)->value('delivery_charge');



      $address = Address::create([
        'building' => $request->building,
        'street' => $request->street,
        'apartment' => $request->apartment,
        "user_id" => $userId,
        'instructions' => $request->instructions,
        'district_id' => $request->district_id,
        "phone" => $user->phone,
        "country_code" => $user->country_code,
        'default' => 1
      ]);
      $order->update([
        "address_id" => $address->id,
        "district_id" => $request->district_id,
        "delivery_charge" => $deliveryCharge,
        "total" => $deliveryCharge + $order->sub_total

      ]);
      \DB::commit();
      return view("content.orderCallcenter.show", compact("order"))->with('msg', 'Order Added Successfully');
    } catch (\Exception $e) {
      // Rollback the transaction in case of an exception
      \DB::rollBack();

      // Log the error
      \Log::error($e->getMessage());

      // Return an error response or handle the exception as needed
      return redirect()->route('traditionalusers.index')->with('error', 'Error creating user and address.');
    }
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function show(OrderCallcenter $order)
  {
    return view("content.orderCallcenter.show", compact("order"));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function edit(Order $order)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Order $order)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function destroy(Order $order)
  {
    //
  }

  public function itemDetails($id)
  {
    $item = Item::whereId($id)->first();
    $added_ingredients = $item->Addingredients()->get();
    $remove_ingredients = $item->Removeingredients()->get();
    $addons = $item->addons()->get();
    $drinks = $item->drinks()->get();
    $gifts = $item->gifts()->get();
    $sizes = $item->sizes()->get();
    $services = $item->services()->get();
    $preferences = $item->preferences()->get();
    $options = $item->options()->get();
    $sides = $item->sides()->get();
    return view("content.orderCallcenter.partials.item_details", compact("item", "sides", "options", "preferences", "services", "sizes", "gifts", "added_ingredients", "remove_ingredients", "addons", "drinks"));

  }
  public function filterItems($id)
  {
    $Theitems = Item::with([

      'drinks',
      'sides',
      'gifts',
      'Removeingredients',
      'services',
      'options',
      'preferences',

    ]);


    $searchString = "";

    if ($id != 0) {
      $items = $Theitems->where("category_id", $id)

        ->get();

    }
    $items = $Theitems->get();
    $defaultCurrency = Currency::where("default", 1)->value("isocode");

    return response()->json([$items, $defaultCurrency]);
  }
}
