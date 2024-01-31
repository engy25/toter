<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\StoreDistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{CompanyDistrict, District, Currency, City};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Requests\dash\DE\CompanyDistrictRequest;

class CompanyDistrictController extends Controller
{
  //

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function searchCompanyDisctrict(Request $request)
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $currency = Currency::where("default", 1)->value("isocode");
    $searchString = '%' . $request->search_string . '%';

    $companyDistricts = CompanyDistrict::where(function ($query) use ($searchString, $locale) {
      // Search in the 'from' relationship
      $query->whereHas('from.translations', function ($subQuery) use ($searchString, $locale) {
        $subQuery->where('name', 'like', $searchString)->where('locale', $locale);
      });

      // Search in the 'to' relationship
      $query->orWhereHas('to.translations', function ($subQuery) use ($searchString, $locale) {
        $subQuery->where('name', 'like', $searchString)->where('locale', $locale);
      });


    })
      ->orWhere("delivery_charge", $request->search_string)
      ->latest()
      ->paginate(PAGINATION_COUNT);

    if ($companyDistricts->count() > 0) {
      // Return the search results as HTML
      return view("content.company_districts.pagination_index", compact("companyDistricts", "currency"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }


  public function index()
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $companyDistricts = CompanyDistrict::with([
      'from' => function ($query) use ($locale) {
        $query->select('id');
      },
      'to' => function ($query) use ($locale) {
        $query->select('id');
      },
    ])->latest()->paginate(PAGINATION_COUNT);
    $currency = Currency::where("default", 1)->value("isocode");



    return view("content.company_districts.index", compact("companyDistricts", "currency"));
  }


  /****pagination city */


  public function paginationCompanyDisctrict(Request $request)
  {

    $locale = LaravelLocalization::getCurrentLocale();
    $currency = Currency::where("default", 1)->value("isocode");

    $companyDistricts = CompanyDistrict::with([
      'from' => function ($query) use ($locale) {
        $query->select('id');
      },
      'to' => function ($query) use ($locale) {
        $query->select('id');
      },
    ])->latest()->paginate(PAGINATION_COUNT);

    return view("content.company_districts.pagination_index", compact("companyDistricts", "currency"))->render();

  }

  public function store(CompanyDistrictRequest $request)
  {
    $company_district = CompanyDistrict::create([
      "from_id" => $request->from_id,
      "to_id" => $request->to_id,
      "delivery_charge" => $request->delivery_charge


    ]);


    if ($company_district) {
      return response()->json([
        "status" => true,
        "message" => "company_district Added Successfully"
      ]);
    } else {
      return response()->json([
        "status" => false,
        "message" => "Failed to add company_district"
      ], 500); // Internal Server Error status code
    }
  }

  public function displayDistricts($city_id)
  {

    $locale = LaravelLocalization::getCurrentLocale();


    $districts = District::where("city_id", $city_id)->with([
      "translations" => function ($query) use ($locale) {
        $query->select("district_id", "name")->where("locale", $locale);
      }
    ])->select('id')->get();




    return response()->json($districts);



  }





  public function update(Request $request, CompanyDistrict $companydistrict)
  {

      $rules=[
        "updelivery_charge"=>'numeric|max:999999999999999999999999999.99|required',
        ];



      $validator = \Validator::make($request->all(), $rules);

      if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()], 422);
      }


      $companydistrict->update([
        "delivery_charge"=>$request->updelivery_charge
      ]);

      return response()->json([
          'status' => true,
          'message' => 'Company District updated successfully'
      ]);
  }










  public function destroy($companydistrict)
  {


    $companydistrict = CompanyDistrict::findOrFail($companydistrict);

    if ($companydistrict->orderButlers->count() > 0) {

      return response()->json(['status' => false, 'msg' => "This Company District Is Used You Canoot Delete It ."], 422);
    }

    $companydistrict->delete();

    return response()->json(['status' => true, 'msg' => "Company District Deleted Successfully"]);

  }



}
