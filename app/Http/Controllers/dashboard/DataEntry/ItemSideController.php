<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Side,Item,SideTranslation};
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Http\Requests\dash\DE\SideStoreRequest;
class ItemSideController extends Controller
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
  public function store(SideStoreRequest $request)
  {
    $item = Item::whereId($request->item_id)->first();
    $side = new Side;

    $side->price = $request->price;
    $side->item_id = $request->item_id;
    $side->store_id = $request->store_id;


    // // Handle image upload
    if ($request->hasFile('sideImage')) {

      $image = $request->file('sideImage');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/sides/');
      $side->image = $imagePath;
    }

    // Save the side to get the ID
    $side->save();

    // Create translations with the Ingredient ID
    SideTranslation::create(['name' => $request->name_en, 'side_id' => $side->id, 'locale' => 'en']);
    SideTranslation::create(['name' => $request->name_ar, 'side_id' => $side->id, 'locale' => 'ar']);

    if ($side) {
      return response()->json([
        'status' => true,
        'message' => 'Side Added Successfully',
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Failed to add Side',
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Side  $side
   * @return \Illuminate\Http\Response
   */
  public function show(Side $side)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Side  $side
   * @return \Illuminate\Http\Response
   */
  public function edit(Side $side)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Side  $side
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Side $side)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Side  $side
   * @return \Illuminate\Http\Response
   */
  public function destroy($itemside)
  {
    try {

      $side = Side::where("id",$itemside)->first();
      $side->translations()->delete();
      $side->delete();

      return response()->json(['status' => true, 'msg' => "Side Deleted Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }

  }
}
