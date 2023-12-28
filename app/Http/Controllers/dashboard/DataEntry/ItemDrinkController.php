<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\Drink;
use App\Models\ItemDrink;
use Illuminate\Http\Request;

class ItemDrinkController extends Controller
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

      foreach ($request->drinks as $drinkId) {
        ItemDrink::updateOrCreate(["item_id" => $request->item_id, "drink_id" => $drinkId]);
      }

      return response()->json([
        "status" => true,
        "message" => "Drink updated successfully"
      ]);
    } catch (\Exception $e) {

      return response()->json(['status' => false, 'msg' => "An error occurred while Add the Drink."], 500);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Drink  $drink
   * @return \Illuminate\Http\Response
   */
  public function show(Drink $itemdrink)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Drink  $drink
   * @return \Illuminate\Http\Response
   */
  public function edit(Drink $itemdrink)
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
  public function update(Request $request, Drink $itemdrink)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Drink  $drink
   * @return \Illuminate\Http\Response
   */


  public function destroy($itemdrink)
  {
  //   try {
  //     $drink = ItemDrink::where("drink_id",$itemdrink);
  //     $drink->delete();

  //     return response()->json(['status' => true, 'msg' => "Drink Deleted Successfully"]);
  //   } catch (\Exception $e) {
  //     return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
  //   }
  // }
  }
  public function delete($item_id,$drink_id)
  {
    try {
      $drink = ItemDrink::where("drink_id",$drink_id)->where("item_id",$item_id)->first();
      $drink->delete();

      return response()->json(['status' => true, 'msg' => "Drink Deleted Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }

  }

}
