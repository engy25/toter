<?php

namespace App\Http\Controllers\dashboard\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\{Order, Role, User, Currency, OrderCallcenter, Butler, Status, OrderButler, CountryTranslation, City, Address, StatusTranslation, OrderStatus};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use App\Http\Requests\dash\CallCenter\{StoreOrderButlerRequest};

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
    $callcenterId = auth()->user()->id;

    $deliveries = User::where("role_id", $role->id)->get();

    $statuses = Status::all();

    $ordersModel = OrderCallcenter::with(["orderItems"]);

    $dailyOrdersModel = OrderCallcenter::whereDate("created_at", Carbon::today());
    $monthlyOrdersModel = OrderCallcenter::whereMonth('created_at', Carbon::now()->month);
    $yearOrdersModel = OrderCallcenter::whereYear('created_at', Carbon::now()->year);

    $daily_salesModel = OrderCallcenter::whereDate("created_at", Carbon::today());
    $monthly_salesModel = OrderCallcenter::whereMonth("created_at", Carbon::now()->month);

    if (auth()->user()->roles()->first()->name == "Admin") {
      $orders = $ordersModel->latest()->paginate(PAGINATION_COUNT);

      $dailyOrders = $dailyOrdersModel->count();
      $monthlyOrders = $monthlyOrdersModel->count();
      $yearOrders = $yearOrdersModel->count();

      $daily_sales = $daily_salesModel->sum("total");
      $monthly_sales = $monthly_salesModel->sum("total");


    }
    $orders = $ordersModel->where("callcenter_id", $callcenterId)->latest()->paginate(PAGINATION_COUNT);
    $dailyOrders = $dailyOrdersModel->where("callcenter_id", $callcenterId)->count();
    $monthlyOrders = $monthlyOrdersModel->where("callcenter_id", $callcenterId)->count();
    $yearOrders = $yearOrdersModel->count();

    $daily_sales = $daily_salesModel->where("callcenter_id", $callcenterId)->sum("total");
    $monthly_sales = $monthly_salesModel->where("callcenter_id", $callcenterId)->sum("total");




    $defaultCurrency = Currency::where("default", 1)->first();

    return view("content.orders.index", compact("orders", "deliveries", "statuses", "monthlyOrders", "dailyOrders", "yearOrders", "daily_sales", "monthly_sales", "defaultCurrency"));
  }

  /**paginate the users */
  public function paginationOrderCallCenter(Request $request)
  {
    $defaultCurrency = Currency::where("default", 1)->first();
    $orderModels = OrderCallcenter::with(["orderItems"]);
    $orders = (auth()->user()->roles()->first()->name == "Admin" ? $orderModels->latest()->paginate(PAGINATION_COUNT) : $orderModels->where("callcenter_id", auth()->user()->id)->latest()->paginate(PAGINATION_COUNT));

    return view("content.orders.pagination_index", compact("orders", "defaultCurrency"))->render();

  }

  public function export()
  {
    try {
      $role = Role::where("name", "Delivery")->first();
      $deliveries = User::where("role_id", $role->id)->get();
      $callcenterId = auth()->user()->id;

      $statuses = Status::all();

      $ordersModel = OrderCallcenter::with(["orderItems"]);

      $dailyOrdersModel = OrderCallcenter::whereDate("created_at", Carbon::today());
      $monthlyOrdersModel = OrderCallcenter::whereMonth('created_at', Carbon::now()->month);
      $yearOrdersModel = OrderCallcenter::whereYear('created_at', Carbon::now()->year);

      $daily_salesModel = OrderCallcenter::whereDate("created_at", Carbon::today());
      $monthly_salesModel = OrderCallcenter::whereMonth("created_at", Carbon::now()->month);

      if (auth()->user()->roles()->first()->name == "Admin") {
        $orders = $ordersModel->latest()->paginate(PAGINATION_COUNT);

        $dailyOrders = $dailyOrdersModel->count();
        $monthlyOrders = $monthlyOrdersModel->count();
        $yearOrders = $yearOrdersModel->count();

        $daily_sales = $daily_salesModel->sum("total");
        $monthly_sales = $monthly_salesModel->sum("total");


      }
      $orders = $ordersModel->where("callcenter_id", $callcenterId)->latest()->paginate(PAGINATION_COUNT);
      $dailyOrders = $dailyOrdersModel->where("callcenter_id", $callcenterId)->count();
      $monthlyOrders = $monthlyOrdersModel->where("callcenter_id", $callcenterId)->count();
      $yearOrders = $yearOrdersModel->count();

      $daily_sales = $daily_salesModel->where("callcenter_id", $callcenterId)->sum("total");
      $monthly_sales = $monthly_salesModel->where("callcenter_id", $callcenterId)->sum("total");


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


    $orderModels = OrderCallcenter::when($request->search_string, function ($q) use ($searchString) {
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

    });
    $orders=(auth()->user()->roles()->first()->name == "Admin" ? $orderModels->latest()->paginate(PAGINATION_COUNT) :$orderModels->where("callcenter_id", auth()->user()->id)->latest()->paginate(PAGINATION_COUNT) );


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

  public function createOrderButler($userId)
  {
    $butlers = Butler::get();
    $countryIraqId = CountryTranslation::where("name", "Iraq")->value("country_id");
    $cities = City::where("country_id", $countryIraqId)->get();

    return view("content.orderCallcenter.orderbutler.create", compact("userId", "cities", "butlers"));
  }
  public function storeOrderButler(StoreOrderButlerRequest $request, $userId)
  {
    \DB::beginTransaction();

    try {
      $user = User::findOrFail($userId);
      $butler_id = $request->orderType;
      $butler = Butler::findOrFail($butler_id);
      $sub_total = (double) $request->expected_cost;
      $delivery_charge = (double) $request->expected_delivery;

      $fromAddress = Address::create([
        "user_id" => $userId,
        "district_id" => $request->district_id,
        "building" => $request->building,
        "street" => $request->street,
        "apartment" => $request->apartment,
        "instructions" => $request->instructions,
        "phone" => $user->phone,
        "country_code" => $user->country_code
      ]);

      $toAddress = Address::create([
        "user_id" => $userId,
        "district_id" => $request->todistrict_id,
        "building" => $request->tobuilding,
        "street" => $request->tostreet,
        "apartment" => $request->toapartment,
        "instructions" => $request->toinstructions,
        "phone" => $user->phone,
        "country_code" => $user->country_code
      ]);

      $order_data = [
        "from_address" => $fromAddress->id,
        "to_address" => $toAddress->id,
        "from_driver_instructions" => $request->instructions,
        "to_driver_instructions" => $request->toinstructions,
        'payment_type' => "cash",
        "order" => $request->order,
        "delivery_time" => $butler->delivery_time,
        "expected_delivery_charge" => $request->delivery_charge,
        "expected_cost" => $request->expected_cost,
        "admin_id" => auth()->user()->id,
        "user_id" => $userId,
        "butler_id" => $butler->id,
        "sub_total" => $sub_total,
        "sum" => $sub_total + $delivery_charge + $butler->service_charge,
        "total" => $sub_total + $delivery_charge,
        "service_charge" => $butler->service_charge,

      ];
      $order = OrderButler::create($order_data);

      if (is_array($request->items)) {
        foreach ($request->items as $item) {
          $order->orderItems()->create([
            "order_id" => $order->id,
            "item" => $item["item"],
            "image" => $item["image"] ?? null,
          ]);
        }

      }

      $status_pending = StatusTranslation::where("name", "pending")->first();

      // Create a new status for the order
      OrderStatus::create([
        "status_id" => $status_pending->status_id,
        "ordereable_id" => $order->id, // Explicitly set the ordereable_id
        "ordereable_type" => "App\Models\OrderButler"
      ]);
      \DB::commit();

      return view("content.orderCallcenter.orderbutler.show", compact("order"))->with('msg', 'Order Added Successfully');
    } catch (\Exception $e) {
      // Rollback the transaction in case of an exception
      \DB::rollBack();

      // Log the error
      \Log::error($e->getMessage());

      // Return an error response or handle the exception as needed
      return redirect()->route('traditionalusers.index')->with('error', 'Error creating user and address.');
    }
  }


}
