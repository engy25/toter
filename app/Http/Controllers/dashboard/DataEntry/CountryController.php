<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Http\Requests\dash\DE\CountryRequest;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CountryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $countries = Country::with([
      "currency" => function ($query) use ($locale) {
        $query->select("id", "name_" . $locale . " as name", "isocode");
      }
    ])->select([
          "name_" . $locale . " as name",
          "id",
          "region_" . $locale . " as region",
          "code",
          "code2",
          "name_en",
          "name_ar",
          "region_en",
          "region_ar",
          "localName_en",
          "localName_ar",
          "governmentForm_en",
          "governmentForm_ar",
          "capital",
          "HeadOfState",
          "capital",
          "IndepYear",
          "surfaceArea",
          "lifeExpectancy",
          "GNP",
          "GNPOld",
          "currency_id",
          "localName_" . $locale . " as localName",
          "population",
          "continent"
        ])->latest()->paginate(PAGINATION_COUNT);

    return view("content.country.index", compact("countries"));
    //return response()->json($countries);
  }

  public function paginationCountry(Request $request)
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $countries = Country::with([
      "currency" => function ($query) use ($locale) {
        $query->select("id", "name_" . $locale . " as name", "isocode");
      }
    ])->select([
          "name_" . $locale . " as name",
          "id",
          "region_" . $locale . " as region",
          "code",
          "code2",
          "name_en",
          "name_ar",
          "region_en",
          "region_ar",
          "localName_en",
          "localName_ar",
          "governmentForm_en",
          "governmentForm_ar",
          "capital",
          "HeadOfState",
          "capital",
          "IndepYear",
          "surfaceArea",
          "lifeExpectancy",
          "GNP",
          "GNPOld",
          "currency_id",
          "localName_" . $locale . " as localName",
          "population",
          "continent"
        ])->latest()->paginate(PAGINATION_COUNT);
    return view("content.country.pagination_index", compact("countries"))->render();


  }

  /****search  */
  public function searchCountry(Request $request)
  {
    $locale = LaravelLocalization::getCurrentLocale();

    $searchString = '%' . $request->search_string . '%';

    $countries = Country::with([
      "currency" => function ($query) use ($locale) {
        $query->select("id", "name_" . $locale . " as name", "isocode");
      }
    ])
      ->where("name_" . $locale, 'like', $searchString)
      ->orWhere("name_" . $locale, 'like', $searchString)
      ->orWhere("region_" . $locale, 'like', $searchString)
      ->orWhere("localName_" . $locale, 'like', $searchString)
      ->orWhere("governmentForm_" . $locale, 'like', $searchString)
      ->orWhere("capital", 'like', $searchString)
      ->orWhere("HeadOfState", 'like', $searchString)
      ->orWhere("IndepYear", 'like', $searchString)
      ->orWhere("lifeExpectancy", 'like', $searchString)
      ->orWhere("continent", 'like', $searchString)
      ->orWhere("GNP", 'like', $searchString)
      ->orWhere("GNPOld", 'like', $searchString)
      ->orWhere("code", 'like', $searchString)
      ->orWhere("code2", 'like', $searchString)
      ->select([
        "name_" . $locale . " as name",
        "id",
        "region_" . $locale . " as region",
        "code",
        "code2",
        "name_en",
        "name_ar",
        "region_en",
        "region_ar",
        "localName_en",
        "localName_ar",
        "governmentForm_en",
        "governmentForm_ar",
        "capital",
        "HeadOfState",
        "capital",
        "IndepYear",
        "surfaceArea",
        "lifeExpectancy",
        "GNP",
        "GNPOld",
        "currency_id",
        "localName_" . $locale . " as localName",
        "population",
        "continent"
      ])
      ->latest()
      ->paginate(PAGINATION_COUNT);

    if ($countries->count() > 0) {
      // Return the search results as HTML
      return view("content.country.pagination_index", compact("countries"))->render();
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
  public function store(CountryRequest $request)
  {
    //
    $country = Country::create([
      'code' => $request->code,
      'code2' => $request->code2,
      "name_en" => $request->name_en,
      "name_ar" => $request->name_ar,
      "region_en" => $request->region_en,
      "region_ar" => $request->region_ar,
      'localName_en' => $request->localName_en,
      'localName_ar' => $request->localName_ar,
      "governmentForm_en" => $request->governmentForm_en,
      "governmentForm_ar" => $request->governmentForm_ar,
      "HeadOfState" => $request->HeadOfState,
      "capital" => $request->capital,
      "continent" => $request->continent,
      "currency_id" => $request->currency_id,
      'IndepYear' => $request->IndepYear,
      'population' => $request->population,
      "surfaceArea" => $request->surfaceArea,
      "lifeExpectancy" => $request->lifeExpectancy,
      "GNP" => $request->GNP,
      "GNPOld" => $request->GNPOld,

    ]);

    if ($country) {
      return response()->json([
        "status" => true,
        "message" => "Country Added Successfully"
      ]);
    } else {
      return response()->json([
        "status" => false,
        "message" => "Failed to add Country"
      ], 500);

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
  public function update(Request $request, Country $country)
  {
    $rules = [
      'code' => 'required|string|max:3',
      'code2' => 'required|string|max:3',
      'name_en' => 'required|string|max:50',
      'name_ar' => 'required|string|max:50',
      'region_en' => 'required|string|max:50',
      'region_ar' => 'required|string|max:50',
      'localName_en' => 'required|string|max:50',
      'localName_ar' => 'required|string|max:50',
      'governmentForm_en' => 'required|string|max:50',
      'governmentForm_ar' => 'required|string|max:50',
      'HeadOfState' => 'nullable|string|max:50',
      'capital' => 'nullable|string|max:50',
      'continent' => 'required|string|in:Asia,North America,South America,Antarctica,Europe,Australia,Africa',
      'IndepYear' => 'nullable|integer|min:1900|max:' . date('Y'),
      // Assuming IndepYear should be a valid year
      'population' => 'nullable|integer|min:0',
      'surfaceArea' => 'nullable|regex:/^\d{1,8}(\.\d{1,2})?$/',
      'lifeExpectancy' => 'nullable|regex:/^\d{1,8}(\.\d{1,2})?$/',
      'GNP' => 'nullable|regex:/^\d{1,8}(\.\d{1,2})?$/',
      'GNPOld' => 'nullable|regex:/^\d{1,8}(\.\d{1,2})?$/',
      'currency_id' => 'required|exists:currencies,id',

    ];

    $validator = \validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return response()->json([
        "errors" => $validator->errors()
      ], 422);
    }

    $country->code = $request->up_code;
    $country->code2 = $request->code2;
    $country->name_en = $request->name_en;
    $country->name_ar = $request->name_ar;
    $country->region_en = $request->region_en;
    $country->region_ar = $request->region_ar;
    $country->localName_en = $request->localName_en;
    $country->localName_ar = $request->localName_ar;
    $country->governmentForm_en = $request->governmentForm_en;
    $country->governmentForm_ar = $request->governmentForm_ar;
    $country->HeadOfState = $request->HeadOfState;
    $country->capital = $request->capital;
    $country->continent = $request->continent;
    $country->currency_id = $request->currency_i;
    $country->IndepYear = $request->IndepYear;
    $country->population = $request->population;
    $country->surfaceArea = $request->surfaceArea;
    $country->lifeExpectancy = $request->lifeExpectancy;
    $country->GNP = $request->GNP;
    $country->GNPOld = $request->GNPOld;

    $country->save();

    return response()->json([
      "status" => true,
      "message" => " Country Updated Successfully"
    ]);


  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Country $country)
  {
    try {

      $country->delete();
      return response()->json(['status' => true, 'msg' => "Country Deleted Successfully", "id" => $country->id]);
    } catch (\Exception $e) {

      if ($e->getMessage() === "Cannot delete Country, It is related to other tables") {
        return response()->json(['status' => false, 'msg' => $e->getMessage()], 403);
      }
      return response()->json(['status' => false, 'msg' => "An error occurred while deleting the Country."], 500);
    }

  }

  public function countryIndex()
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $countries = Country::select("name_" . $locale . " as name", "id")->get();

    return response()->json($countries);

  }
}
