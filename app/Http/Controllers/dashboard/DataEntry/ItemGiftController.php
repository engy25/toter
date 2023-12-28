<?php

namespace App\Http\Controllers\Dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{ItemGift, Item};
use Illuminate\Http\Request;
use App\Http\Requests\dash\DE\GiftStoreRequest;
use App\Helpers\Helpers;

class ItemGiftController extends Controller
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
  public function store(GiftStoreRequest $request)
  {
    $item = Item::whereId($request->item_id)->first();
    $gift = new ItemGift;
    $gift->name = $request->name;
    $gift->item_id = $request->item_id;


    // // Handle image upload
    if ($request->hasFile('giftImage')) {

      $image = $request->file('giftImage');
      $imagePath = $this->helper->upload_single_file($image, 'app/public/images/gifts/');
      $gift->image = $imagePath;
    }

    // Save the gift to get the ID
    $gift->save();



    if ($gift) {
      return response()->json([
        'status' => true,
        'message' => 'Gift Added Successfully',
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'Failed to add Gift',
      ], 500); // Internal Server Error status code
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\ItemGift  $itemGift
   * @return \Illuminate\Http\Response
   */
  public function show(ItemGift $itemGift)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\ItemGift  $itemGift
   * @return \Illuminate\Http\Response
   */
  public function edit(ItemGift $itemGift)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ItemGift  $itemGift
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ItemGift $itemGift)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ItemGift  $itemGift
   * @return \Illuminate\Http\Response
   */
  public function destroy($itemgift)
  {
    try {
      $gift = ItemGift::where("id", $itemgift)->first();
      $gift->delete();
      return response()->json(['status' => true, 'msg' => "Gift Deleted Successfully"]);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }

  }
}
