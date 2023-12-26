<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{District,City,DistrictTranslation,CountryTranslation};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Requests\dash\DE\districtRequest;
class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function cityIndex()
     {
      $locale=LaravelLocalization::getCurrentLocale();
      $countryiraq=CountryTranslation::where("name","iraq")->first();
      $cities = City::where("country_id",$countryiraq->country_id)->with(["translations"=>function ($query) use ($locale){
        $query->select("city_id","name")->where("locale",$locale);
      }])->select('id')->get();
      return response()->json($cities);

     }


     public function searchStore(Request $request)
     {
       $locale = LaravelLocalization::getCurrentLocale();
       $searchString = '%' . $request->search_string . '%';

      //  $stores = Store::where(function ($query) use ($searchString) {
      //    $query->whereHas('section.translations', function ($subQuery) use ($searchString) {
      //      $subQuery->where('name', 'like', $searchString);
      //    })->orWhereHas('translations', function ($subQuery) use ($searchString) {
      //      $subQuery->where('name', 'like', $searchString)
      //        ->orWhere('description', 'like', $searchString);
      //    });
      //  })
      //    ->with([
      //      'section' => function ($query) {
      //        $query->select('id');
      //      },
      //      'translations' => function ($query) use ($locale) {
      //        $query->select('store_id', 'name')->where("locale", $locale);
      //      },
      //    ])
      //    ->latest()
      //    ->paginate(PAGINATION_COUNT);


      //  if ($stores->count() > 0) {
      //    // Return the search results as HTML
      //    return view("content.store.pagination_index", compact("stores"))->render();
      //  } else {
      //    return response()->json([
      //      "status" => 'nothing_found',
      //    ]);
      //  }
     }


     public function paginationDistrict(Request $request)
     {

       $locale = LaravelLocalization::getCurrentLocale();

       $districts = District::with([
         'city' => function ($query) use ($locale) {
           $query->select('id');
         },
         'translations' => function ($query) use ($locale) {
           $query->select('district_id', 'name')->where('locale', $locale);
         },
       ])->latest()->paginate(PAGINATION_COUNT);
       return view("content.district.pagination_index", compact("districts"))->render();

     }
    public function index()
    {
      $locale = LaravelLocalization::getCurrentLocale();

      $districts = District::with([
        'city' => function ($query) use ($locale) {
          $query->select('id');
        },
        'translations' => function ($query) use ($locale) {
          $query->select('district_id', 'name')->where('locale', $locale);
        },
      ])->latest()->paginate(PAGINATION_COUNT);



      return view("content.district.index", compact("districts"));
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
    public function store(districtRequest $request)
    {
      $district = District::create([
        "city_id" => $request->city_id

      ]);

      DistrictTranslation::create(['name' => $request->name_en, "district_id" => $district->id, "locale" => "en"]);
      DistrictTranslation::create(['name' => $request->name_ar, "locale" => "ar", "district_id" => $district->id]);


      if ($district) {
        return response()->json([
          "status" => true,
          "message" => "District Added Successfully"
        ]);
      } else {
        return response()->json([
          "status" => false,
          "message" => "Failed to add District"
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
    public function update(Request $request,District $district)
    {
    $rules = [
      'up_city_id' => 'required|exists:cities,id',
      'up_name_en' => [
        'required',
        'string',
        'max:30',
        'min:3',
        Rule::unique('district_translations', 'name')->ignore($district->id, 'district_id')->where(function ($query) use ($request, $district) {
          // Check if the English name is different
          return $request->up_name_en !== $district->nameTranslation('en');
        }),
      ],
      'up_name_ar' => [
        'required',
        'string',
        'max:30',
        'min:3',
        Rule::unique('district_translations', 'name')->ignore($district->id, 'district_id')->where(function ($query) use ($request, $district) {
          // Check if the Arabic name is different
          return $request->up_name_ar !== $district->nameTranslation('ar');
        }),
      ],
    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }


    $district->city_id = $request->up_city_id;

    $district->save();
    DistrictTranslation::where(['district_id' => $district->id, "locale" => "en"])->update(['name' => $request->up_name_en]);
    DistrictTranslation::where(['district_id' => $district->id, "locale" => "ar"])->update(['name' => $request->up_name_ar]);

    return response()->json([
      "status" => true,
      "message" => "District updated successfully"
    ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
      \DB::beginTransaction();
      try {

        $district->translations()->delete();
        $district->delete();
        \DB::commit();
        return response()->json(['status' => true, 'msg' => "District Deleted Successfully"]);
      } catch (\Exception $e) {
        \DB::rollBack();

        return response()->json(['status' => false, 'msg' => "An error occurred while deleting the Districts."], 500);
      }
    }

}
