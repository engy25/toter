<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;
use App\Http\Requests\dash\DE\StoreAddonRequest;
use App\Helpers\Helpers;

class AddController extends Controller
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
  public function store(StoreAddonRequest $request)
  {
    $addon = new Addon;
    $addon->name = $request->name;
    $addon->price = $request->price;
    $addon->store_id = $request->store_id;

    // // Handle image upload
    if ($request->hasFile('image')) {

      $image = $request->file('image');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/addons/');
      $addon->image = $imagePath;
    }

    // Save the ingredient to get the ID
    $addon->save();



    if ($addon) {
      return response()->json([
        'status' => true,
        'message' => 'Addon Added Successfully',
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Failed to add Addon',
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Addon  $addon
   * @return \Illuminate\Http\Response
   */
  public function show(Addon $addon)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Addon  $addon
   * @return \Illuminate\Http\Response
   */
  public function edit(Addon $addon)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Addon  $addon
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Addon $addon)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Addon  $addon
   * @return \Illuminate\Http\Response
   */
  // public function destroy(Addon $add)
  // {
  //   try {
  //     $add->delete();
  //     return response()->json(['status' => true, 'msg' => "Addon Deleted Successfully", "id" => $add->id]);
  //   } catch (\Exception $e) {

  //     return response()->json(['status' => false, 'msg' => "An error occurred while deleting the Addon."], 500);
  //   }

  // }


  public function destroy($add)
  {
    try {
      $addon = Addon::findOrFail($add);
      $addon->delete();

      return response()->json(['status' => true, 'msg' => "Addon Deleted Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }

}
