<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Weekhour,Day};
use Illuminate\Http\Request;
use App\Http\Requests\dash\DE\WeekHourRequest;
class WeekhourController extends Controller
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
    public function store(WeekHourRequest $request)
    {
      $weekhour = Weekhour::create([
        "day_id" => $request->day,
        "store_id"=>$request->store_id,
        "from"=>$request->fromTime,
        "to"=>$request->toTime

      ]);


      if ($weekhour) {
        return response()->json([
          "status" => true,
          "message" => "WeekHour Added Successfully"
        ]);
      } else {
        return response()->json([
          "status" => false,
          "message" => "Failed to add WeekHour"
        ], 500); // Internal Server Error status code
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Weekhour  $weekhour
     * @return \Illuminate\Http\Response
     */
    public function show(Weekhour $weekhour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WeekHour  $weekhour
     * @return \Illuminate\Http\Response
     */
    public function edit(Weekhour $weekhour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeekHour  $weekHour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Weekhour $weekhour)
    {
      $rules = [
        "up_to_timme"=>"required",
        "up_fromtimee"=>"required"

      ];


      $validator = \Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }
      $weekhour->update(["from"=>$request->up_fromtimee,"to"=>$request->up_to_timme]);

      return response()->json([
        "status" => true,
        "message" => "Weekhour updated successfully"
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Weekhour  $weekHour
     * @return \Illuminate\Http\Response
     */


    public function destroy($weekhour)
    {
      try {
        $weekhour = Weekhour::findOrFail($weekhour);
        $weekhour->delete();

        return response()->json(['status' => true, 'msg' => "WeekHour Deleted Successfully"]);
      } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
      }
    }



    public function customEdit(Weekhour $weekhour,Day $day)
    {

    }
}
