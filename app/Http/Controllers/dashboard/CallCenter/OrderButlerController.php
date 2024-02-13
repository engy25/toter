<?php

namespace App\Http\Controllers\dashboard\CallCenter;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\{OrderButler, User, Role, Status, Currency, OrderCallcenter};
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class OrderButlerController extends Controller
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

    $orders = OrderButler::with(["coupon", "orderItems"])->latest()->paginate(PAGINATION_COUNT);
    $dailyOrders = OrderButler::whereDate("created_at", Carbon::today())->count();
    $monthlyOrders = OrderButler::whereMonth('created_at', Carbon::now()->month)->count();
    $yearOrders = OrderButler::whereYear('created_at', Carbon::now()->year)->count();

    $daily_sales = OrderButler::whereDate("created_at", Carbon::today())->sum("total");
    $monthly_sales = OrderButler::whereMonth("created_at", Carbon::now()->month)->sum("total");
    $defaultCurrency = Currency::where("default", 1)->first();

    return view("content.orderbutlers.index", compact("orders", "deliveries", "statuses", "monthlyOrders", "dailyOrders", "yearOrders", "daily_sales", "monthly_sales", "defaultCurrency"));
  }





  /**paginate the users */
  public function paginationOrderButler(Request $request)
  {
    $defaultCurrency = Currency::where("default", 1)->first();
    $orders = OrderButler::with(["orderItems", "coupon"])->latest()->paginate(PAGINATION_COUNT);

    return view("content.orderbutlers.pagination_index", compact("orders", "defaultCurrency"))->render();

  }



  public function orderbutler(Request $request)
  {
    $defaultCurrency = Currency::where("default", 1)->first();
    $searchString = '%' . $request->search_string . '%';
    $deliveryId = $request->deliveryId;
    $date = $request->date;
    $status = $request->status;

    $orders = OrderButler::when($request->search_string, function ($q) use ($searchString) {
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

      return view("content.orderbutlers.pagination_index", compact("orders", "defaultCurrency"))->render();
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
      $dailyOrders = OrderButler::whereDate("created_at", Carbon::today())->count();
      $monthlyOrders = OrderButler::whereMonth('created_at', Carbon::now()->month)->count();
      $yearOrders = OrderButler::whereYear('created_at', Carbon::now()->year)->count();
      $daily_sales = OrderButler::whereDate("created_at", Carbon::today())->sum("total");
      $monthly_sales = OrderButler::whereMonth("created_at", Carbon::now()->month)->sum("total");

      $orders = OrderButler::with(["orderItems", "coupon"])->latest()->get();
      $defaultCurrency = Currency::where("default", 1)->first();

      $html = View::make(
        'content.orderbutlers.orderPdf',
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

      $mpdf = new \Mpdf\Mpdf();
      $mpdf->WriteHTML($html);

      // Output the PDF to the browser or save it to a file
      $mpdf->Output('order Butlers.pdf', 'D'); // 'D' means download, you can use 'F' to save to a file
      // Create a new Dompdf instance
      // $dompdf = new Dompdf();
      // $dompdf->loadHtml($html);
      // $dompdf->setPaper('A4', 'portrait');
      // $dompdf->render();

      // return $dompdf->stream('order Butlers.pdf');
    } catch (\Exception $e) {
      dd($e->getMessage());
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

    $orders = OrderButler::when($request->search_string, function ($q) use ($searchString) {
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

      return view("content.orderbutlers.pagination_index", compact("orders", "defaultCurrency"))->render();
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
   * @param  \App\Models\OrderButler  $orderButler
   * @return \Illuminate\Http\Response
   */
  public function show($orderbutler)
  {
    $defaultCurrency = Currency::where("default", 1)->first();

    $order = OrderButler::with(["orderItems"])->find($orderbutler);

    return view("content.orderbutlers.show", compact("order", "defaultCurrency"));
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\OrderButler  $orderButler
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, OrderButler $orderButler)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\OrderButler  $orderButler
   * @return \Illuminate\Http\Response
   */
  public function destroy(OrderButler $orderButler)
  {
    //
  }

  public function showMapOfTheOrder(OrderButler $order)
  {

    $order = OrderButler::with('deliveryTrack')->find($order->id);


    return view("content.orderbutlers.showMap", compact("order"));
  }
}
