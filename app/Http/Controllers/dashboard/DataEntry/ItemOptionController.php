<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Option, Item, OptionTranslation};
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Http\Requests\dash\DE\OptionStoreRequest;

class ItemOptionController extends Controller
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
  public function store(OptionStoreRequest $request)
  {

    $item = Item::whereId($request->item_id)->first();
    $option = new Option;

    $option->price = $request->price;
    $option->item_id = $request->item_id;
    $option->store_id = $request->store_id;


    // // Handle image upload
    if ($request->hasFile('image')) {

      $image = $request->file('image');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/options/');
      $option->image = $imagePath;
    }

    // Save the option to get the ID
    $option->save();

    // Create translations with the Ingredient ID
    OptionTranslation::create(['name' => $request->name_en, 'option_id' => $option->id, 'locale' => 'en']);
    OptionTranslation::create(['name' => $request->name_ar, 'option_id' => $option->id, 'locale' => 'ar']);

    if ($option) {
      return response()->json([
        'status' => true,
        'message' => 'Option Added Successfully',
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Failed to add Option',
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Option  $option
   * @return \Illuminate\Http\Response
   */
  public function show(Option $option)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Option  $option
   * @return \Illuminate\Http\Response
   */
  public function edit(Option $option)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Option  $option
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Option $option)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Option  $option
   * @return \Illuminate\Http\Response
   */
  public function destroy($itemoption)
  {
    try {
      $option = Option::where("id", $itemoption)->first();
      $option->translations()->delete();
      $option->delete();
      return response()->json(['status' => true, 'msg' => "Option Deleted Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }

  }
}
