<?php

namespace App\Http\Controllers\dashboard\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\{Size,Item,SizeTranslation};
use Illuminate\Http\Request;
use App\Http\Requests\dash\DE\SizeStoreRequest;
class ItemSizeController extends Controller
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
    public function store(SizeStoreRequest $request)
    {
      $item = Item::whereId($request->item_id)->first();
      $size = new Size;

      $size->price = $request->price;
      $size->item_id = $request->item_id;
      $size->store_id = $request->store_id;

      // Save the size to get the ID
      $size->save();

      // Create translations with the Ingredient ID
      SizeTranslation::create(['name' => $request->name_en, 'size_id' => $size->id, 'locale' => 'en']);
      SizeTranslation::create(['name' => $request->name_ar, 'size_id' => $size->id, 'locale' => 'ar']);

      if ($size) {
        return response()->json([
          'status' => true,
          'message' => 'Size Added Successfully',
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Failed to add Size',
        ], 500); // Internal Server Error status code
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Size $size)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy($itemsize)
    {
      try {

        $size = Size::where("id",$itemsize)->first();
        $size->translations()->delete();
        $size->delete();

        return response()->json(['status' => true, 'msg' => "Size Deleted Successfully"]);
      } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
      }

    }
}
