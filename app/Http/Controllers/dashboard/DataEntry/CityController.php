<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Http\Requests\dash\DE\CityRequest;
use Illuminate\Http\Request;
use App\Models\{
  City,
  Country
};
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class CityController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

   public function searchCity(Request $request)
   {
       $locale = LaravelLocalization::getCurrentLocale();

       $searchString = '%' . $request->search_string . '%';

       $cities = City::where("name_" . $locale, 'like', $searchString)
           ->orWhere("district_" . $locale, 'like', $searchString)->select(
            "id",
            "name_" . $locale . " as name",
            "name_en",
            "name_ar",
            "district_en",
            "district_ar",
            "district_" . $locale . " as district",
            "CountryCode",
            "population",
            "country_id")
           ->latest()
           ->paginate(PAGINATION_COUNT);

       if ($cities->count() > 0) {
           // Return the search results as HTML
           return view("content.city.pagination_index", compact("cities"))->render();
       } else {
           return response()->json([
               "status" => 'nothing_found',
           ]);
       }
   }


  public function index()
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $cities = City::with([
      "country" =>
        function ($query) use ($locale) {

          $query->select("id", "name_" . $locale . " as name");

        }
    ])->select(
        "id",
        "name_" . $locale . " as name",
        "name_en",
        "name_ar",
        "district_en",
        "district_ar",
        "district_" . $locale . " as district",
        "CountryCode",
        "population",
        "country_id"
      )->latest()->paginate(PAGINATION_COUNT);

    // if ($request->ajax()) {
    //   return view("content.city.presult", compact("cities"));
    // }


    return view("content.city.index", compact("cities"));
  }


  /****pagination city */


  public function paginationCity(Request $request)
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $cities = City::with([
      "country" =>
        function ($query) use ($locale) {

          $query->select("id", "name_" . $locale . " as name");

        }
    ])->select(
        "id",
        "name_" . $locale . " as name",
        "name_en",
        "name_ar",
        "district_en",
        "district_ar",
        "district_" . $locale . " as district",
        "CountryCode",
        "population",
        "country_id"
      )->latest()->paginate(PAGINATION_COUNT);
    return view("content.city.pagination_index", compact("cities"))->render();

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
  public function store(CityRequest $request)
  {
    $city = City::create([
      "name_en" => $request->name_en,
      "name_ar" => $request->name_ar,
      "population" => $request->population,
      "CountryCode" => $request->CountryCode,
      "district_en" => $request->district_en,
      "district_ar" => $request->district_ar,
      "country_id" => $request->country_id

    ]);


    if ($city) {
      return response()->json([
        "status" => true,
        "message" => "City Added Successfully"
      ]);
    } else {
      return response()->json([
        "status" => false,
        "message" => "Failed to add city"
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, City $city)
  {
    $rules = [
      'up_name_en' => 'required|string|max:30|min:3|unique:cities,name_en,' . $city->id,
      'up_name_ar' => 'required|string|max:30|min:3|unique:cities,name_ar,' . $city->id,
      'up_district_en' => 'required|string|max:30|min:3',
      'up_district_ar' => 'required|string|max:30|min:3',
      'up_population' => 'required|numeric',
      'up_CountryCode' => 'required',
      'up_population'=>'nullable|integer|digits_between:1,11',
      'up_country_id'=>'required|exists:countries,id'

    ];

    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $city->name_en = $request->up_name_en;
    $city->name_ar = $request->up_name_ar;
    $city->district_en = $request->up_district_en;
    $city->district_ar = $request->up_district_ar;
    $city->population = $request->up_population;
    $city->CountryCode = $request->up_CountryCode;
    $city->country_id = $request->up_country_id;

    $city->save();

    return response()->json([
      "status" => true,
      "message" => "City updated successfully"
    ]);
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function destroy(City $city)
  {
    try {
      $city->delete();
      return response()->json(['status' => true, 'msg' => "City Deleted Successfully", "id" => $city->id]);
    } catch (\Exception $e) {
      if ($e->getMessage() === "Cannot delete City, It is related to other tables") {
        return response()->json(['status' => false, 'msg' => $e->getMessage()], 403);
      }
      return response()->json(['status' => false, 'msg' => "An error occurred while deleting the city."], 500);
    }
  }





}
