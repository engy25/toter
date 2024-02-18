<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Http\Requests\dash\DE\CityRequest;
use App\Models\CityTranslation;
use Illuminate\Http\Request;
use App\Models\{
  City,
  Country
};
use Illuminate\Validation\Rule;
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

    $cities = City::whereHas('country.translations', function ($query) use ($searchString) {
      $query->where('name', 'like', $searchString);
    })
      ->orWhereHas('translations', function ($query) use ($searchString) {
        $query->where('name', 'like', $searchString);
      })
      ->with([
        'country' => function ($query) {
          $query->select('id', 'country_code');
        },
        'translations' => function ($query) use ($locale) {
          $query->select('city_id', 'name')->where("locale",$locale);
        },
      ])
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
      'country' => function ($query) use ($locale) {
        $query->select('id', 'country_code');
      },
      'translations' => function ($query) use ($locale) {
        $query->select('city_id', 'name')->where('locale', $locale);
      },
    ])->latest()->paginate(PAGINATION_COUNT);



    return view("content.city.index", compact("cities"));
  }


  /****pagination city */


  public function paginationCity(Request $request)
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $cities = City::with([
      'country' => function ($query) use ($locale) {
        $query->select('id', 'country_code');
      },
      'translations' => function ($query) use ($locale) {
        $query->select('city_id', 'name')->where('locale', $locale);
      },
    ])->latest()->paginate(PAGINATION_COUNT);
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
      "country_id" => $request->country_id

    ]);

    CityTranslation::create(['name' => $request->name_en, "city_id" => $city->id, "locale" => "en"]);
    CityTranslation::create(['name' => $request->name_ar, "locale" => "ar", "city_id" => $city->id]);


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
      'up_country_id' => 'required|exists:countries,id',
      'up_name_en' => [
        'required',
        'string',
        'max:30',
        'min:3',
        Rule::unique('city_translations', 'name')->ignore($city->id, 'city_id')->where(function ($query) use ($request, $city) {
          // Check if the English name is different
          return $request->up_name_en !== $city->nameTranslation('en');
        }),
      ],
      'up_name_ar' => [
        'required',
        'string',
        'max:30',
        'min:3',
        Rule::unique('city_translations', 'name')->ignore($city->id, 'city_id')->where(function ($query) use ($request, $city) {
          // Check if the Arabic name is different
          return $request->up_name_ar !== $city->nameTranslation('ar');
        }),
      ],
    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    

    $city->country_id = $request->up_country_id;

    $city->save();
    CityTranslation::where(['city_id' => $city->id, "locale" => "en"])->update(['name' => $request->up_name_en]);
    CityTranslation::where(['city_id' => $city->id, "locale" => "ar"])->update(['name' => $request->up_name_ar]);

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
      return response()->json(['status' => true, 'msg' => "City Deleted Successfully"]);
    } catch (\Exception $e) {
      if ($e->getMessage() === "Cannot delete City, It is related to other tables") {
        return response()->json(['status' => false, 'msg' => $e->getMessage()], 403);
      }
      return response()->json(['status' => false, 'msg' => "An error occurred while deleting the city."], 500);
    }
  }





}
