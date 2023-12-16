<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Subsection, SubsectionTranslation};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Requests\dash\DE\SubsectionRequest;
use App\Helpers\Helpers;

class SubSectionController extends Controller
{

  public $helper;
  public function __construct()
  {
    $this->helper = new Helpers();
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  // public function searchCity(Request $request)
  // {
  //   $locale = LaravelLocalization::getCurrentLocale();
  //   $searchString = '%' . $request->search_string . '%';

  //   $cities = City::whereHas('country.translations', function ($query) use ($searchString) {
  //     $query->where('name', 'like', $searchString);
  //   })
  //     ->orWhereHas('translations', function ($query) use ($searchString) {
  //       $query->where('name', 'like', $searchString);
  //     })
  //     ->with([
  //       'country' => function ($query) {
  //         $query->select('id', 'country_code');
  //       },
  //       'translations' => function ($query) {
  //         $query->select('city_id', 'name');
  //       },
  //     ])
  //     ->latest()
  //     ->paginate(PAGINATION_COUNT);

  //   if ($cities->count() > 0) {
  //     // Return the search results as HTML
  //     return view("content.city.pagination_index", compact("cities"))->render();
  //   } else {
  //     return response()->json([
  //       "status" => 'nothing_found',
  //     ]);
  //   }
  // }
  public function index()
  {
    $locale = LaravelLocalization::getCurrentLocale();

    $subsections = Subsection::ValidWeb()

      ->with([
        'section' => function ($query) use ($locale) {
          $query->select('id');
        },
        'translations' => function ($query) use ($locale) {
          $query->select('sub_section_id', 'name')->where('locale', $locale);

        },
      ])
      ->latest()->paginate(PAGINATION_COUNT);



    return view("content.subsection.index", compact("subsections"));
  }




  /****pagination city */


  public function paginationSubsection(Request $request)
  {

    $locale = LaravelLocalization::getCurrentLocale();

    $subsections = Subsection::ValidWeb()

      ->with([
        'section' => function ($query) use ($locale) {
          $query->select('id');
        },
        'translations' => function ($query) use ($locale) {
          $query->select('sub_section_id', 'name')->where('locale', $locale);

        },
      ])
      ->latest()->paginate(PAGINATION_COUNT);

    return view("content.subsection.pagination_index", compact("subsections"))->render();

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
  public function store(SubsectionRequest $request)
  {
    $subsection = new Subsection;
    $subsection->section_id = $request->section_id;

    // // Handle image upload
    if ($request->hasFile('image')) {

      $image = $request->file('image');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/subSections/');
      $subsection->image = $imagePath;
    }

    // Save the Subsection to get the ID
    $subsection->save();

    // Create translations with the Subsection ID
    SubsectionTranslation::create(['name' => $request->name_en, 'description' => $request->description_en, 'sub_section_id' => $subsection->id, 'locale' => 'en']);
    SubsectionTranslation::create(['name' => $request->name_ar, 'description' => $request->description_ar, 'sub_section_id' => $subsection->id, 'locale' => 'ar']);

    if ($subsection) {
      return response()->json([
        'status' => true,
        'message' => 'Subsection Added Successfully',
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Failed to add Subsection',
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\SubSection  $subSection
   * @return \Illuminate\Http\Response
   */
  public function show(Subsection $subSection)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\SubSection  $subSection
   * @return \Illuminate\Http\Response
   */
  public function edit(Subsection $subSection)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\SubSection  $subSection
   * @return \Illuminate\Http\Response
   */


  public function update(Request $request, Subsection $subSection)
  {
    $rules = [
      'up_section_id' => 'required|exists:sections,id',
      'up_name_en' => [
        'required',
        'string',
        'max:30',
        'min:3',
        Rule::unique('subsection_translations', 'name')->ignore($subSection->id, 'city_id')->where(function ($query) use ($request, $subSection) {
          // Check if the English name is different
          return $request->up_name_en !== $subSection->nameTranslation('en');
        }),
      ],
      'up_name_ar' => [
        'required',
        'string',
        'max:30',
        'min:3',
        Rule::unique('subsection_translations', 'name')->ignore($subSection->id, 'city_id')->where(function ($query) use ($request, $subSection) {
          // Check if the Arabic name is different
          return $request->up_name_ar !== $subSection->nameTranslation('ar');
        }),
        'up_description_en' => 'nullable|string|min:3|max:500', // Adjust max length as needed
        'up_description_ar' => 'nullable|required|string|min:3|max:500',
        'image' => 'required|max:10000',
      ],
    ];


    $validator = \Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }


    $subSection->section_id = $request->up_section_id;



    if ($request->hasFile('up_image')) {
      $image = $request->file('up_image');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/subSections/');
      $subSection->image = $imagePath;
    }

    $subSection->save();
    SubsectionTranslation::where(['sub_section_id' => $subSection->id, "locale" => "en"])->update(['name' => $request->up_name_en, 'description' => $request->up_description_en]);
    SubsectionTranslation::where(['sub_section_id' => $subSection->id, "locale" => "ar"])->update(['name' => $request->up_name_ar, 'description' => $request->up_description_ar]);

    return response()->json([
      "status" => true,
      "message" => "Subsection updated successfully"
    ]);
  }





  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\SubSection  $subSection
   * @return \Illuminate\Http\Response
   */


  public function destroy(Subsection $subSection)
  {
    try {
      // No translations, proceed with deletion
      $subSection->delete();

      return response()->json(['status' => true, 'msg' => 'Subsection Deleted Successfully', 'id' => $subSection->id]);
    } catch (\Exception $e) {
      if ($e->getMessage() === "Cannot delete Subsection, It is related to other tables") {
        return response()->json(['status' => false, 'msg' => $e->getMessage()], 403);
      }
      return response()->json(['status' => false, 'msg' => 'An error occurred while deleting the Subsection.'], 500);
    }
  }
}
