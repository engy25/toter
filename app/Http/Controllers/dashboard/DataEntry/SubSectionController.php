<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Http\Requests\dash\DE\updateSubsectionRequest;
use App\Models\{Subsection, SubsectionTranslation,Section};
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

  public function searchSubsection(Request $request)
  {
    $locale = LaravelLocalization::getCurrentLocale();
    $searchString = '%' . $request->search_string . '%';

    $subsections = Subsection::where(function ($query) use ($searchString) {
      $query->whereHas('section.translations', function ($subQuery) use ($searchString) {
        $subQuery->where('name', 'like', $searchString);
      })->orWhereHas('translations', function ($subQuery) use ($searchString) {
        $subQuery->where('name', 'like', $searchString)
          ->orWhere('description', 'like', $searchString);
      });
    })
      ->with([
        'section' => function ($query) {
          $query->select('id');
        },
        'translations' => function ($query) use ($locale) {
          $query->select('sub_section_id', 'name')->where("locale", $locale);
        },
      ])
      ->latest()
      ->paginate(PAGINATION_COUNT);


    if ($subsections->count() > 0) {
      // Return the search results as HTML
      return view("content.subsection.pagination_index", compact("subsections"))->render();
    } else {
      return response()->json([
        "status" => 'nothing_found',
      ]);
    }
  }
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
  public function show(Subsection $subsection)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\SubSection  $subSection
   * @return \Illuminate\Http\Response
   */
  public function edit(Subsection $subsection)
  {
    // You may need to load additional data if required for the edit view
    $sections = Section::valid()->get();
    return view("content.subsection.update", compact("subsection","sections"));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\SubSection  $subSection
   * @return \Illuminate\Http\Response
   */


  public function update(updateSubsectionRequest $request, Subsection $subsection)
  {

    $subsection->section_id=$request->section_id;

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/subsections/');
      $subsection->image = $imagePath;

    }
    $subsection->save();

    $subsectionTranslation_en=$subsection->translate("en");
    $subsectionTranslation_en->name=$request->name_en;
    $subsectionTranslation_en->description=$request->description_en;
    $subsectionTranslation_en->save();

    $subsectionTranslation_ar=$subsection->translate("ar");
    $subsectionTranslation_ar->name=$request->name_ar;
    $subsectionTranslation_ar->description=$request->description_ar;
    $subsectionTranslation_ar->save();
    return redirect()->route('subsections.index')->with('success', 'Subsection has been updated successfully.');
  }





  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\SubSection  $subSection
   * @return \Illuminate\Http\Response
   */





  public function destroy($subsection)
  {
    try {
      $Thesubsection = Subsection::where("id", $subsection)->first();
      $Thesubsection->translations()->delete();
      $Thesubsection->delete();
      return response()->json(['status' => true, 'msg' => "Subsection Deleted Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }

  }
}

