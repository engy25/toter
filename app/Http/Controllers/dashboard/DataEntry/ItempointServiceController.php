<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Service, Item, ServiceTranslation};
use Illuminate\Http\Request;
use App\Http\Requests\dash\DE\ServicepointStoreRequest;

class ItempointServiceController extends Controller
{
  /**
  * Display a listing of the resource.
  *

  */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *

   */
  public function create()
  {
    //
  }


  public function store(ServicepointStoreRequest $request)
  {
    $item = Item::whereId($request->item_id)->first();
    $service = new Service;

    $service->price = 0;
    $service->item_id = $request->item_id;
    $service->store_id = $request->store_id;

    // Save the service to get the ID
    $service->save();

    // Create translations with the Service ID
    ServiceTranslation::create(['name' => $request->name_en, 'service_id' => $service->id, 'locale' => 'en']);
    ServiceTranslation::create(['name' => $request->name_ar, 'service_id' => $service->id, 'locale' => 'ar']);

    if ($service) {
      return response()->json([
        'status' => true,
        'message' => 'Service Added Successfully',
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Failed to add Service',
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Service  $service
   * @return \Illuminate\Http\Response
   */
  public function edit(Service $service)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Service  $service
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Service $service)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Service  $service
   * @return \Illuminate\Http\Response
   */
  public function destroy($itemservice)
  {
    try {

      $service = Service::where("id", $itemservice)->first();
      $service->translations()->delete();
      $service->delete();

      return response()->json(['status' => true, 'msg' => "Service Deleted Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }

  }
}
