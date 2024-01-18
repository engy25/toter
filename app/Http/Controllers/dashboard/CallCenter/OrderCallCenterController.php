<?php

namespace App\Http\Controllers\dashboard\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\{Order, Role, User, Currency, OrderCallcenter, Status};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class OrderCallCenterController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  /**
   * Display a listing of the resource.
   *
   */
  public function index()
  {
    $role = Role::where("name", "Delivery")->first();
    $deliveries = User::where("role_id", $role->id)->get();

    $statuses = Status::all();

    $orders = OrderCallcenter::with(["orderItems"])->latest()->paginate(PAGINATION_COUNT);
    $dailyOrders = OrderCallcenter::whereDate("created_at", Carbon::today())->count();
    $monthlyOrders = OrderCallcenter::whereMonth('created_at', Carbon::now()->month)->count();
    $yearOrders = OrderCallcenter::whereYear('created_at', Carbon::now()->year)->count();

    $daily_sales = OrderCallcenter::whereDate("created_at", Carbon::today())->sum("total");
    $monthly_sales = OrderCallcenter::whereMonth("created_at", Carbon::now()->month)->sum("total");
    $defaultCurrency = Currency::where("default", 1)->first();

    return view("content.orders.index", compact("orders", "deliveries", "statuses", "monthlyOrders", "dailyOrders", "yearOrders", "daily_sales", "monthly_sales", "defaultCurrency"));
  }

  /**paginate the users */
  public function paginationOrderCallCenter(Request $request)
  {
    $defaultCurrency = Currency::where("default", 1)->first();
    $orders = OrderCallcenter::with(["orderItems"])->latest()->paginate(PAGINATION_COUNT);

    return view("content.orders.pagination_index", compact("orders", "defaultCurrency"))->render();

  }

  public function export()
  {
    try {
      $role = Role::where("name", "Delivery")->first();
      $deliveries = User::where("role_id", $role->id)->get();
      $dailyOrders = OrderCallcenter::whereDate("created_at", Carbon::today())->count();
      $monthlyOrders = OrderCallcenter::whereMonth('created_at', Carbon::now()->month)->count();
      $yearOrders = OrderCallcenter::whereYear('created_at', Carbon::now()->year)->count();
      $daily_sales = OrderCallcenter::whereDate("created_at", Carbon::today())->sum("total");
      $monthly_sales = OrderCallcenter::whereMonth("created_at", Carbon::now()->month)->sum("total");

      $orders = OrderCallcenter::with(["orderItems"])->latest()->get();
      $defaultCurrency = Currency::where("default", 1)->first();

      $html = View::make('content.orders.orderPdf', compact(
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

      return $dompdf->stream('sample.pdf');
    } catch (\Exception $e) {
      dd($e->getMessage());
    }
  }




  /**
   * search for user
   */
  public function searchUser(Request $request)
  {
    $searchString = '%' . $request->search_string . '%';
    $role = $request->role;
    $status = $request->status;

    $users = User::when($request->search_string, function ($q) use ($searchString) {
      $q->where("fname", 'like', $searchString)
        ->orWhere('email', 'like', $searchString)
        ->orWhere('phone', 'like', $searchString);
    })->when($request->role, function ($q) use ($role) {
      $q->where("role_id", $role);
    })->when($request->status, function ($q) use ($status) {
      $q->where("is_active", $status);
    })->latest()->paginate(PAGINATION_COUNT);

    if ($users->count() > 0) {
      return view("content.Alluser.pagination_index", compact("users"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
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

    $orders = OrderCallcenter::when($request->search_string, function ($q) use ($searchString) {
      $q->where("sub_total", 'like', $searchString)
        ->orWhere('total', 'like', $searchString)
        ->orWhere('delivery_charge', 'like', $searchString)
        ->orWhere('order_number', 'like', $searchString);

    })->when($request->deliveryId, function ($q) use ($deliveryId) {
      $q->where("delivery_id", $deliveryId);

    })->when($request->date, function ($q) use ($date) {
      // Use whereDate to filter based on the date part only
      $q->whereDate("created_at", $date);

    })->when($request->status, function ($q) use ($status) {
      $q->where("status_id", $status);

    })->latest()->paginate(PAGINATION_COUNT);

    if ($orders->count() > 0) {

      return view("content.orders.pagination_index", compact("orders", "defaultCurrency"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
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
