<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Drink, DrinkTranslation};
use Illuminate\Http\Request;
use App\Http\Requests\dash\DE\StoreDrinkRequest;
use App\Helpers\Helpers;

class DrinkController extends Controller
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

  public function store(StoreDrinkRequest $request)
  {
    $drink = new Drink;
    $drink->price = $request->price;
    $drink->store_id = $request->store_id;

    // // Handle image upload
    if ($request->hasFile('image')) {

      $image = $request->file('image');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/drinks/');
      $drink->image = $imagePath;
    }

    // Save the drink to get the ID
    $drink->save();


    DrinkTranslation::create(['name' => $request->name_en, "drink_id" => $drink->id, "locale" => "en"]);
    DrinkTranslation::create(['name' => $request->name_ar, "locale" => "ar", "drink_id" => $drink->id]);



    if ($drink) {
      return response()->json([
        'status' => true,
        'message' => 'Drink Added Successfully',
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Failed to add Drink',
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Drink  $drink
   * @return \Illuminate\Http\Response
   */
  public function show(Drink $drink)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Drink  $drink
   * @return \Illuminate\Http\Response
   */
  public function edit(Drink $drink)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Drink  $drink
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Drink $drink)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Drink  $drink
   * @return \Illuminate\Http\Response
   */


  public function destroy($drink)
  {
    try {
      $drink = Drink::findOrFail($drink);
      $drink->delete();

      return response()->json(['status' => true, 'msg' => "Drink Deleted Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }


}
