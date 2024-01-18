<?php

namespace App\Http\Controllers\dashboard\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\{Order, User, Role, Status, Currency};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class OrderUserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $role = Role::where("name", "Delivery")->first();
    $deliveries = User::where("role_id", $role->id)->get();

    $statuses = Status::all();

    $orders = Order::with(["orderItems", "offer", "coupon"])->latest()->paginate(PAGINATION_COUNT);
    $dailyOrders = Order::whereDate("created_at", Carbon::today())->count();
    $monthlyOrders = Order::whereMonth('created_at', Carbon::now()->month)->count();
    $yearOrders = Order::whereYear('created_at', Carbon::now()->year)->count();

    $daily_sales = Order::whereDate("created_at", Carbon::today())->sum("total");
    $monthly_sales = Order::whereMonth("created_at", Carbon::now()->month)->sum("total");
    $defaultCurrency = Currency::where("default", 1)->first();

    return view("content.orderusers.index", compact("orders", "deliveries", "statuses", "monthlyOrders", "dailyOrders", "yearOrders", "daily_sales", "monthly_sales", "defaultCurrency"));
  }




  /**paginate the users */
  public function paginationOrderUser(Request $request)
  {
    $defaultCurrency = Currency::where("default", 1)->first();
    $orders = Order::with(["orderItems", "offer", "coupon"])->latest()->paginate(PAGINATION_COUNT);

    return view("content.orderusers.pagination_index", compact("orders", "defaultCurrency"))->render();

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

    $orders = Order::when($request->search_string, function ($q) use ($searchString) {
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

      return view("content.orderusers.pagination_index", compact("orders", "defaultCurrency"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }

  public function export()
  {
    try {
      $role = Role::where("name", "Delivery")->first();
      $deliveries = User::where("role_id", $role->id)->get();
      $dailyOrders = Order::whereDate("created_at", Carbon::today())->count();
      $monthlyOrders = Order::whereMonth('created_at', Carbon::now()->month)->count();
      $yearOrders = Order::whereYear('created_at', Carbon::now()->year)->count();
      $daily_sales = Order::whereDate("created_at", Carbon::today())->sum("total");
      $monthly_sales = Order::whereMonth("created_at", Carbon::now()->month)->sum("total");

      $orders = Order::with(["orderItems", "offer", "coupon"])->latest()->get();
      $defaultCurrency = Currency::where("default", 1)->first();

      $html = View::make(
        'content.orders.orderPdf',
        compact(
          'orders',
          'defaultCurrency',
          'deliveries',
          'monthlyOrders',
          'dailyOrders',
          'yearOrders',
          'daily_sales',
          'monthly_sales'
        )
      )->render();

      // Create a new Dompdf instance
      $dompdf = new Dompdf();
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      return $dompdf->stream('orderUser.pdf');
    } catch (\Exception $e) {
      dd($e->getMessage());
    }
  }


















  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function show(Order $order)
  {
    //
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
}
