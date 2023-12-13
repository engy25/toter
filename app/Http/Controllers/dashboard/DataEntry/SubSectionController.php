<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\SubSection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SubSectionController extends Controller
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
        'translations' => function ($query) {
          $query->select('city_id', 'name');
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

    $subsections = SubSection::ValidWeb()

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

    $subsections = SubSection::ValidWeb()

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
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\SubSection  $subSection
   * @return \Illuminate\Http\Response
   */
  public function show(SubSection $subSection)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\SubSection  $subSection
   * @return \Illuminate\Http\Response
   */
  public function edit(SubSection $subSection)
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
  public function update(Request $request, SubSection $subSection)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\SubSection  $subSection
   * @return \Illuminate\Http\Response
   */


  public function destroy(SubSection $subSection)
  {
    try {
      $subSection->delete();
      return response()->json(['status' => true, 'msg' => "Subsection Deleted Successfully", "id" => $subSection->id]);
    } catch (\Exception $e) {
      if ($e->getMessage() === "Cannot delete Subsection, It is related to other tables") {
        return response()->json(['status' => false, 'msg' => $e->getMessage()], 403);
      }
      return response()->json(['status' => false, 'msg' => "An error occurred while deleting the Subsection."], 500);
    }
  }

}
