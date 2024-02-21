<?php

namespace App\Http\Controllers\dashboard\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\{User, Order, Status, Currency};
use Carbon\Carbon;

class OrderRestaurantController extends Controller
{
  public function index()
  {
    $role = Role::findByName("Restaurant", "web");
    $roleDelivery = Role::findByName("Delivery", "api");
    $deliveries = User::where("role_id", $roleDelivery->id)->get();

    $statuses = Status::all();

    $orders = Order::with(["orderItems", "offer", "coupon"])->where("store_id", auth()->user()->store_id)->latest()->paginate(PAGINATION_COUNT);
    $dailyOrders = Order::whereDate("created_at", Carbon::today())->where("store_id", auth()->user()->store_id)->count();
    $monthlyOrders = Order::whereMonth('created_at', Carbon::now()->month)->where("store_id", auth()->user()->store_id)->count();
    $yearOrders = Order::whereYear('created_at', Carbon::now()->year)->where("store_id", auth()->user()->store_id)->count();

    $daily_sales = Order::whereDate("created_at", Carbon::today())->where("store_id", auth()->user()->store_id)->sum("total");
    $monthly_sales = Order::whereMonth("created_at", Carbon::now()->month)->where("store_id", auth()->user()->store_id)->sum("total");
    $defaultCurrency = Currency::where("default", 1)->first();

    return view("content.orderusersrestaurant.index", compact("orders", "deliveries", "statuses", "monthlyOrders", "dailyOrders", "yearOrders", "daily_sales", "monthly_sales", "defaultCurrency"));
  }



  /**paginate the orders */
  public function paginationOrderStore(Request $request)
  {
    $defaultCurrency = Currency::where("default", 1)->first();
    $orders = Order::with(["orderItems", "offer", "coupon"])->where("store_id", auth()->user()->store_id)->latest()->paginate(PAGINATION_COUNT);

    return view("content.orderusersrestaurant.pagination_index", compact("orders", "defaultCurrency"))->render();

  }


  /**
   * search for Order
   */
  public function searchOrder(Request $request)
  {
    $defaultCurrency = Currency::where("default", 1)->first();
    $searchString = '%' . $request->search_string . '%';
    $deliveryId = $request->deliveryId;
    $date = $request->date;
    $status = $request->status;

    $orders = Order::where("store_id", auth()->user()->store_id)->when($request->search_string, function ($q) use ($searchString) {
      $q->where("sub_total", 'like', $searchString)
        ->orWhere('total', 'like', $searchString)
        ->orWhere('delivery_charge', 'like', $searchString)
        ->orWhere('order_number', 'like', $searchString);

    })->when($request->deliveryId, function ($q) use ($deliveryId) {
      $q->where("driver_id", $deliveryId);

    })->when($request->date, function ($q) use ($date) {
      // Use whereDate to filter based on the date part only
      $q->whereDate("created_at", $date);

    })->when($request->status, function ($q) use ($status) {
      $q->where("status_id", $status);

    })->latest()->paginate(PAGINATION_COUNT);

    if ($orders->count() > 0) {

      return view("content.orderusersrestaurant.pagination_index", compact("orders", "defaultCurrency"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }

  public function create()
  {
    // Show the form to create a new order
  }

  public function store(Request $request)
  {
    // Validate and store the new order
  }

  public function show($storeorders)
  {
    $defaultCurrency = Currency::where("default", 1)->first();

    $order=Order::with(["orderItems", "offer", "coupon"])->find($storeorders);
   

    return view("content.orderusersrestaurant.show", compact("order", "defaultCurrency"));
  }

  public function edit($id)
  {
    // Show the form to edit a specific order
  }

  public function update(Request $request, $id)
  {
    // Validate and update the order
  }

  public function destroy($id)
  {
    // Delete a specific order
  }

  public function showMapOfTheOrder(Order $order)
  {

    $order = Order::with('deliveryTrack')->find($order->id);


    return view("content.orderusersrestaurant.showMap", compact("order"));
  }

}
