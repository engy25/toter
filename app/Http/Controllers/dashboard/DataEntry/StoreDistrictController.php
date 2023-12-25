<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\StoreDistrict;
use Illuminate\Http\Request;
use App\Http\Requests\dash\DE\StoreDistrictStore;

class StoreDistrictController extends Controller
{
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
  public function store(StoreDistrictStore $request)
  {
    $district=StoreDistrict::where("store_id", $request->store_id)->where("district_id", $request->district)->first();
    if($district)
    {
      $district->update(["delivery_charge" => $request->delivery]);

    }

    $district = StoreDistrict::updateOrCreate(["store_id" => $request->store_id, "delivery_charge" => $request->delivery, "district_id" => $request->district]);


    if ($district) {
      return response()->json([
        'status' => true,
        'message' => 'District Added Successfully',
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Failed to add District',
      ], 500); // Internal Server Error status code
    }
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Models\District  $district
   * @return \Illuminate\Http\Response
   */
  public function show(District $district)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\District  $district
   * @return \Illuminate\Http\Response
   */
  public function edit(District $district)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\District  $district
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, District $district)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\District  $district
   * @return \Illuminate\Http\Response
   */


  public function destroy($storedistrict)
  {
    try {
      $store_district = StoreDistrict::findOrFail($storedistrict);
      $store_district->delete();

      return response()->json(['status' => true, 'msg' => "District Deleted From Store Successfully Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }
}
