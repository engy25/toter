<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{User, Day, Country, DeliverySchedule, DayTranslation, Currency, DeliveryArrivalTime, WalletTransaction};

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\dash\{
  DE\DeliveryStoreRequest,
  DE\StoreDeliveryScheduleRequest,
  CallCenter\StoreArrivalTimeRequest,
  CallCenter\StoreDailyPriceToDeliveryRequest
};
use App\Helpers\Helpers;
use DateTime;
use Carbon\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DeliveryController extends Controller
{
  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }
  public function searchDelivery(Request $request)
  {

    $searchString = '%' . $request->search_string . '%';
    $role = Role::where("name", "Delivery")->first();
    $deliveries = User::role("Delivery","api")->where(function ($query) use ($searchString) {

      $query->where("fname", 'like', $searchString)
        ->orWhere('email', 'like', $searchString)
        ->orWhere('phone', 'like', $searchString);
    })->latest()->paginate(PAGINATION_COUNT);

    if ($deliveries->count() > 0) {
      // Return the search results as HTML
      return view("content.delivery.pagination_index", compact("deliveries"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }

  public function paginationDelivert(Request $request)
  {

    $deliveries = User::role("Delivery","api")->latest()->paginate(PAGINATION_COUNT);
    return view("content.delivery.pagination_index", compact("deliveries"))->render();

  }


  /**
   * Display a listing of the resource.
   *
   */
  public function index()
  {

    $deliveries = User::role("Delivery","api")->latest()->paginate(PAGINATION_COUNT);
    return view('content.delivery.index', compact('deliveries'));
  }

  /**
   * Show the form for creating a new resource.
   *
   *
   */
  public function create()
  {
    $days = Day::get();
    $countries = Country::all();

    return view("content.delivery.create", compact("days", "countries"));
  }
  private function storeWeekhours($deliveryId, $deliveries)
  {
    if ($deliveries) {
      foreach ($deliveries as $delivery) {

        $fromTime = new DateTime($delivery['from_time']);
        $toTime = new DateTime($delivery['to_time']);
        // Calculate the working hours
        $interval = $fromTime->diff($toTime);
        $workingHours = $interval->h;
        ;

        $theSchedule = new DeliverySchedule;
        $theSchedule->fill([
          'delivery_id' => $deliveryId,
          'day_id' => $delivery['day_id'],
          'from_time' => $delivery['from_time'],
          'to_time' => $delivery['to_time'],
          'working_hours' => $workingHours
        ]);
        $theSchedule->save();


      }
    }
  }
  /**
   * Store a newly created resource in storage.
   *
   *
   */
  public function store(DeliveryStoreRequest $request)
  {
    \DB::beginTransaction();

    try {


      $role = Role::findByName('Delivery', 'api');
      $delivery = new User;
      $delivery->fname = $request->fname;
      $delivery->lname = $request->lname;
      $delivery->country_code = $request->country;
      $delivery->email = $request->email;
      $delivery->phone = $request->phone;
      $delivery->country_code = $request->country;
      $delivery->password = $request->password;
      $delivery->is_active = 1;
      $delivery->role_id = $role->id;

      // // Handle image upload
      if ($request->hasFile('image')) {


        $delivery->image = $request->image;
      }

      $delivery->save();
      $delivery->assignRole($role);
      $this->storeWeekhours($delivery->id, $request->deliveries);

      \DB::commit();

      return redirect()->route('deliveries.index')->with('success', 'Delivery created successfully.');
    } catch (\Exception $e) {
      \DB::rollBack();
      return $this->helper->responseJson('fail', trans('api.auth_failed'), 422, null);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User  $delivery

   */
  public function show(User $delivery)
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $deliveryId = $delivery->id;
    $orderCounts = User::deliveryOrdersCount($delivery->id);
    $weekhours = DeliverySchedule::where("delivery_id", $deliveryId)->get();
    $arrivalTimes = DeliveryArrivalTime::where("delivery_id", $deliveryId)->orderBy('is_paid', 'asc')->get();

    return view('content.delivery.show', compact('delivery', 'weekhours', 'orderCounts', 'arrivalTimes'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $delivery

   */
  public function edit(User $delivery)
  {
    $days = Day::get();
    $countries = Country::all();
    return view("content.delivery.update", compact("delivery", "days", "countries"));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $delivery
   */
  public function update(Request $request, User $delivery)
  {


    // Update the delivery information
    $delivery->update([
      'fname' => $request->fname,
      'lname' => $request->lname,
      'email' => $request->email,
      'country_code' => $request->country,
      'phone' => $request->phone,

    ]);
    if ($request->password != null) {

      $delivery->update(['password' => $request->password]);
    }


    // Handle image upload
    if ($request->hasFile('upimage')) {
      $delivery->update(['image' => $request->upimage]);
    }

    // Redirect back or to a specific route after the update
    return redirect()->route('deliveries.index', $delivery->id)->with('success', 'Delivery updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    //
  }
  // In your controller or route
  public function getDays()
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $days = Day::
      with([
        'translations' => function ($query) use ($locale) {
          $query->where('locale', $locale);
        },
      ])
      ->get();


    return response()->json($days);
  }
  public function deliveryScheduleUpdate(Request $request, DeliverySchedule $deliveryschedule)
  {
    $rules = [
      "up_to_timme" => "required",
      "up_fromtimee" => "required"

    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }
    $fromTime = new DateTime($request->up_fromtimee);
    $toTime = new DateTime($request->up_to_timme);
    // Calculate the working hours
    $interval = $fromTime->diff($toTime);
    $workingHours = $interval->h + ($interval->i / 60);

    $deliveryschedule->update(["from_time" => $request->up_fromtimee, "to_time" => $request->up_to_timme, "working_hours" => $workingHours]);

    return response()->json([
      "status" => true,
      "message" => "Delivery Schedule updated successfully"
    ]);
  }

  public function deliveryScheduleDestroy(DeliverySchedule $deliveryschedule)
  {
    try {
      $deliveryschedule->delete();
      return response()->json(['status' => true, 'msg' => "WeekHour Deleted Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }


  public function getDaysNotInSchedule(User $deliveryId)
  {

    $deliveryId = $deliveryId->id;

    $locale = LaravelLocalization::getCurrentLocale();
    $dayswhereNotInSchedule = Day::with([
      'translations' => function ($query) use ($locale) {
        $query->where('locale', $locale);
      },
      'deliverySchedules' => function ($query) use ($deliveryId) {
        $query->where('delivery_id', $deliveryId);
      },
    ])->whereDoesntHave('deliverySchedules', function ($query) use ($deliveryId) {
      $query->where('delivery_id', $deliveryId);
    })->get();
    return response()->json($dayswhereNotInSchedule);

  }



  public function deliveryScheduleStore(StoreDeliveryScheduleRequest $request)
  {
    $fromTime = new DateTime($request->fromTime);
    $toTime = new DateTime($request->toTime);
    // Calculate the working hours
    $interval = $fromTime->diff($toTime);
    $workingHours = $interval->h + ($interval->i / 60);

    $schedule = DeliverySchedule::create([
      "day_id" => $request->day_id,
      "delivery_id" => $request->delivery_id,
      "from_time" => $request->fromTime,
      "to_time" => $request->toTime,
      "working_hours" => $workingHours

    ]);

    if ($schedule) {
      return response()->json([
        "status" => true,
        "message" => "Schedule Added Successfully"
      ]);
    } else {
      return response()->json([
        "status" => false,
        "message" => "Failed to add Schedule"
      ], 500); // Internal Server Error status code
    }
  }


  /**
   * Add Arrival Time To Delivery

  */public function addArrivalTimeToDelivery(StoreArrivalTimeRequest $request)
  {
    $currentDayName = Carbon::now()->format('l');
    $day = DayTranslation::where("name", $currentDayName)->first();
    $dayId = $day->day_id;

    $fromTime = new DateTime($request->fromTime);
    $toTime = new DateTime($request->toTime);

    // Calculate the working hours
    $interval = $fromTime->diff($toTime);
    $workingHours = $interval->h + ($interval->i / 60);

    $currentDate = Carbon::now()->format('Y-m-d');

    // Check if there is a record for this delivery on this date
    $deliveryArrivalTime = DeliveryArrivalTime::where("delivery_id", $request->delivery_id)
      ->whereDate("created_at", $currentDate)
      ->first();

    if ($deliveryArrivalTime) {
      // If a record exists, update it
      $deliveryArrivalTime->update([
        "attendance_time" => $fromTime, // Use formatted time string
        "cancel_time" => $toTime, // Use formatted time string
        "working_hours" => $workingHours
      ]);
    } else {
      // If no record exists, create a new one
      DeliveryArrivalTime::create([
        "day_id" => $dayId,
        "delivery_id" => $request->delivery_id,
        "attendance_time" => $fromTime, // Use formatted time string
        "cancel_time" => $toTime, // Use formatted time string
        "working_hours" => $workingHours
      ]);
    }

    return response()->json([
      "status" => true,
      "message" => "Delivery Arrival Time updated successfully"
    ]);
  }

  public function AddDailyPriceToDelivery(StoreDailyPriceToDeliveryRequest $request)
  {

    $defaultCurrency = Currency::where("default", 1)->first();
    $arrival_time_id = $request->arrivalTimeId;
    $delivery_id = $request->delivery_id;
    $price = $request->price;
    /**add price of this day to the delivery wallet */
    $wallet = WalletTransaction::create([
      "sender_id" => auth()->user()->id,
      "receiver_id" => $delivery_id,
      "transaction_type" => "daily calculation",
      "amount" => $price,
      "currency_id" => $defaultCurrency->id,
      // "to_date"=>
    ]);
    /**update paid the  delivery_arrival_times */
    DeliveryArrivalTime::whereId($arrival_time_id)->update([
      "is_paid" => 1
    ]);

    return response()->json([
      "status" => true,
      "message" => "Added successfully"
    ]);

  }
  /**
   * add incentive to delivery
   */
  public function AddIncenticeToDelivery(StoreDailyPriceToDeliveryRequest $request)
  {

    $defaultCurrency = Currency::where("default", 1)->first();
    // $arrival_time_id = $request->arrivalTimeId;
    $delivery_id = $request->delivery_id;
    $price = $request->price;
    /**add price of this day to the delivery wallet */
    $wallet = WalletTransaction::create([
      "sender_id" => auth()->user()->id,
      "receiver_id" => $delivery_id,
      "transaction_type" => "Incentive",
      "amount" => $price,
      "currency_id" => $defaultCurrency->id,
      // "to_date"=>
    ]);



    return response()->json([
      "status" => true,
      "message" => "Added successfully"
    ]);

  }
  public function AddDiscountToDelivery(StoreDailyPriceToDeliveryRequest $request)
  {

    $defaultCurrency = Currency::where("default", 1)->first();
    // $arrival_time_id = $request->arrivalTimeId;
    $delivery_id = $request->delivery_id;
    $price = $request->price;
    /**add price of this day to the delivery wallet */
    $wallet = WalletTransaction::create([
      "sender_id" => auth()->user()->id,
      "receiver_id" => $delivery_id,
      "transaction_type" => "Discount",
      "amount" => -$price,
      "currency_id" => $defaultCurrency->id,

    ]);



    return response()->json([
      "status" => true,
      "message" => "Added successfully"
    ]);

  }


}
