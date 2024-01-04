<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\ItemAddon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
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
  public function store(Request $request)
  {

    try {

      foreach ($request->input('addons') as $addonId) {
        ItemAddon::updateOrCreate(["item_id" => $request->item_id, "addon_id" => $addonId]);
      }

      return response()->json([
        "status" => true,
        "message" => "Addons updated successfully"
      ]);
    } catch (\Exception $e) {

      return response()->json(['status' => false, 'msg' => "An error occurred while Add the Addon."], 500);
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
  public function delete(Addon $addon, $item)
  {
    try {

      $item = ItemAddon::where("addon_id", $addon->id)->where("item_id", $item)->first();
      $item->delete();

      return response()->json(['status' => true, 'msg' => "Addon Deleted Successfully", "id" => $addon->id]);
    } catch (\Exception $e) {

      return response()->json(['status' => false, 'msg' => $e->getMessage()], 500);


    }
  }


  public function destroy(Addon $addon)
  {

  }

}
